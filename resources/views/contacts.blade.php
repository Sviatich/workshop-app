@extends('layouts.app')

@section('title', 'Контакты — ' . config('app.name'))
@section('meta_description', 'Контактная информация, адрес и способы связи.')

@section('content')
<section class="main-block">
    <h1 class="h2 font-bold mb-4">Контакты</h1>
    <div class="space-y-2 text-gray-800">
        <p><strong>Телефон:</strong> <a href="tel:+7XXXXXXXXXX" class="text-blue-600 underline">+7 (___) ___-__-__</a></p>
        <p><strong>Email:</strong> <a href="mailto:info@example.com" class="text-blue-600 underline">info@example.com</a></p>
        <p><strong>Адрес:</strong> Укажите адрес компании</p>
    </div>
</section>
@endsection

