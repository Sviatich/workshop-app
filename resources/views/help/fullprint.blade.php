@extends('layouts.app')

@section('title', 'Полноцветная печать | ' . config('app.name'))
@section('meta_description', 'Фотографическое качество CMYK. Где уместна полноцветная печать, требования к макетам и этапы работы.')

@section('content')
<section aria-labelledby="fullprint-title">
  <div class="mx-auto">
    <!-- Hero -->
    <header class="main-block text-center">
      <h1 id="fullprint-title" class="main-h1">Полноцветная печать</h1>
      <p class="mt-2 text-gray-600 max-w-2xl mx-auto">Фотографическое качество и широкая цветопередача CMYK для сложных изображений, градиентов и фото.</p>
    </header>

    <!-- Преимущества -->
    <section class="main-block" aria-labelledby="benefits-title">
      <h2 id="benefits-title" class="sr-only">Преимущества</h2>
      <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <li class="rounded border bg-white p-5">
          <h3 class="font-semibold mb-1">Фотографическое качество</h3>
          <p class="text-sm text-gray-600">Передаёт градиенты, тени, мелкие детали без ограничений по цветам.</p>
        </li>
        <li class="rounded border bg-white p-5">
          <h3 class="font-semibold mb-1">Широкая совместимость</h3>
          <p class="text-sm text-gray-600">Подходит для сложных макетов, полноцветных логотипов и иллюстраций.</p>
        </li>
        <li class="rounded border bg-white p-5">
          <h3 class="font-semibold mb-1">Стабильная цветопередача</h3>
          <p class="text-sm text-gray-600">CMYK-профили и верификация файлов помогают добиться предсказуемого результата.</p>
        </li>
      </ul>
    </section>

    <!-- Как мы работаем -->
    <section class="main-block" aria-labelledby="process-title">
      <h2 id="process-title" class="text-xl font-semibold mb-4">Как мы работаем</h2>
      <ol class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 1</p>
          <h3 class="font-medium">Бриф и файлы</h3>
          <p class="text-sm text-gray-600">Получаем макет и параметры нанесения, при необходимости подскажем.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 2</p>
          <h3 class="font-medium">Проверка макета</h3>
          <p class="text-sm text-gray-600">Проверяем разрешение, цвета и технические требования.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 3</p>
          <h3 class="font-medium">Печать</h3>
          <p class="text-sm text-gray-600">Запускаем печать с контролем качества по контрольным оттискам.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 4</p>
          <h3 class="font-medium">Упаковка и отгрузка</h3>
          <p class="text-sm text-gray-600">Аккуратно упаковываем и отправляем удобным для вас способом.</p>
        </li>
      </ol>
    </section>

    <!-- Требования к макетам -->
    <section class="main-block" aria-labelledby="files-title">
      <h2 id="files-title" class="text-xl font-semibold mb-4">Требования к макетам</h2>
      <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded border bg-white p-5">
          <h3 class="font-medium mb-2">Форматы и цвет</h3>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
            <li>Файлы: PDF/SVG (вектор), PNG/JPG (растр).</li>
            <li>Цветовое пространство: CMYK. Профиль — по умолчанию FOGRA39 (или согласуем).</li>
            <li>Черный текст — составной не используем, для мелкого текста — 100K.</li>
          </ul>
        </div>
        <div class="rounded border bg-white p-5">
          <h3 class="font-medium mb-2">Размер и качество</h3>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
            <li>Разрешение растров — 300 dpi при масштабе 1:1.</li>
            <li>Безопасные отступы и поля — не менее 3–5 мм.</li>
            <li>Шрифты переведены в кривые либо приложены файлами.</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="main-block" aria-labelledby="faq-title">
      <h2 id="faq-title" class="text-xl font-semibold mb-4">Частые вопросы</h2>
      <div class="space-y-2">
        <details class="rounded border bg-white p-4">
          <summary class="font-medium cursor-pointer">Можно ли печатать градиенты и фото?</summary>
          <p class="mt-2 text-gray-700">Да, полноцветная печать идеально подходит для сложных полутонов, градиентов и фотографий.</p>
        </details>
        <details class="rounded border bg-white p-4">
          <summary class="font-medium cursor-pointer">Какие файлы прислать?</summary>
          <p class="mt-2 text-gray-700">Предпочтительно PDF/SVG (вектор). Растровые — PNG/JPG в CMYK, 300 dpi при масштабе 1:1.</p>
        </details>
      </div>
    </section>

    <!-- CTA -->
    <section class="main-block text-center" aria-labelledby="cta-title">
      <h2 id="cta-title" class="text-2xl font-semibold mb-2">Нужна консультация по макету?</h2>
      <p class="text-gray-600 mb-4">Поможем подготовить файл и подскажем лучший способ печати.</p>
      <x-contact-form-button
        button-text="Получить консультацию"
        title="Вопрос по полноцветной печати"
        select-label="Тема обращения"
        :select-options="['Полноцветная печать', 'Проверка макета', 'Сроки и стоимость']" />
    </section>
  </div>
</section>
@endsection

