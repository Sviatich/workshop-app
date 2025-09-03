<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Order;

class Bitrix24WebhookController extends Controller
{
    public function updateStatus(Request $request): JsonResponse
    {
        $secret = (string) config('bitrix24.incoming_secret', '');
        $token = (string) ($request->header('X-B24-Secret') ?? $request->input('secret'));
        if (empty($secret) || !hash_equals($secret, $token)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Accept either JSON or form params
        $uuid = (string) $request->input('uuid', '');
        $statusText = trim((string) $request->input('status', ''));

        if ($uuid === '' || $statusText === '') {
            return response()->json(['message' => 'uuid and status are required'], 422);
        }

        $order = Order::where('uuid', $uuid)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->public_status = mb_substr($statusText, 0, 255);
        $order->save();

        return response()->json(['message' => 'ok']);
    }
}


