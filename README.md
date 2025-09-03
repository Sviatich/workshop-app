## Конфигуратор гофрокоробов на Laravel + Livewire

Проект — MVP конфигуратора и калькулятора заказов на гофроупаковку. Пользователь подбирает конструкцию FEFCO, размеры, цвет картона, дополнительные опции печати и получает расчет. Заказ оформляется с контактами и доставкой, данные сохраняются в БД и (опционально) отправляются в CRM Bitrix24.

—

## Возможности

- Конфигуратор FEFCO: 0427, 0426, 0201, 0215.
- Динамический расчет: цена за единицу, итог, вес, объем; подсказки ближайших размеров из справочника.
- Печать: логотип (+10 ₽ к цене за единицу) и «полная запечатка» (цена 0; заявка уходит на согласование менеджеру).
- Корзина и оформление заказа: контакты, тип плательщика (физ./юр. лицо, ИНН), адрес и способ доставки.
- Доставка: CDEK PVZ и курьер (расчет тарифа по API); своя точка самовывоза и справочные точки ПЭК; карта Яндекс.
- Интеграции: загрузка файлов макетов, Bitrix24 (входящий веб‑хук), Dadata подсказки (ИНН/адрес), Яндекс.Метрика.

—

## Технологии

- Backend: Laravel 12, PHP 8.2, Livewire Volt/Flux, Sanctum.
- Frontend: Vite, Tailwind CSS 4, JavaScript без фреймворков.
- Данные: миграции, сиды; модели заказов, позиций, файлов; справочники конструкций/размеров/цветов.
- Интеграции: CDEK API v2, Dadata Suggestions, Яндекс.Карты v3, Bitrix24 Webhook.
- Тесты: Pest (фичи аутентификации, дашборд, настройки).

—

## Структура

- Роуты: `routes/web.php`, `routes/api.php`, `routes/auth.php`.
- Контроллеры: `app/Http/Controllers/ConfiguratorController.php`, `app/Http/Controllers/OrderController.php`, `app/Http/Controllers/FileUploadController.php`, `app/Http/Controllers/SdekController.php`.
- Сервисы: `app/Services/SdekClient.php`, `app/Services/Bitrix24Service.php`.
- Калькуляторы: `app/Calculators/*` + общий `app/Calculators/BaseCalculator.php`.
- Помощники: `app/Helpers/SizeMatcher.php` (поиск ближайших размеров, exact match).
- Модели/БД: `app/Models/*`, миграции `database/migrations/*`, сиды `database/seeders/*`.
- Представления: `resources/views/configurator.blade.php`, `resources/views/cart.blade.php`, `resources/views/order.blade.php` и частичные блоки.
- Статика/JS: `resources/js/configurator.js`, `resources/js/cart.js`, `resources/js/delivery.js`, `resources/js/cdek.js`, `resources/js/inn-suggest.js`.

—

## Маршруты

- `/` — конфигуратор.
- `/cart` — корзина и оформление доставки/контактов.
- `/order/{uuid}` — страница подтвержденного заказа.
- `/dashboard` и `/settings/*` — личный кабинет (требует авторизации).

—

## API (кратко)

- POST `/api/calculate` — расчет коробки.
  - Вход: `construction` (fefco_0427|fefco_0426|fefco_0201|fefco_0215), `length`, `width`, `height`, `tirage`, `color`, опционально `has_logo`, `has_fullprint`.
  - Выход: `price_per_unit`, `total_price`, `weight`, `volume`, `exact_match`, `nearest_sizes[]`, а также геометрия для доставки (`parcel_*_mm`).
- POST `/api/upload` — загрузка файла макета (`file`), ответ: `file_path`, `filename`.
- POST `/api/order` — создание заказа; `cart` (JSON‑массив конфигураций) + контактные/доставка: `payer_type`, `full_name`, `email`, `phone`, `inn`, `delivery_method_id`, `delivery_price`, `delivery_address` и поля CDEK.
- CDEK:
  - GET `/api/sdek/cities?q=...` — поиск города;
  - GET `/api/sdek/pvz?city_code=...` — список ПВЗ;
  - POST `/api/sdek/calc/pvz` — тариф до ПВЗ;
  - POST `/api/sdek/calc/courier` — тариф курьером.

