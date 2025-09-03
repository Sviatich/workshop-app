<?php

return [
    'enabled' => env('BITRIX24_ENABLED', false),
    // Full incoming webhook base URL, e.g. https://example.bitrix24.ru/rest/1/xxxxxxxxxxxxxxxx/
    'webhook_url' => env('BITRIX24_WEBHOOK_URL', ''),

    // Deal pipeline (category) id, e.g. 1
    'category_id' => (int) env('BITRIX24_CATEGORY_ID', 0),

    // Optional stage id (e.g. C1:NEW). If not provided and category set, C{category}:NEW is used.
    'stage_id' => env('BITRIX24_STAGE_ID', null),

    // Responsible user id in Bitrix24 (optional)
    'assigned_by_id' => (int) env('BITRIX24_ASSIGNED_BY_ID', 0),

    // Currency for opportunity
    'currency_id' => env('BITRIX24_CURRENCY_ID', 'RUB'),

    // Try to create a Contact and link it to the deal
    'create_contact' => env('BITRIX24_CREATE_CONTACT', true),

    // Try to attach product rows to the deal based on order items
    'add_product_rows' => env('BITRIX24_ADD_PRODUCT_ROWS', true),

    // Include direct links to uploaded files in a timeline comment
    'include_file_links' => env('BITRIX24_INCLUDE_FILE_LINKS', true),

    // Max total size (in MB) for attempting inline file attachments via REST activities
    // Note: actual file attachments via REST are best-effort and may fall back to links
    'max_attachment_mb' => (int) env('BITRIX24_MAX_ATTACHMENT_MB', 5),
];
