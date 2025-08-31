<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <title>@yield('title', 'Конфигуратор')</title>

    <link rel="preload" href="{{ Vite::asset('resources/fonts/inter/Inter-VariableFont_opsz,wght.woff2') }}" as="font" type="font/woff2" crossorigin>

    <meta name="description" content="@yield('meta_description', 'Онлайн-конфигуратор упаковки: закажите коробки под ваши размеры и дизайн.')">
    <meta name="keywords" content="@yield('meta_keywords', 'коробки, упаковка, конфигуратор, печать')">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://api-maps.yandex.ru/v3/?apikey=2270b668-e556-46a1-b36c-7465185a997b&lang=ru_RU"></script>

    @production
        @include('partials.analytics.verifications')
        @includeWhen(config('services.metrica.id'), 'partials.analytics.metrica')
    @endproduction

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">

    @include('partials.header')

    <main class="main-container">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.popuptamplate')
</body>
</html>
