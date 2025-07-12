@extends('layouts.app')

@section('title', 'Ваш заказ')
@section('content')
    <h1>Спасибо за заказ!</h1>

    <p><strong>ID:</strong> {{ $order->uuid }}</p>
    <p><strong>Размер:</strong> {{ $order->length }}×{{ $order->width }}×{{ $order->height }} мм</p>
    <p><strong>Коробка:</strong> {{ $order->box_type_id }}</p>
    <p><strong>Цвет:</strong> {{ $order->cardboard_color }}</p>
    <p><strong>Тираж:</strong> {{ $order->quantity }} шт.</p>
    <p><strong>Цена за штуку:</strong> {{ $order->price_per_box }} ₽</p>
    <p><strong>Итого:</strong> {{ $order->total_price }} ₽</p>

    @if ($order->design_file)
        <p><strong>Файл дизайна:</strong> <a href="{{ asset('storage/' . $order->design_file) }}" download>Скачать</a></p>
    @endif
@endsection
