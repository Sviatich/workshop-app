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
];

