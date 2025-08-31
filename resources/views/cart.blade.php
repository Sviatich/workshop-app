@extends('layouts.app')

@section('content')
<div class="">
    <h1 class="text-2xl font-bold mb-6">Оформление заказа</h1>

    {{-- Пустая корзина --}}
    <div id="empty_cart" class="text-gray-500">Ваша корзина пуста.</div>

    {{-- Основная сетка: 2/1 на md+ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- ЛЕВАЯ КОЛОНКА (позиции + форма) --}}
        <div class="md:col-span-2 space-y-6">

            {{-- Позиции корзины --}}
            <section aria-labelledby="cart-items-title" class="main-block">
                <h2 id="cart-items-title" class="text-xl font-semibold">Позиции</h2>
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
                {{-- СПОСОБ ДОСТАВКИ --}}
                <section aria-labelledby="delivery-title" class="space-y-6 main-block">
                    <h2 id="delivery-title" class="text-xl font-semibold">Способ доставки</h2>

                    <fieldset class="space-y-3">
                        <legend class="sr-only">Выбор способа доставки</legend>

                        <div class="space-y-2">
                            {{-- Самовывоз --}}
                            <label class="flex items-center gap-2">
                                <input type="radio" name="delivery_method_choice" value="pickup" class="delivery-choice" checked>
                                <span>Самовывоз (0 ₽)</span>
                            </label>
                            <div id="pickup_block" class="mt-2">
                                <div id="pickup_map" class="h-64 rounded border"></div>
                                <p class="text-sm text-gray-600 mt-2">
                                    Забрать заказ можно со склада. Адрес уточняем при подтверждении заказа.
                                </p>
                            </div>

                            {{-- ПЭК --}}
                            <label class="flex items-center gap-2 mt-4">
                                <input type="radio" name="delivery_method_choice" value="pek" class="delivery-choice">
                                <span>Доставка ПЭК (до терминала, 0 ₽ до терминала)</span>
                            </label>
                            <div id="pek_block" class="mt-2 hidden">
                                <div id="pek_map" class="h-64 rounded border"></div>
                                <p class="text-sm text-gray-600 mt-2">
                                    Мы бесплатно отвезём до выбранного терминала ПЭК. Дальше — по тарифам ПЭК.
                                </p>
                            </div>

                            {{-- СДЭК --}}
                            <label class="flex items-center gap-2 mt-4">
                                <input type="radio" name="delivery_method_choice" value="cdek" class="delivery-choice">
                                <span>СДЭК (расчёт по адресу или ПВЗ)</span>
                            </label>
                            <div id="cdek_block" class="mt-2 hidden space-y-2">
                                <button type="button" id="open-cdek" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    Выбрать ПВЗ/адрес
                                </button>
                                <div id="delivery_summary" class="text-sm text-gray-700"></div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Адрес доставки: один раз, без дубликатов.
                         delivery.js сам делает required только для СДЭК --}}
                    <div class="space-y-2 mt-4">
                        <label class="block font-semibold mb-1" for="delivery_address">Адрес доставки</label>
                        <textarea name="delivery_address" id="delivery_address" class="border rounded w-full p-2"
                                  placeholder="Для самовывоза/ПЭК можно оставить пустым"></textarea>
                    </div>
                </section>

                {{-- ОФОРМЛЕНИЕ: данные плательщика --}}
                <section aria-labelledby="checkout-title" class="space-y-6">
                    <h2 id="checkout-title" class="text-xl font-semibold">Оформление</h2>

                    {{-- Реквизиты плательщика --}}
                    <fieldset class="space-y-3 main-block">
                        <legend class="sr-only">Данные плательщика</legend>

                        {{-- Тип плательщика (ФЛ/ЮЛ) --}}
                        <div>
                            <label class="block font-semibold mb-1" for="payer_type">Тип плательщика</label>
                            <select name="payer_type" id="payer_type" class="border rounded w-full p-2">
                                <option value="individual" selected>Физическое лицо</option>
                                <option value="company">Юридическое лицо / ИП</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1" for="full_name">ФИО</label>
                            <input type="text" name="full_name" id="full_name" class="border rounded w-full p-2" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-semibold mb-1" for="email">Email</label>
                                <input type="email" name="email" id="email" class="border rounded w-full p-2" required>
                            </div>
                            <div>
                                <label class="block font-semibold mb-1" for="phone">Телефон</label>
                                <input type="text" name="phone" id="phone" class="border rounded w-full p-2" required>
                            </div>
                        </div>

                        {{-- ИНН показывается только для ЮЛ/ИП (cart.js/delivery.js управляют классом hidden) --}}
                        <div id="inn_field" class="hidden">
                            <label class="block font-semibold mb-1" for="inn">ИНН</label>
                            <input type="text" name="inn" id="inn" class="border rounded w-full p-2">
                        </div>
                    </fieldset>

                    {{-- СЛУЖЕБНЫЕ ПОЛЯ ДОСТАВКИ — полностью скрыты от пользователя --}}
                    <div class="hidden" aria-hidden="true">
                        <select name="delivery_method_id" id="delivery_method_id" class="border rounded w-full p-2">
                            @foreach(\App\Models\DeliveryMethod::where('active', true)->get() as $method)
                                <option value="{{ $method->id }}" data-code="{{ $method->code }}">{{ $method->name }}</option>
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
            <div id="cart_summary" class="sticky top-6 p-4 border rounded bg-gray-50 hidden space-y-3">
                <h2 id="summary-title" class="text-lg font-semibold">Итоги заказа</h2>

                {{-- Сумма товаров --}}
                <p class="flex justify-between">
                    <span class="font-medium">Товары:</span>
                    <span><span id="cart_total">0</span> ₽</span>
                </p>

                {{-- delivery.js добавит сюда строку «Доставка», а также строку «Итого» --}}
                <p class="flex justify-between text-sm">
                    <span>Общий вес:</span>
                    <span><span id="cart_weight_total">0</span> кг</span>
                </p>
                <p class="flex justify-between text-sm">
                    <span>Общий объём:</span>
                    <span><span id="cart_volume_total">0</span> м³</span>
                </p>

                {{-- Кнопка подтверждения: сабмитит левую форму --}}
                <button type="submit"
                        form="order_form"
                        class="w-full mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Подтвердить заказ
                </button>
            </div>
        </aside>
    </div>
</div>
@endsection

@vite(['resources/js/cart.js', 'resources/js/delivery.js'])
