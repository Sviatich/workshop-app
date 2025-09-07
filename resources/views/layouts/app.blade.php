<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <title>@yield('title', 'Конфигуратор')</title>

    <link rel="preload" href="{{ Vite::asset('resources/fonts/inter/Inter-VariableFont_opsz,wght.woff2') }}" as="font" type="font/woff2" crossorigin>

    <meta name="description" content="@yield('meta_description', 'Онлайн-конфигуратор упаковки: закажите коробки под ваши размеры и дизайн.')">
    <meta name="keywords" content="@yield('meta_keywords', 'коробки, упаковка, конфигуратор, печать')">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Performance: preconnect for widget and Yandex APIs -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://api-maps.yandex.ru" crossorigin>
    <link rel="preconnect" href="https://geocode-maps.yandex.ru" crossorigin>

    {{-- Яндекс.Карты: ключ берём из .env через config/services. Скрипт грузим динамически в yandexmap.js --}}
    <meta name="yandex-maps-api-key" content="{{ config('services.yandex.maps_key') }}">
    {{-- Dadata Suggestions token (optional, for INN autocomplete) --}}
    <meta name="dadata-token" content="{{ config('services.dadata.token') }}">
    {{-- Bitrix24 --}}
    {{--  --}}

    @production
        @include('partials.analytics.verifications')
        @includeWhen(config('services.metrica.id'), 'partials.analytics.metrica')
    @endproduction

    @hasSection('meta')
        @yield('meta')
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fallback styles for modal when Vite is unavailable -->
    <link rel="stylesheet" href="{{ asset('css/popap.css') }}">
</head>
<body>

    @include('partials.header')

    <main class="main-container">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.popuptamplate')
    @include('partials.cookiesbanner')
    
</body>
</html>
