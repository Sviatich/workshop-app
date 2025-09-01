<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Bitrix24Service
{
    private string $webhookBase;
    private bool $enabled;
    private int $categoryId;
    private ?string $stageId;
    private int $assignedById;
    private string $currency;
    private bool $createContact;

    public function __construct()
    {
        $this->enabled = (bool) config('bitrix24.enabled', false);
        $this->webhookBase = rtrim((string) config('bitrix24.webhook_url', ''), '/') . '/';
        $this->categoryId = (int) config('bitrix24.category_id', 0);
        $this->stageId = config('bitrix24.stage_id');
        $this->assignedById = (int) config('bitrix24.assigned_by_id', 0);
        $this->currency = (string) config('bitrix24.currency_id', 'RUB');
        $this->createContact = (bool) config('bitrix24.create_contact', true);
    }

    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->webhookBase);
    }

    public function createDealFromOrder(Order $order): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        try {
            $order->loadMissing('items');

            $contactId = null;
            if ($this->createContact) {
                $contactId = $this->ensureContact($order);
            }

            $title = sprintf('Заказ %s (%s)', $order->uuid, $order->full_name);
            $comments = $this->buildComments($order);

            $fields = [
                'TITLE' => $title,
                'OPENED' => 'Y',
                'OPPORTUNITY' => (float) $order->total_price,
                'CURRENCY_ID' => $this->currency,
                'COMMENTS' => $comments,
            ];

            if ($this->categoryId > 0) {
                $fields['CATEGORY_ID'] = $this->categoryId;
                // Prefer explicit stage id if provided; else target NEW in the category
                $fields['STAGE_ID'] = $this->stageId ?: ('C' . $this->categoryId . ':NEW');
            } elseif (!empty($this->stageId)) {
                $fields['STAGE_ID'] = $this->stageId;
            }

            if ($this->assignedById > 0) {
                $fields['ASSIGNED_BY_ID'] = $this->assignedById;
            }

            if ($contactId) {
                $fields['CONTACT_ID'] = $contactId;
            }

            $response = $this->b24('crm.deal.add.json', [
                'fields' => $fields,
            ]);

            if (!isset($response['result'])) {
                $err = $response['error_description'] ?? json_encode($response, JSON_UNESCAPED_UNICODE);
                Log::warning('Bitrix24: deal add failed', ['err' => $err]);
            } else {
                Log::info('Bitrix24: deal added', ['deal_id' => $response['result']]);
            }
        } catch (\Throwable $e) {
            Log::error('Bitrix24: exception during deal creation', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function ensureContact(Order $order): ?int
    {
        try {
            // Create a contact; Bitrix24 will try to merge by phone/email if dedup enabled
            [$name, $lastName] = $this->splitName($order->full_name);
            $fields = [
                'NAME' => $name,
                'LAST_NAME' => $lastName,
                'OPENED' => 'Y',
                'TYPE_ID' => 'CLIENT',
            ];

            if ($this->assignedById > 0) {
                $fields['ASSIGNED_BY_ID'] = $this->assignedById;
            }

            if (!empty($order->phone)) {
                $fields['PHONE'] = [[
                    'VALUE' => $order->phone,
                    'VALUE_TYPE' => 'WORK',
                ]];
            }

            if (!empty($order->email)) {
                $fields['EMAIL'] = [[
                    'VALUE' => $order->email,
                    'VALUE_TYPE' => 'WORK',
                ]];
            }

            $response = $this->b24('crm.contact.add.json', [
                'fields' => $fields,
            ]);

            return isset($response['result']) ? (int) $response['result'] : null;
        } catch (\Throwable $e) {
            Log::warning('Bitrix24: contact creation failed', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    private function buildComments(Order $order): string
    {
        $lines = [];
        $lines[] = 'Детали заказа:';
        $lines[] = sprintf('Сумма: %0.2f %s', (float) $order->total_price, $this->currency);
        $lines[] = sprintf('Плательщик: %s (%s)', $order->full_name, $order->payer_type);
        if ($order->inn) {
            $lines[] = 'ИНН: ' . $order->inn;
        }
        if ($order->delivery_address) {
            $lines[] = 'Доставка: ' . $order->delivery_address;
        }
        if ($order->delivery_price !== null) {
            $lines[] = sprintf('Стоимость доставки: %0.2f', (float) $order->delivery_price);
        }

        $lines[] = '';
        $lines[] = 'Позиции:';
        foreach ($order->items as $idx => $item) {
            $cfg = $item->config_json;
            // Ensure array
            if (is_string($cfg)) {
                $cfg = json_decode($cfg, true) ?: [];
            }
            $construction = Arr::get($cfg, 'construction_name', Arr::get($cfg, 'construction', ''));
            $color = Arr::get($cfg, 'color_name', Arr::get($cfg, 'color', ''));
            $length = Arr::get($cfg, 'length');
            $width = Arr::get($cfg, 'width');
            $height = Arr::get($cfg, 'height');
            $tirage = Arr::get($cfg, 'tirage');
            $logo = Arr::get($cfg, 'logo.enabled') ? 'да' : 'нет';
            $full = Arr::get($cfg, 'fullprint.enabled') ? 'да' : 'нет';

            $lines[] = sprintf(
                '%d) %s, цвет: %s, %sx%sx%s, тираж: %s, логотип: %s, полноцвет: %s, цена за шт: %0.2f, сумма: %0.2f',
                $idx + 1,
                (string) $construction,
                (string) $color,
                (string) $length,
                (string) $width,
                (string) ($height ?? '-'),
                (string) $tirage,
                $logo,
                $full,
                (float) $item->price_per_unit,
                (float) $item->total_price,
            );
        }

        return implode("\n", $lines);
    }

    private function b24(string $method, array $payload): array
    {
        $url = $this->webhookBase . ltrim($method, '/');
        $resp = Http::timeout(10)->asForm()->post($url, $payload);

        if ($resp->failed()) {
            return [
                'error' => 'HTTP_ERROR',
                'error_description' => $resp->body(),
            ];
        }

        return $resp->json() ?? [];
    }

    private function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/u', trim($fullName)) ?: [];
        $name = $parts[0] ?? 'Клиент';
        $lastName = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : '';
        return [$name, $lastName];
    }
}
