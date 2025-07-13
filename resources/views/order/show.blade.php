@extends('layouts.app')

@php
    $colorMap = ['brown' => 'Бурый', 'white' => 'Белый'];
    $strengthMap = ['econom' => 'Эконом', 'business' => 'Бизнес'];
    $printTypeMap = [
        'none' => 'Без оформления',
        'print' => 'Печать',
        'sticker' => 'Наклейка',
        'wrapper' => 'Обечайка',
    ];
    $deliveryMap = [
        'pickup' => 'Самовывоз',
        'cdek' => 'СДЭК',
        'pek' => 'ПЭК',
        'own' => 'Свой курьер',
    ];
@endphp

@section('content')
@php
    $colorMap = ['brown' => 'Бурый', 'white' => 'Белый'];
    $strengthMap = ['econom' => 'Эконом', 'business' => 'Бизнес'];
    $printTypeMap = [
        'none' => 'Без оформления',
        'print' => 'Печать',
        'sticker' => 'Наклейка',
        'wrapper' => 'Обечайка',
    ];
    $deliveryMap = [
        'pickup' => 'Самовывоз',
        'cdek' => 'СДЭК',
        'pek' => 'ПЭК',
        'own' => 'Свой курьер',
    ];
@endphp
    <div class="container">
        <h1>Спасибо за заказ!</h1>

        <p><strong>ID заказа:</strong> {{ $order->uuid }}</p>
        <p><strong>Имя клиента:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Адрес доставки:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Тип доставки:</strong> {{ $deliveryMap[strtolower($order->delivery_method)] ?? $order->delivery_method }}</p>
        <p><strong>Общая стоимость:</strong> {{ number_format($order->total_price, 2, ',', ' ') }} ₽</p>

        <h3>Позиции в заказе:</h3>
        <ul>
            @foreach ($order->items as $item)
                <li>
                    <strong>{{ $item->quantity }} шт</strong> —
                    {{ $item->boxType->name ?? 'N/A' }},
                    {{ $item->length }}×{{ $item->width }}×{{ $item->height }} мм,
                    толщина: {{ $item->cardboard_thickness }} мм,
                    цвет: {{ $colorMap[strtolower($item->cardboard_color)] ?? $item->cardboard_color }},
                    прочность: {{ $strengthMap[strtolower($item->cardboard_strength)] ?? $item->cardboard_strength }},
                    печать: {{ $printTypeMap[$item->print_type] ?? $item->print_type }},
                    {{ number_format($item->price_per_box, 2, ',', ' ') }} ₽/шт
                    @if ($item->design_file)
                        , <a href="{{ Storage::disk('public')->url($item->design_file) }}" target="_blank">файл</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
