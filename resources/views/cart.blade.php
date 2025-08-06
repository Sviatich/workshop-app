@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Корзина</h1>

        <div id="cart_items" class="space-y-4"></div>

        <div id="cart_summary" class="mt-6 p-4 border rounded bg-gray-50 hidden">
            <p><strong>Итого:</strong> <span id="cart_total">0</span> ₽</p>

            <h2 class="text-xl font-bold mt-4 mb-2">Оформление заказа</h2>

            <form id="order_form" class="space-y-3">
                <div>
                    <label class="block font-semibold mb-1">Тип плательщика</label>
                    <select name="payer_type" id="payer_type" class="border rounded w-full p-2">
                        <option value="individual">Физическое лицо</option>
                        <option value="company">Юридическое лицо / ИП</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">ФИО</label>
                    <input type="text" name="full_name" id="full_name" class="border rounded w-full p-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" class="border rounded w-full p-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Телефон</label>
                    <input type="text" name="phone" id="phone" class="border rounded w-full p-2" required>
                </div>

                <div id="inn_field" class="hidden">
                    <label class="block font-semibold mb-1">ИНН</label>
                    <input type="text" name="inn" id="inn" class="border rounded w-full p-2">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Адрес доставки</label>
                    <textarea name="delivery_address" id="delivery_address" class="border rounded w-full p-2"
                        required></textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Метод доставки</label>
                    <select name="delivery_method_id" id="delivery_method_id" class="border rounded w-full p-2">
                        @foreach(\App\Models\DeliveryMethod::where('active', true)->get() as $method)
                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Подтвердить заказ
                </button>
            </form>
        </div>

        <div id="empty_cart" class="text-gray-500">
            Ваша корзина пуста.
        </div>
    </div>
@endsection

@vite(['resources/js/cart.js'])