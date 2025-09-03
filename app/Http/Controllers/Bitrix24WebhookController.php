<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotification;

class Bitrix24WebhookController extends Controller
{
    public function updateStatus(Request $request): JsonResponse
    {
        $secret = (string) config('bitrix24.incoming_secret', '');
        // Allow secret to be passed as header or param (token/secret) via query or body
        $token = (string) ($request->header('X-B24-Secret')
            ?? $request->input('token')
            ?? $request->query('token')
            ?? $request->input('secret')
            ?? $request->query('secret'));
        if (empty($secret) || !hash_equals($secret, $token)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Accept params from JSON, form, or query string
        $uuid = (string) ($request->input('uuid', '') ?: $request->query('uuid', ''));
        $statusText = trim((string) ($request->input('status', '')
            ?: $request->input('stage_name', '')
            ?: $request->input('stage', '')
            ?: $request->input('status_name', '')
            ?: $request->input('STATUS_ID', '')
            ?: $request->input('STAGE_ID_NAME', '')
            ?: $request->query('status', '')
            ?: $request->query('stage_name', '')
            ?: $request->query('stage', '')
            ?: $request->query('status_name', '')
            ?: $request->query('STATUS_ID', '')
            ?: $request->query('STAGE_ID_NAME', '')));

        // Try to resolve order by uuid/id/order_id
        $order = null;
        if ($uuid !== '') {
            if ($this->looksLikeUuid($uuid)) {
                $order = Order::where('uuid', $uuid)->first();
            } elseif (ctype_digit($uuid)) {
                $order = Order::find((int) $uuid);
            }
        }

        if (!$order) {
            $id = (string) ($request->input('id', '') ?: $request->query('id', ''));
            if ($id !== '') {
                if ($this->looksLikeUuid($id)) {
                    $order = Order::where('uuid', $id)->first();
                } elseif (ctype_digit($id)) {
                    $order = Order::find((int) $id);
                }
            }
        }

        if (!$order) {
            $orderIdRaw = (string) ($request->input('order_id', '') ?: $request->query('order_id', ''));
            if ($orderIdRaw !== '') {
                if ($this->looksLikeUuid($orderIdRaw)) {
                    $order = Order::where('uuid', $orderIdRaw)->first();
                }
                if (!$order && preg_match('/#?(\d{1,10})/', $orderIdRaw, $m)) {
                    $order = Order::find((int) $m[1]);
                }
            }
        }

        // Fallback: if only Bitrix deal id is provided, pull the deal and read our custom field
        if (!$order) {
            $dealId = (string) ($request->input('deal_id', '')
                ?: $request->input('ID', '')
                ?: $request->query('deal_id', '')
                ?: $request->query('ID', ''));
            $b24Base = rtrim((string) config('bitrix24.webhook_url', ''), '/') . '/';
            $orderUuidField = (string) config('bitrix24.order_uuid_field', '');
            if ($dealId !== '' && $b24Base !== '' && $orderUuidField !== '' && ctype_digit($dealId)) {
                try {
                    $resp = Http::timeout(10)->asForm()->post($b24Base . 'crm.deal.get.json', [
                        'id' => (int) $dealId,
                    ])->json();
                    $fields = $resp['result'] ?? null;
                    if (is_array($fields) && array_key_exists($orderUuidField, $fields)) {
                        $val = (string) ($fields[$orderUuidField] ?? '');
                        if ($val !== '') {
                            if ($this->looksLikeUuid($val)) {
                                $order = Order::where('uuid', $val)->first();
                            } elseif (ctype_digit($val)) {
                                $order = Order::find((int) $val);
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('Bitrix24 deal.get failed in webhook', ['message' => $e->getMessage()]);
                }
            }
        }

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($statusText === '') {
            return response()->json(['message' => 'status is required'], 422);
        }

        $order->public_status = mb_substr($statusText, 0, 255);
        $order->save();

        // Email only the client about status change
        try {
            if (!empty($order->email)) {
                $subject = 'Статус заказа ' . (string) $order->uuid . ' обновлён';
                $heading = 'Статус вашего заказа обновлён';
                $text = 'Текущий статус: ' . (string) $order->public_status;
                Mail::to((string) $order->email)
                    ->send(new OrderNotification($order, $subject, $heading, $text));
            }
        } catch (\Throwable $e) {
            Log::warning('Order status email failed', ['order_id' => $order->id, 'message' => $e->getMessage()]);
        }

        return response()->json(['message' => 'ok']);
    }

    private function looksLikeUuid(string $value): bool
    {
        return (bool) preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $value);
    }
}
