@extends('layouts.app')

@section('title', 'Корзина — ' . config('app.name'))
@section('meta_description', 'Корзина: проверьте товары и оформите заказ.')

@section('content')
    <div>

        {{-- Пустая корзина --}}
        <div id="empty_cart" class="text-gray-500">Ваша корзина пуста.</div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <section aria-labelledby="cart-items-title" class="main-block">
                    <h1 class="h2 font-bold mb-6">Корзина</h1>
                    <div id="cart_items" class="space-y-4"></div>

                    <template id="cart_item_template">
                        <div class="border p-4 rounded bg-white">
                            <p class="font-semibold mb-1 config-text"></p>
                            <p class="text-sm text-gray-700 summary-text"></p>
                            <div class="options text-sm text-gray-800 space-y-1 mt-2"></div>
                        </div>
                    </template>
                </section>

                {{-- ФОРМА: доставка + данные плательщика --}}
                <form id="order_form" class="space-y-6" novalidate>
                    @honeypot
                    {{-- СПОСОБ ДОСТАВКИ --}}
                    <section aria-labelledby="delivery-title" class="space-y-6 main-block">
                        <h2 id="delivery-title" class="text-xl font-semibold">Способ доставки</h2>

                        <fieldset class="space-y-4">
                            <legend class="sr-only">Выбор способа доставки</legend>

                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                {{-- Самовывоз --}}
                                <label
                                    class="delivery-option cursor-pointer border rounded p-4 flex gap-3 transition hover:shadow-md">
                                    <input type="radio" name="delivery_method_choice" value="pickup"
                                        class="sr-only peer delivery-choice" checked>

                                    {{-- Индикатор выбора --}}
                                    <span class="bullet">
                                        <span class="dot"></span>
                                    </span>

                                    {{-- Контент --}}
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium">Самовывоз</span>
                                        </div>
                                        <p class="text-sm text-gray-700">
                                            Забрать заказ можно со склада по адресу: <a href="https://yandex.ru/profile/142486939387?lang=ru" target="_blank" class="underline"><br>г. Черноголовка, ул. Первый проезд, зд. 8</a>.<br>
                                            Время работы: <span class="font-medium">Пн–Пт 09:00–17:00</span>
                                        </p>
                                        <div id="pickup_block" class="mt-2">
                                            <div id="pickup_map" class="h-40 rounded border"></div>
                                        </div>
                                    </div>
                                </label>

                                {{-- ПЭК --}}
                                <label
                                    class="delivery-option cursor-pointer border rounded p-4 flex gap-3 transition hover:shadow-md">
                                    <input type="radio" name="delivery_method_choice" value="pek"
                                        class="sr-only peer delivery-choice">

                                    {{-- Индикатор выбора --}}
                                    <span class="bullet">
                                        <span class="dot"></span>
                                    </span>

                                    {{-- Контент --}}
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium">Доставка ПЭК</span>
                                        </div>
                                        <p class="text-sm text-gray-700">
                                            <span class="block">Бесплатно передадим ТК ПЭК по адресу: <a href="https://yandex.ru/maps/-/CLQ-eYiF" target="_blank" class="underline"><br>Электростальское шоссе, 25, Ногинск, Богородский городской округ</a>.</span>
                                            <span class="block">Дальнейшая доставка до вашего города — по тарифам ПЭК. Стоимость и сроки уточняйте на сайте <a href="https://pecom.ru/" target="_blank" rel="noopener" class="text-blue-600 underline hover:text-blue-800">pecom.ru</a> или у менеджера после оформления заказа.</span>
                                        </p>
                                        <div id="pek_block" class="mt-2 hidden">
                                            <div id="pek_map" class="h-40 rounded border"></div>
                                        </div>
                                    </div>
                                </label>

                                {{-- СДЭК --}}
                                <label
                                    class="delivery-option cursor-pointer border rounded p-4 flex gap-3 transition hover:shadow-md">
                                    <input type="radio" name="delivery_method_choice" value="cdek"
                                        class="sr-only peer delivery-choice">

                                    {{-- Индикатор выбора --}}
                                    <span class="bullet">
                                        <span class="dot"></span>
                                    </span>

                                    {{-- Контент --}}
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium">СДЭК ПВЗ</span>
                                        </div>
                                        <p class="text-sm text-gray-700">
                                            Выберите город и подходящий  пункт выдачи.
                                        </p>
                                        <div id="cdek_block" class="mt-2 hidden space-y-2">
                                            <button type="button" id="open-cdek"
                                                class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                Выбрать ПВЗ/адрес
                                            </button>
                                            <div id="delivery_summary" class="text-sm text-gray-700"></div>
                                        </div>
                                    </div>
                                </label>

                                {{-- Подобрать оптимальную доставку --}}
                                <label
                                    class="delivery-option cursor-pointer border rounded p-4 flex gap-3 transition hover:shadow-md">
                                    <input type="radio" name="delivery_method_choice" value="best"
                                        class="sr-only peer delivery-choice">

                                    {{-- Индикатор выбора --}}
                                    <span class="bullet">
                                        <span class="dot"></span>
                                    </span>

                                    {{-- Контент --}}
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium">Подобрать оптимальный тариф</span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            Менеджер свяжется с вами для согласования способа доставки и окончательной суммы с учетом стоимости доставки.
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </fieldset>



                        {{-- Адрес доставки: один раз, без дубликатов.
                        delivery.js сам делает required только для СДЭК --}}
                        <div class="space-y-2 mt-4">
                            <label class="block font-semibold mb-1 cart-labels" for="delivery_address">Адрес
                                доставки</label>
                            <textarea name="delivery_address" id="delivery_address" class="border rounded w-full p-2"
                                placeholder="Укажите адрес"></textarea>
                        </div>
                    </section>

                    {{-- ОФОРМЛЕНИЕ: данные плательщика --}}
                    <section aria-labelledby="checkout-title" class="space-y-6">

                        {{-- Реквизиты плательщика --}}
                        <fieldset class="space-y-3 main-block">
                            <h2 id="checkout-title" class="text-xl font-semibold">Данные плательщика</h2>
                            <legend class="sr-only">Данные плательщика</legend>

                            {{-- Тип плательщика (ФЛ/ЮЛ) --}}
                            <fieldset class="space-y-1">
                                <legend id="payer_type_legend" class="block font-semibold mb-1 cart-labels">
                                    Тип плательщика
                                </legend>
                                <div class="customer-payments relative w-full max-w-full bg-gray-100 border rounded border-gray-200 inline-flex items-center select-none"
                                    role="radiogroup" aria-labelledby="payer_type_legend">
                                    <input type="radio" id="payer_individual" name="payer_type" value="individual"
                                        class="sr-only peer/ind" checked>
                                    <input type="radio" id="payer_company" name="payer_type" value="company"
                                        class="sr-only peer/comp">
                                    <div
                                        class="payer-slider absolute top-1 left-1 h-[calc(100%-0.5rem)] w-[calc(50%-0.25rem)] rounded bg-white shadow transition-transform duration-200 ease-out will-change-transform">
                                    </div>
                                    <label for="payer_individual"
                                        class="relative z-10 flex-1 text-center py-2 px-3 cursor-pointer font-medium transition-colors text-gray-600 peer-checked/ind:text-gray-900">
                                        Физическое лицо
                                    </label>
                                    <label for="payer_company"
                                        class="relative z-10 flex-1 text-center py-2 px-3 cursor-pointer font-medium transition-colors text-gray-600 peer-checked/comp:text-gray-900">
                                        Юридическое лицо / ИП
                                    </label>
                                </div>
                            </fieldset>

                            <div>
                                <label class="block font-semibold mb-1 cart-labels" for="full_name">ФИО</label>
                                <input placeholder="Иван Иванов" type="text" name="full_name" id="full_name"
                                    class="border rounded w-full p-2" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-semibold mb-1 cart-labels" for="email">Email</label>
                                    <input placeholder="ivanov@yandex.ru" type="email" name="email" id="email"
                                        class="border rounded w-full p-2" required>
                                </div>
                                <div>
                                    <label class="block font-semibold mb-1 cart-labels" for="phone">Телефон</label>
                                    <input placeholder="+7 (999) 999-99-99" type="text" name="phone" id="phone"
                                        class="border rounded w-full p-2" required>
                                </div>
                            </div>

                            {{-- ИНН показывается только для ЮЛ/ИП (cart.js/delivery.js управляют классом hidden) --}}
                            <div id="inn_field" class="hidden">
                                <label class="block font-semibold mb-1" for="inn">ИНН</label>
                                <input placeholder="Введите ИНН" type="text" name="inn" id="inn"
                                    class="border rounded w-full p-2">
                            </div>
                        </fieldset>

                        {{-- СЛУЖЕБНЫЕ ПОЛЯ ДОСТАВКИ — полностью скрыты от пользователя --}}
                        <div class="hidden" aria-hidden="true">
                            <select name="delivery_method_id" id="delivery_method_id" class="border rounded w-full p-2">
                                @foreach(\App\Models\DeliveryMethod::where('active', true)->get() as $method)
                                    <option value="{{ $method->id }}" data-code="{{ $method->code }}">{{ $method->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="hidden" id="delivery_method_code" name="delivery_method_code" value="pickup">
                            <input type="hidden" id="delivery_price_input" name="delivery_price" value="0">

                            {{-- CDEK details (optional) --}}
                            <input type="hidden" id="cdek_mode" name="cdek_mode" value="">
                            <input type="hidden" id="cdek_tariff_code" name="cdek_tariff_code" value="">
                            <input type="hidden" id="cdek_tariff_name" name="cdek_tariff_name" value="">
                            <input type="hidden" id="cdek_delivery_sum" name="cdek_delivery_sum" value="">
                            <input type="hidden" id="cdek_period_min" name="cdek_period_min" value="">
                            <input type="hidden" id="cdek_period_max" name="cdek_period_max" value="">
                            <input type="hidden" id="cdek_pvz_code" name="cdek_pvz_code" value="">
                            <input type="hidden" id="cdek_pvz_address" name="cdek_pvz_address" value="">
                            <input type="hidden" id="cdek_recipient_address" name="cdek_recipient_address" value="">
                        </div>
                    </section>
                </form>
            </div>

            {{-- ПРАВАЯ КОЛОНКА (Итоги) --}}
            <aside aria-labelledby="summary-title" class="md:col-span-1">
                <div id="cart_summary" class="sticky top-6 hidden main-block">
                    <h2 id="summary-title" class="text-lg font-semibold">Итоги заказа</h2>

                    {{-- Сумма товаров --}}
                    <p class="flex justify-between cart-summary-row">
                        <span>Товары:</span>
                        <span><span id="cart_total">0</span> ₽</span>
                    </p>

                    {{-- delivery.js добавит сюда строку «Доставка», а также строку «Итого» --}}
                    <p id="packaging_row" class="flex justify-between cart-summary-row">
                        <span>Упаковка:</span>
                        <span><span id="packaging_total">0</span> ₽</span>
                    </p>
                    <p id="delivery_row" class="flex justify-between">
                        <span>Доставка:</span>
                        <span><span id="delivery_row_value">0</span> ₽</span>
                    </p>
                    <p class="flex justify-between text-sm cart-summary-row">
                        <span>Общий вес:</span>
                        <span><span id="cart_weight_total">0</span> кг</span>
                    </p>
                    <p class="flex justify-between text-sm cart-summary-row">
                        <span>Общий объём:</span>
                        <span><span id="cart_volume_total">0</span> м³</span>
                    </p>
                    <p id="grand_total_row" class="flex justify-between font-semibold pt-2">
                        <span>Итого:</span>
                        <span><span id="grand_total">0</span> ₽</span>
                    </p>

                    {{-- Кнопка подтверждения: сабмитит левую форму --}}
                    <button type="submit" form="order_form" class="add-to-cart-button btn-hover-effect mt-4">
                        Подтвердить заказ
                    </button>
                    <p class="form-copiration-text text-sm mt-2">
                        Нажимая эту кнопку вы соглашаетесь с нашей
                        <a href="/privacy-policy"><u>политикой обработки персональных данных</u></a>
                    </p>
                </div>
            </aside>
        </div>
    </div>
@endsection

@vite(['resources/js/cart.js', 'resources/js/delivery.js', 'resources/js/inn-suggest.js'])

<div id="order_loader" class="fixed inset-0 bg-black/40 z-50 hidden">
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="bg-white rounded p-4 shadow flex items-center gap-3">
            <span
                class="inline-block w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></span>
            <span>Оформляем заказ…</span>
        </div>
    </div>
</div>
