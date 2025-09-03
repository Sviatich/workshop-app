<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Bitrix24Service
{
    private string $webhookBase;
    private bool $enabled;
    private int $categoryId;
    private ?string $stageId;
    private int $assignedById;
    private string $currency;
    private bool $createContact;
    private bool $addProductRows;
    private bool $includeFileLinks;
    private int $maxAttachmentBytes;

    public function __construct()
    {
        $this->enabled = (bool) config('bitrix24.enabled', false);
        $this->webhookBase = rtrim((string) config('bitrix24.webhook_url', ''), '/') . '/';
        $this->categoryId = (int) config('bitrix24.category_id', 0);
        $this->stageId = config('bitrix24.stage_id');
        $this->assignedById = (int) config('bitrix24.assigned_by_id', 0);
        $this->currency = (string) config('bitrix24.currency_id', 'RUB');
        $this->createContact = (bool) config('bitrix24.create_contact', true);
        $this->addProductRows = (bool) config('bitrix24.add_product_rows', true);
        $this->includeFileLinks = (bool) config('bitrix24.include_file_links', true);
        $this->maxAttachmentBytes = ((int) config('bitrix24.max_attachment_mb', 5)) * 1024 * 1024;
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
            $order->loadMissing(['items.files', 'deliveryMethod']);

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

    // Improved variant with enriched title, link, product rows and file links
    public function createDealFromOrderV2(Order $order): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        try {
            $order->loadMissing(['items.files', 'deliveryMethod']);

            $contactId = null;
            if ($this->createContact) {
                $contactId = $this->ensureContact($order);
            }

            // Title: #<id> | Заказ <ФИО/Компания> | на <N> коробов
            $boxCount = 0;
            foreach ($order->items as $it) {
                $cfg = is_array($it->config_json) ? $it->config_json : (json_decode((string) $it->config_json, true) ?: []);
                $boxCount += (int) Arr::get($cfg, 'tirage', 0);
            }
            $displayName = $order->payer_type === 'company' && !empty($order->company_name)
                ? $order->company_name
                : $order->full_name;
            $title = sprintf('#%d | Заказ %s | на %d коробов', (int) $order->id, (string) $displayName, (int) $boxCount);
            $comments = $this->buildCommentsV2($order);

            $fields = [
                'TITLE' => $title,
                'OPENED' => 'Y',
                'OPPORTUNITY' => (float) $order->total_price,
                'CURRENCY_ID' => $this->currency,
                'COMMENTS' => $comments,
            ];

            if ($this->categoryId > 0) {
                $fields['CATEGORY_ID'] = $this->categoryId;
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
                return;
            }

            $dealId = (int) $response['result'];
            Log::info('Bitrix24: deal added (v2)', ['deal_id' => $dealId]);

            if ($this->addProductRows) {
                $this->setProductRows($dealId, $order);
            }

            // Try to attach files as an activity if total size allows; otherwise fall back to links
            $attached = $this->addFilesActivity($dealId, $order);
            if ($this->includeFileLinks && !$attached) {
                $this->addFilesComment($dealId, $order);
            }
        } catch (\Throwable $e) {
            Log::error('Bitrix24: exception during deal creation (v2)', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function buildCommentsV2(Order $order): string
    {
        $lines = [];
        $baseUrl = rtrim((string) config('app.url'), '/');
        $orderUrl = $baseUrl . '/order/' . $order->uuid;

        $lines[] = 'Ссылка на заказ: ' . $orderUrl;
        $lines[] = sprintf('Итого к оплате: %0.2f %s', (float) $order->total_price, $this->currency);

        $who = $order->payer_type === 'company' ? 'Юрлицо / ИП' : 'Физлицо';
        $nameOrCompany = $order->payer_type === 'company' && !empty($order->company_name)
            ? $order->company_name
            : $order->full_name;
        $lines[] = sprintf('Плательщик: %s — %s', $who, $nameOrCompany);
        if (!empty($order->full_name) && $order->payer_type === 'company') {
            $lines[] = 'Контактное лицо: ' . $order->full_name;
        }
        if (!empty($order->inn)) {
            $lines[] = 'ИНН: ' . $order->inn;
        }
        if (!empty($order->phone)) {
            $lines[] = 'Телефон: ' . $order->phone;
        }
        if (!empty($order->email)) {
            $lines[] = 'Email: ' . $order->email;
        }

        if ($order->deliveryMethod) {
            $lines[] = 'Способ доставки: ' . $order->deliveryMethod->name . ' (' . $order->deliveryMethod->code . ')';
        }
        if (!empty($order->delivery_address)) {
            $lines[] = 'Адрес доставки: ' . $order->delivery_address;
        }
        if ($order->delivery_price !== null) {
            $lines[] = sprintf('Стоимость доставки: %0.2f', (float) $order->delivery_price);
        }

        $lines[] = '';
        $lines[] = 'Позиции заказа:';
        foreach ($order->items as $idx => $item) {
            $cfg = is_array($item->config_json) ? $item->config_json : (json_decode((string) $item->config_json, true) ?: []);
            $construction = (string) Arr::get($cfg, 'construction_name', Arr::get($cfg, 'construction', ''));
            $color = (string) Arr::get($cfg, 'color_name', Arr::get($cfg, 'color', ''));
            $length = (string) Arr::get($cfg, 'length', '');
            $width = (string) Arr::get($cfg, 'width', '');
            $height = (string) (Arr::get($cfg, 'height') ?? '-');
            $tirage = (string) Arr::get($cfg, 'tirage', '');
            $logo = Arr::get($cfg, 'logo.enabled') ? 'Да' : 'Нет';
            $full = Arr::get($cfg, 'fullprint.enabled') ? 'Да' : 'Нет';

            $lines[] = sprintf(
                '%d) %s, цвет: %s, %sx%sx%s, тираж: %s, лого: %s, полноцвет: %s, цена/шт: %0.2f, сумма: %0.2f',
                $idx + 1,
                $construction,
                $color,
                $length,
                $width,
                $height,
                $tirage,
                $logo,
                $full,
                (float) $item->price_per_unit,
                (float) $item->total_price,
            );
        }

        return implode("\n", $lines);
    }

    private function setProductRows(int $dealId, Order $order): void
    {
        try {
            $rows = [];
            foreach ($order->items as $item) {
                $cfg = is_array($item->config_json) ? $item->config_json : (json_decode((string) $item->config_json, true) ?: []);
                $nameParts = [];
                $nameParts[] = (string) Arr::get($cfg, 'construction_name', Arr::get($cfg, 'construction', 'Изделие'));
                $nameParts[] = 'цвет ' . (string) Arr::get($cfg, 'color_name', Arr::get($cfg, 'color', ''));
                $dims = [];
                foreach (['length','width','height'] as $k) {
                    $val = Arr::get($cfg, $k);
                    if ($val !== null && $val !== '') { $dims[] = (string) $val; }
                }
                if (!empty($dims)) {
                    $nameParts[] = implode('x', $dims);
                }
                if (Arr::get($cfg, 'logo.enabled')) { $nameParts[] = 'лого'; }
                if (Arr::get($cfg, 'fullprint.enabled')) { $nameParts[] = 'полноцвет'; }

                $rows[] = [
                    'PRODUCT_NAME' => implode(', ', array_filter($nameParts)),
                    'PRICE' => (float) $item->price_per_unit,
                    'QUANTITY' => (int) Arr::get($cfg, 'tirage', 1),
                    'TAX_INCLUDED' => 'Y',
                ];
            }

            if (!empty($rows)) {
                $resp = $this->b24('crm.deal.productrows.set.json', [
                    'id' => $dealId,
                    'rows' => $rows,
                ]);
                if (!isset($resp['result']) || $resp['result'] !== true) {
                    Log::warning('Bitrix24: product rows set failed', ['deal_id' => $dealId, 'resp' => $resp]);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Bitrix24: product rows exception', ['message' => $e->getMessage()]);
        }
    }

    private function addFilesComment(int $dealId, Order $order): void
    {
        try {
            $files = [];
            foreach ($order->items as $item) {
                foreach ($item->files as $file) {
                    $url = Storage::disk('public')->url($file->file_path);
                    $files[] = [
                        'type' => $file->file_type,
                        'name' => basename((string) $file->file_path),
                        'url' => $url,
                    ];
                }
            }

            if (empty($files)) {
                return;
            }

            $lines = [ 'Файлы заказа:' ];
            foreach ($files as $f) {
                $lines[] = sprintf('- %s: %s (%s)', $f['type'], $f['name'], $f['url']);
            }
            $comment = implode("\n", $lines);

            $resp = $this->b24('crm.timeline.comment.add.json', [
                'fields' => [
                    'ENTITY_TYPE' => 'deal',
                    'ENTITY_ID' => $dealId,
                    'COMMENT' => $comment,
                ],
            ]);
            if (!isset($resp['result'])) {
                Log::warning('Bitrix24: files comment failed', ['deal_id' => $dealId, 'resp' => $resp]);
            }
        } catch (\Throwable $e) {
            Log::warning('Bitrix24: add files comment exception', ['message' => $e->getMessage()]);
        }
    }

    // Best-effort: attach files to the deal timeline via CRM Activity with inline file data
    // Returns true if an activity with files was created, false otherwise
    private function addFilesActivity(int $dealId, Order $order): bool
    {
        try {
            $filePayload = [];
            $total = 0;
            foreach ($order->items as $item) {
                foreach ($item->files as $file) {
                    $path = Storage::disk('public')->path($file->file_path);
                    if (!is_readable($path)) { continue; }
                    $size = filesize($path) ?: 0;
                    if ($size <= 0) { continue; }
                    if ($total + $size > $this->maxAttachmentBytes) {
                        // Stop if exceeding size threshold
                        break 2;
                    }
                    $content = file_get_contents($path);
                    if ($content === false) { continue; }
                    $total += $size;
                    $filePayload[] = [
                        'fileData' => [ basename((string) $file->file_path), base64_encode($content) ],
                    ];
                }
            }

            if (empty($filePayload)) {
                return false;
            }

            $resp = $this->b24('crm.activity.add.json', [
                'fields' => [
                    'OWNER_ID' => $dealId,
                    'OWNER_TYPE_ID' => 2, // Deal
                    'TYPE_ID' => 4,       // Task
                    'SUBJECT' => 'Вложения заказа',
                    'DESCRIPTION' => 'Файлы, прикреплённые к заказу на сайте',
                    'COMPLETED' => 'N',
                    'FILES' => $filePayload,
                ],
            ]);

            if (isset($resp['result'])) {
                return true;
            }

            Log::warning('Bitrix24: activity with files failed', ['deal_id' => $dealId, 'resp' => $resp ?? null]);
            return false;
        } catch (\Throwable $e) {
            Log::warning('Bitrix24: add files activity exception', ['message' => $e->getMessage()]);
            return false;
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
