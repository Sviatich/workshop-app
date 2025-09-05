@extends('layouts.app')

@section('title', 'Как оформить заказ — ' . config('app.name'))
@section('meta_description', 'Пошаговая инструкция по оформлению заказа на сайте.')

@section('content')
<section class="main-block">
    <h1 class="h2 font-bold mb-4">Как оформить заказ</h1>
    <ol class="list-decimal pl-5 space-y-2 text-gray-800">
        <li>Выберите параметры изделия в конфигураторе и добавьте в корзину.</li>
        <li>Перейдите в корзину, проверьте состав заказа и укажите контактные данные.</li>
        <li>Выберите способ доставки и оплаты, прикрепите макеты при необходимости.</li>
        <li>Отправьте заказ. Мы свяжемся с вами для уточнения деталей.</li>
    </ol>
</section>
@endsection

