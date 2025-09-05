@extends('layouts.app')

@section('title', 'Дополнительные услуги — ' . config('app.name'))
@section('meta_description', 'Печать логотипа, полноцветная печать и разработка логотипа.')

@section('content')
<section class="main-block">
    <h1 class="h2 font-bold mb-4">Дополнительные услуги</h1>
    <ul class="list-disc pl-5 space-y-2">
        <li><a class="text-blue-600 underline" href="{{ route('services.logo_print') }}">Печать логотипа</a></li>
        <li><a class="text-blue-600 underline" href="{{ route('services.fullprint') }}">Полноцветная печать</a></li>
        <li><a class="text-blue-600 underline" href="{{ route('services.logo_design') }}">Разработка логотипа</a></li>
    </ul>
    <p class="text-gray-600 mt-4">Выберите услугу, чтобы узнать подробности.</p>
    
</section>
@endsection