—

## Установка и запуск

Предпосылки: PHP 8.2+, Composer, Node.js 18+, npm, СУБД (MySQL/PostgreSQL/SQLite).

1) Зависимости
- `composer install`
- `npm install`

2) Среда
- Скопировать `.env` и задать БД/APP_URL/почту.
- `php artisan key:generate`
- `php artisan migrate --seed`
- `php artisan storage:link`

3) Разработка
- Отдельно: `php artisan serve` и `npm run dev`
- Или всё сразу: `composer dev` (сервер + очередь + Vite)

4) Продакшен
- `npm run build`
- Настроить веб‑сервер на папку `public/`

—

## Переменные окружения

- CDEK: `CDEK_BASE_URL`, `CDEK_CLIENT_ID`, `CDEK_CLIENT_SECRET`, `CDEK_SENDER_CODE`, `CDEK_ALLOWED_TARIFFS_OFFICE` (по умолчанию 138), `CDEK_ALLOWED_TARIFFS_DOOR` (по умолчанию 139).
- Яндекс.Карты v3: `YANDEX_MAPS_API_KEY` (используется в layout и скриптах).
- Dadata: `DADATA_TOKEN` (подсказки ИНН/адреса).
- Bitrix24: `BITRIX24_ENABLED`, `BITRIX24_WEBHOOK_URL`, `BITRIX24_CATEGORY_ID`, `BITRIX24_STAGE_ID`, `BITRIX24_ASSIGNED_BY_ID`, `BITRIX24_CURRENCY_ID`.
- Метрика и верификации: `METRICA_*`, `VERIFY_GOOGLE`, `VERIFY_YANDEX`.

—

## Данные и логика

- Калькуляторы: базовая формула с минимальной площадью заготовки, работой, наценкой; логотип +10/шт; при отсутствии точного размера добавляется фиксированный «нож» 5000 ₽/тираж.
- Ближайшие размеры: `SizeMatcher` ищет в радиусе ±80 мм по каждому измерению и сортирует по расстоянию.
- Файлы: временно `storage/app/public/order_files/tmp`, при создании заказа переносятся в `storage/app/public/order_files/{uuid}`.
- Доставка CDEK: расчет «плоской» посылки по геометрии заготовок; тарифы выбираются из разрешенного списка; для ПВЗ и курьера — отдельные режимы.
- Bitrix24: создается сделка и (опционально) контакт; ошибки интеграции не прерывают оформление заказа (логируются).

—

## Тесты

- Запуск: `composer test` или `php artisan test`.
- Покрыты сценарии авторизации, профиль/пароль в настройках, доступ к дашборду.

—

## Известные ограничения

- «Полная запечатка» не считает цену — вывод 0 ₽; требуется ручная оценка менеджером.
- Тарифы CDEK и справочники зависят от корректности API‑ключей и интернет‑доступа.
- Карты/подсказки Dadata/Яндекс требуют соответствующих ключей.
- Интерфейс на русском; используйте UTF‑8 в редакторе и БД.

—

## Полезные файлы

- Роуты: `routes/web.php`, `routes/api.php`.
- Контроллеры: `app/Http/Controllers/OrderController.php`, `app/Http/Controllers/SdekController.php`.
- Калькуляторы: `app/Calculators/Fefco0201Calculator.php` и др.
- Сервисы: `app/Services/SdekClient.php`, `app/Services/Bitrix24Service.php`.
- Представления: `resources/views/configurator.blade.php`, `resources/views/cart.blade.php`.
- Клиентский код: `resources/js/configurator.js`, `resources/js/cdek.js`, `resources/js/delivery.js`.

