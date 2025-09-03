Bitrix24 robots webhook (reverse status)

- Configure secret: set `BITRIX24_INCOMING_SECRET=your_long_secret` in `.env`.
- Deal user field for UUID: set `BITRIX24_ORDER_UUID_FIELD` to the internal field code like `UF_CRM_1756930939`.
- Robot HTTP request example:
  - URL: `{APP_URL}/api/b24/status?token=YOUR_SECRET&uuid={{UF_CRM_1756930939}}&status={{=Параметры.Стадия сделки}}`
  - Allowed methods: GET or POST; send params in query or body (form-data/x-www-form-urlencoded). No headers required.
  - Instead of `uuid`, you can pass `order_id` (e.g., `123` or `#123`), or `deal_id` / `ID`. With `deal_id`, the service fetches the deal and reads the configured user field to resolve the order.
  - Status param can be named `status`, `stage_name`, `stage`, `status_name`, `STATUS_ID`, or `STAGE_ID_NAME`.

Outbound (deal creation):

- The service writes the local order UUID to the configured Bitrix24 user field on deal creation.
- Ensure the custom field type in Bitrix24 is suitable for storing a UUID (string/text).
