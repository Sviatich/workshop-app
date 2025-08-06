@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Заказ №{{ $order->id }}</h1>

        <p><strong>Статус:</strong> {{ $order->status }}</p>
        <p><strong>Тип плательщика:</strong>
            {{ $order->payer_type === 'individual' ? 'Физическое лицо' : 'Юридическое лицо / ИП' }}
        </p>
        <p><strong>ФИО:</strong> {{ $order->full_name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Телефон:</strong> {{ $order->phone }}</p>
        <p><strong>Адрес доставки:</strong> {{ $order->delivery_address }}</p>

        <h2 class="text-xl font-bold mt-4">Товары:</h2>
        <ul>
            @foreach($order->items as $item)
                <li>
                    {{ $item->config_json['construction_name'] ?? $item->config_json['construction'] }}
                    —
                    {{ $item->config_json['length'] }} ×
                    {{ $item->config_json['width'] }} ×
                    {{ $item->config_json['height'] }} мм,
                    Цвет: {{ $item->config_json['color_name'] ?? $item->config_json['color'] }},
                    тираж {{ $item->config_json['tirage'] }},
                    цена {{ number_format($item->total_price, 2, '.', ' ') }} ₽
                </li>
            @endforeach
        </ul>
    </div>
@endsection