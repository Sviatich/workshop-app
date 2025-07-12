@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Оформление заказа</h1>

    <form action="{{ route('checkout.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h3>Ваш заказ</h3>
        <p>Коробка: {{ $boxType->name }}</p>
        <p>Размеры: {{ $data['length'] }} × {{ $data['width'] }} × {{ $data['height'] }} мм</p>
        <p>Тираж: {{ $data['quantity'] }} шт</p>
        <p>Цена за коробку: {{ $pricePerBox }} ₽</p>
        <p>Итоговая цена: {{ $totalPrice }} ₽</p>
        <p>Объём: {{ round($volume, 4) }} м³</p>
        <p>Вес: {{ $weight }} кг</p>

        {{-- Скрытые поля для передачи в контроллер submit --}}
        @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        {{-- Выбор способа доставки --}}
        <div>
            <label>Способ доставки:</label><br>
            <select name="delivery_method" required>
                <option value="pickup">Самовывоз</option>
                <option value="cdek">СДЭК</option>
                <option value="pek">ПЭК</option>
                <option value="own">Доставка нашей курьеркой</option>
            </select>
        </div>

        <div>
            <label>Адрес доставки:</label><br>
            <input type="text" name="delivery_address" required>
        </div>

        {{-- Тип заказчика --}}
        <div>
            <label>Вы:</label><br>
            <label><input type="radio" name="customer_type" value="person" checked> Физлицо</label>
            <label><input type="radio" name="customer_type" value="business"> Юрлицо / ИП</label>
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

        <div id="inn-block" style="display: none;">
            <label>ИНН (для юрлиц):</label><br>
            <input type="text" name="customer_inn">
        </div>

        {{-- Повторная загрузка файла (если был) --}}
        @if (!empty($data['design_file']) && is_string($data['design_file']))
        <p>Файл уже загружен: <a href="{{ asset('storage/' . $data['design_file']) }}" target="_blank">{{ basename($data['design_file']) }}</a></p>
        @else
            <div>
                <label>Прикрепить файл дизайна:</label><br>
                <input type="file" name="design_file">
            </div>
        @endif
    

        <button type="submit">Подтвердить заказ</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('input[name="customer_type"]');
        const innBlock = document.getElementById('inn-block');

        radios.forEach(r => {
            r.addEventListener('change', () => {
                innBlock.style.display = r.value === 'business' ? 'block' : 'none';
            });
        });
    });
</script>
@endsection
