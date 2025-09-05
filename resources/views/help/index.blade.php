@extends('layouts.app')

@section('title', 'Помощь — ' . config('app.name'))
@section('meta_description', 'Раздел помощи: ответы на вопросы по заказу, доставке, оплате и возвратам.')

@section('content')
<section class="main-block">
    <h1 class="h2 font-bold mb-4">Помощь</h1>
    <p class="text-gray-700 mb-4">Здесь собраны ответы на частые вопросы и полезные инструкции.</p>
    <ul class="list-disc pl-5 space-y-2">
        <li><a class="text-blue-600 underline" href="{{ route('help.how_to_order') }}">Как оформить заказ</a></li>
        <li><a class="text-blue-600 underline" href="{{ route('help.delivery') }}">О доставке</a></li>
        <li><a class="text-blue-600 underline" href="{{ route('help.payment') }}">Об оплате</a></li>
        <li><a class="text-blue-600 underline" href="{{ route('help.returns') }}">О возвратах</a></li>
        <li><a class="text-blue-600 underline" href="{{ route('help.faq') }}">FAQ</a></li>
    </ul>
</section>
@endsection

