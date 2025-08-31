@extends('layouts.app')

@section('content')
<div class="">
    <h1 class="text-2xl font-bold mb-6">Оформление заказа</h1>

    {{-- Пустая корзина --}}
    <div id="empty_cart" class="text-gray-500">Ваша корзина пуста.</div>

    {{-- Основная сетка: 2/1 на md+ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- ЛЕВАЯ КОЛОНКА (2 части) --}}
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

            {{-- Блок оформления: реквизиты + доставка --}}
            <section aria-labelledby="checkout-title" class="space-y-6">
                <h2 id="checkout-title" class="text-xl font-semibold">Оформление</h2>

                <form id="order_form" class="space-y-6">
                    {{-- Реквизиты --}}
                    <fieldset class="space-y-3 main-block">
                        <legend class="font-semibold">Данные плательщика</legend>

                        <div>
                            <label class="block font-semibold mb-1" for="payer_type">Тип плательщика</label>
                            <select name="payer_type" id="payer_type" class="border rounded w-full p-2">
                                <option value="individual">Физическое лицо</option>
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

                        <div id="inn_field" class="hidden">
                            <label class="block font-semibold mb-1" for="inn">ИНН</label>
                            <input type="text" name="inn" id="inn" class="border rounded w-full p-2">
                        </div>
                    </fieldset>

                    {{-- Доставка --}}
                    <fieldset class="space-y-3 main-block">
                        <legend class="font-semibold">Доставка</legend>

                        <div>
                            <label class="block font-semibold mb-1" for="delivery_address">Адрес доставки</label>
                            <textarea name="delivery_address" id="delivery_address" class="border rounded w-full p-2" required></textarea>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1" for="delivery_method_id">Метод доставки</label>
                            <select name="delivery_method_id" id="delivery_method_id" class="border rounded w-full p-2">
                                @foreach(\App\Models\DeliveryMethod::where('active', true)->get() as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </form>
            </section>
        </div>

        {{-- ПРАВАЯ КОЛОНКА (Итоги) --}}
        <aside aria-labelledby="summary-title" class="md:col-span-1">
            <div id="cart_summary" class="sticky top-6 p-4 border rounded bg-gray-50 hidden space-y-3">
                <h2 id="summary-title" class="text-lg font-semibold">Итоги заказа</h2>

                <p class="flex justify-between">
                    <span class="font-medium">Итого:</span>
                    <span><span id="cart_total">0</span> ₽</span>
                </p>

                <p class="flex justify-between text-sm">
                    <span>Общий вес:</span>
                    <span><span id="cart_weight_total">0</span> кг</span>
                </p>

                <p class="flex justify-between text-sm">
                    <span>Общий объём:</span>
                    <span><span id="cart_volume_total">0</span> м³</span>
                </p>

                {{-- Кнопка подтверждения вынесена сюда, но сабмитит форму слева --}}
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

@vite(['resources/js/cart.js'])
