<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

    <title>@yield('title', 'Конфигуратор')</title>

    <meta name="description" content="@yield('meta_description', 'Онлайн-конфигуратор упаковки: закажите коробки под ваши размеры и дизайн.')">
    <meta name="keywords" content="@yield('meta_keywords', 'коробки, упаковка, конфигуратор, печать')">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">

    @include('partials.header')

    <main class="main-container">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
