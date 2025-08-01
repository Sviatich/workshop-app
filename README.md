# README.md — Laravel Box Configurator

> Версия: 0.1

---

## 📦 Описание проекта

Упаковочный конфигуратор с динамическим расчётом стоимости, поддержкой разных конструкций и размеров, корзиной без регистрации, интеграцией с Bitrix24 и доставкой через СДЭК. Проект построен на Laravel 11 с модульной архитектурой, отдельными калькуляторами, безопасной загрузкой файлов и возможностью расширения через админку.

---

## ⚙️ Основной функционал

* Форма конфигурации коробки (размеры, тираж, цвет, оформление)
* Разные конструкции с разными формулами расчёта стоимости
* Поддержка фиксированных тиражей (10–500)
* Поддержка нестандартных размеров (+5000₽ за штамп)
* Расчёт стоимости на лету (без кнопки)
* Выбор и прикрепление оформления (логотип, печать и т.п.)
* Корзина с несколькими позициями
* Оформление заказа без регистрации (uuid-ссылка)
* Выбор метода доставки (Самовывоз / СДЭК до двери / ПВЗ)
* Интеграция с Bitrix24 (создание лида/сделки, обновление статуса)
* Автоудаление заказов через 30 дней
* Страницы: о нас, оплата, доставка, блог/новости

---

## 🏗 Архитектура

### Паттерны

* Strategy: отдельный калькулятор под каждый тип коробки
* Service Layer: бизнес-логика отделена от контроллеров
* DTO/ValueObject: передача данных между слоями
* CRUD-админка (Blade или Filament)

### Основные сервисы

* `PricingService`
* `CartService`
* `OrderService`
* `DeliveryService`
* `Bitrix24Service`
* `FileStorageService`
* `SeoService`

### Конфигурация конструкций

```php
interface BoxPriceCalculatorInterface {
  public function calculate(PricingRequestData $data): Money;
  public function suggestNearestSize(PricingRequestData $data): ?AvailableSize;
}
```

---

## 🧮 База данных

### Справочники

* `box_types`
* `available_sizes` (связь с конструкцией)
* `print_runs`
* `design_options`
* `cardboard_colors`

### Торговые сущности

* `orders`
* `order_items`
* `order_design_options`
* `files`
* `deliveries`
* `seo_pages`
* `posts`

---

## 🌐 Роутинг и API

### Web

* `/` — форма
* `/cart` — корзина
* `/checkout` — оформление
* `/order/{uuid}` — просмотр заказа
* `/blog`, `/about`, `/payment`, `/delivery`

### API

* `POST /api/pricing/preview`
* `POST /api/cart/add`
* `DELETE /api/cart/item/{id}`
* `POST /api/checkout`
* `POST /api/file/upload`
* `POST /api/delivery/calculate`
* `POST /api/bitrix/webhook`

---

## 🔐 Безопасность

* Honeypot/antibot защита на формах
* Rate Limiting
* Защита UUID-заказов и времени жизни (30 дней)
* Загрузка только допустимых файлов вне `public`
* Строгая валидация форм
* Очистка старых заказов через Artisan `command`

---

## 📦 Установка

```bash
git clone ...
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan serve
```

---

## 📘 Дополнительно

* Все калькуляторы расширяемы: добавляешь новый — просто реализуешь интерфейс
* Все справочники отключаемы в админке
* Файлы не доступны напрямую, только через защищённые URL
* Чистые JS-фронт + Blade (без SPA)

---
