@extends('layouts.app')

@section('title', 'Разработка дизайна | ' . config('app.name'))
@section('meta_description', 'Бриф, варианты и правки. Что входит в услугу разработки дизайна и какие файлы вы получите на выходе.')

@section('content')
<section aria-labelledby="design-title">
  <div class="mx-auto">
    @php($slot = view('components.contact-form-button', [
        'buttonText' => 'Отправить заявку',
        'title' => 'Отправить заявку',
        'selectLabel' => 'Тема обращения',
        'id' => 'contact-hero-logo-design',
        'page' => request()->path(),
        'selectOptions' => ['Дизайн логотипа']
    ]))
    @include('partials.page-hero', [
        'breadcrumbs' => [
          ['label' => 'Главная', 'url' => route('home')],
          ['label' => 'Справка', 'url' => route('help.index')],
          ['label' => 'Дизайн логотипа']
        ],
        'title' => 'Разработка дизайна',
        'text' => 'Поможем с идеей и подготовкой фирменного дизайна упаковки. Предложим несколько вариантов и доведём макеты до печати.',
        'image' => Vite::asset('resources/images/about-pic-1.webp'),
        'imageAlt' => 'Пример дизайна упаковки'
    ])

    <!-- Что входит -->
    <section class="main-block" aria-labelledby="includes-title">
      <h2 id="includes-title" class="text-xl font-semibold mb-4">Что входит в услугу</h2>
      <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <li class="rounded border bg-white p-5">
          <h3 class="font-medium mb-1">Бриф и уточнения</h3>
          <p class="text-sm text-gray-600">Выясняем цели, ограничения и предпочтения по стилю и цветам.</p>
        </li>
        <li class="rounded border bg-white p-5">
          <h3 class="font-medium mb-1">2–3 варианта</h3>
          <p class="text-sm text-gray-600">Подготовим несколько направлений и визуализаций для выбора.</p>
        </li>
        <li class="rounded border bg-white p-5">
          <h3 class="font-medium mb-1">Правки и финал</h3>
          <p class="text-sm text-gray-600">Внесём согласованные правки и подготовим итоговые файлы.</p>
        </li>
      </ul>
    </section>

    <!-- Процесс работы -->
    <!-- Тарифы -->
    <section class="main-block" aria-labelledby="pricing-title">
      <h2 id="pricing-title" class="text-xl font-semibold mb-4">Тарифы</h2>
      <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Адаптация вашего дизайна -->
        <li class="rounded border bg-white p-5 flex flex-col">
          <h3 class="font-semibold mb-2">Адаптация вашего дизайна</h3>
          <p class="text-xs text-gray-500 mb-3">Срок: от 1 дня • 1 000 ₽</p>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1 mb-4">
            <li>Проверка файлов и рекомендаций по улучшению.</li>
            <li>Мелкие правки по размеру, вылетам, шрифтам.</li>
            <li>Подготовка под печать: PDF/SVG, превью PNG/JPG.</li>
          </ul>
          <div class="mt-auto">
            <x-contact-form-button
              button-text="Заказать"
              title="Адаптация вашего дизайна"
              select-label="Тип задачи"
              :select-options="['Адаптация дизайна', 'Проверка макета']" />
          </div>
        </li>

        <!-- Разработка одноцветного логотипа -->
        <li class="rounded border bg-white p-5 flex flex-col">
          <h3 class="font-semibold mb-2">Разработка одноцветного логотипа</h3>
          <p class="text-xs text-gray-500 mb-3">Срок: от 2–4 дней • 3 000 ₽</p>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1 mb-4">
            <li>2 варианта на выбор, 1 круг правок.</li>
            <li>Векторные исходники и гайд по использованию (по договоренности).</li>
            <li>Файлы для печати и веба: SVG/PDF/PNG/JPG.</li>
          </ul>
          <div class="mt-auto">
            <x-contact-form-button
              button-text="Заказать"
              title="Разработка одноцветного логотипа"
              select-label="Тип задачи"
              :select-options="['Одноцветный логотип', 'Правки логотипа']" />
          </div>
        </li>

        <!-- Разработка полноцветной печати -->
        <li class="rounded border bg-white p-5 flex flex-col">
          <h3 class="font-semibold mb-2">Разработка полноцветной печати</h3>
          <p class="text-xs text-gray-500 mb-3">Срок: от 2–5 дней • 15 000 ₽</p>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1 mb-4">
            <li>Подготовка полноцветного макета (CMYK) с учётом носителя.</li>
            <li>Техническая проверка: разрешение, цвет, вылеты, шрифты.</li>
            <li>Готовые файлы для печати и веба + превью.</li>
          </ul>
          <div class="mt-auto">
            <x-contact-form-button
              button-text="Заказать"
              title="Разработка полноцветной печати"
              select-label="Тип задачи"
              :select-options="['Полноцветная печать', 'Проверка макета']" />
          </div>
        </li>
      </ul>
    </section>

    <section class="main-block" aria-labelledby="process-title">
      <h2 id="process-title" class="text-xl font-semibold mb-4">Процесс работы</h2>
      <ol class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 1</p>
          <h3 class="font-medium">Сбор вводных</h3>
          <p class="text-sm text-gray-600">Референсы, брендбук (если есть), носители и размеры.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 2</p>
          <h3 class="font-medium">Концепции</h3>
          <p class="text-sm text-gray-600">Подготавливаем варианты, показываем превью на носителях.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 3</p>
          <h3 class="font-medium">Согласование</h3>
          <p class="text-sm text-gray-600">Вносим правки и финализируем макет.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 4</p>
          <h3 class="font-medium">Выдача файлов</h3>
          <p class="text-sm text-gray-600">Готовые файлы для печати и веба: PDF/SVG/PNG/JPG.</p>
        </li>
      </ol>
    </section>

    <!-- Итоговые материалы -->
    <section class="main-block" aria-labelledby="deliverables-title">
      <h2 id="deliverables-title" class="text-xl font-semibold mb-4">Что вы получите</h2>
      <div class="grid gap-4 md:grid-cols-2">
        <div class="rounded border bg-white p-5">
          <h3 class="font-medium mb-2">Файлы для печати</h3>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
            <li>PDF/SVG в кривых, с вылетами и полями безопасности.</li>
            <li>Растровые превью PNG/JPG (300 dpi при 1:1).</li>
          </ul>
        </div>
        <div class="rounded border bg-white p-5">
          <h3 class="font-medium mb-2">Файлы для веба</h3>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
            <li>Оптимизированные PNG/JPG/WebP для публикации.</li>
            <li>Гайд по использованию (по договоренности).</li>
          </ul>
        </div>
      </div>
    </section>

  </div>
</section>

@endsection
