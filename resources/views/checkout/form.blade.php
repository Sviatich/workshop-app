@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Оформление заказа</h1>

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    @if(count($cart) > 0)
        <h2>Корзина</h2>

        @foreach ($cart as $index => $item)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <p><strong>Тип коробки:</strong> {{ $item['box_type_id'] }}</p>
                <p><strong>Размер:</strong> {{ $item['length'] }} × {{ $item['width'] }} × {{ $item['height'] }} мм</p>
                <p><strong>Цвет картона:</strong> {{ $item['color'] }}</p>
                <p><strong>Толщина:</strong> {{ $item['thickness'] }} мм</p>
                <p><strong>Прочность:</strong> {{ $item['strength'] }}</p>
                <p><strong>Тираж:</strong> {{ $item['quantity'] }}</p>
                <p><strong>Цена за коробку:</strong> {{ $item['price_per_box'] }} ₽</p>
                <p><strong>Итого:</strong> {{ $item['total_price'] }} ₽</p>
                @if (!empty($item['design_file']))
                    <p><strong>Файл дизайна:</strong> загружен</p>
                @endif

                <form method="POST" action="{{ route('checkout.remove', $index) }}" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" style="background-color: red; color: white; padding: 5px 10px;">Удалить</button>
                </form>
            </div>
        @endforeach

        <h3>Общая сумма: {{ $total }} ₽</h3>
    @endif

    <hr>

    <h2>Контактные данные</h2>

    <form method="POST" action="{{ route('checkout.submit') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Способ доставки:</label><br>
            <select name="delivery_method" required>
                <option value="pickup">Самовывоз</option>
                <option value="cdek">СДЭК</option>
                <option value="pek">ПЭК</option>
                <option value="own">Свой курьер</option>
            </select>
        </div>

        <div>
            <label>Адрес доставки:</label><br>
            <input type="text" name="delivery_address" required>
        </div>

        <div>
            <label>Тип клиента:</label><br>
            <select name="customer_type" required>
                <option value="person">Физическое лицо</option>
                <option value="business">Юридическое лицо</option>
            </select>
        </div>

        <div>
            <label>Имя:</label><br>
            <input type="text" name="customer_name" required>
        </div>

        <div>
            <label>Email:</label><br>
            <input type="email" name="customer_email" required>
        </div>

        <div>
            <label>Телефон:</label><br>
            <input type="text" name="customer_phone" required>
        </div>

        <div>
            <label>ИНН (если юр.лицо):</label><br>
            <input type="text" name="customer_inn">
        </div>

        <br>
        <button type="submit" style="padding: 10px 20px;">Подтвердить заказ</button>
    </form>
</div>
@endsection
