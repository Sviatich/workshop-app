@extends('layouts.app')

@section('title', 'Печать логотипа — Мастерская Упаковки')
@section('meta_description', 'Методы нанесения логотипа, как выбрать способ, требования к макетам и этапы работы.')

@section('content')
<section class="space-y-12">

  @php($slot = view('components.contact-form-button', [
      'buttonText' => 'Задать вопрос',
      'title' => 'Задать вопрос',
      'selectLabel' => 'Тема обращения',
      'id' => 'contact-hero-logo-print',
      'page' => request()->path(),
      'selectOptions' => ['Печать логотипа']
  ]))

  @include('partials.page-hero', [
      'breadcrumbs' => [
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Справка', 'url' => route('help.index')],
        ['label' => 'Печать логотипа']
      ],
      'title' => 'Печать логотипа',
      'text' => 'Наносим логотипы на коробки методами флексо- и цифровой печати. Работаем от малых тиражей и помогаем с подготовкой макета.',
      'image' => Vite::asset('resources/images/logo-print-1.webp'),
      'imageAlt' => 'Пример коробок с нанесением логотипа'
  ])

    <section aria-label="Ключевые преимущества" class="mx-auto max-w-6xl">
    <ul class="grid grid-cols-2 md:grid-cols-4 gap-5 mx-[20px] md:mx-0">
      <li class="flex items-center gap-2 rounded bg-white p-5">
        <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor"/>
            <path d="M8 8h8M8 12h8M8 16h4" stroke="currentColor" stroke-linecap="round"/>
          </svg>
        <span class="text-sm">Тиражи от 25 шт</span>
      </li>
      <li class="flex items-center gap-2 rounded bg-white p-5">
           <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <rect x="6" y="9" width="12" height="7" rx="2" stroke="currentColor"/>
            <path d="M6 9V5h12v4" stroke="currentColor"/>
            <rect x="9" y="16" width="6" height="4" rx="1" stroke="currentColor"/>
          </svg>
        <span class="text-sm">Помощь с дизайном</span>
      </li>
      <li class="flex items-center gap-2 rounded bg-white p-5">
                  <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <polygon points="12 2 22 7 12 12 2 7 12 2" stroke="currentColor" stroke-linejoin="round"/>
            <polyline points="2 17 12 22 22 17" stroke="currentColor" stroke-linejoin="round"/>
            <polyline points="2 7 2 17" stroke="currentColor"/>
            <polyline points="22 7 22 17" stroke="currentColor"/>
            <polyline points="12 12 12 22" stroke="currentColor"/>
          </svg>
        <span class="text-sm">3D-визуализация</span>
      </li>
      <li class="flex items-center gap-2 rounded bg-white p-5">
        <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor"/>
            <path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        <span class="text-sm">Контроль качества</span>
      </li>
    </ul>
  </section>

  <section aria-labelledby="logo-print-title" class="lg:mb-12 m-5 md:m-0">
    <h2 id="logo-print-title" class="sr-only">Опции печати логотипа</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      <article class="space-y-4 flex">
        <img
          src="{{ Vite::asset('resources/images/logo-print-2.webp') }}"
          alt="Схема возможного расположения логотипа"
          class="w-full h-full rounded-md object-cover"
        />
      </article>
      <article class="bg-white rounded-md p-8 space-y-3">
        <div class="space-y-2">
          <h3 class="font-bold text-xl">Где будет печать</h3>
          <p>Согласуем с вами место нанесения логотипа или другой символики на изделии до запуска в производство.</p>
          <p>Перед стартом работ отправим 3D-визуализацию размещения и финальный макет на утверждение.</p>
        </div>
          <div class="mt-4 flex flex-wrap gap-2">
            <span class="rounded border px-3 py-1 text-xs bg-gray-100">крышка</span>
            <span class="rounded border px-3 py-1 text-xs bg-gray-100">боковая стенка</span>
            <span class="rounded border px-3 py-1 text-xs bg-gray-100">дно</span>
          </div>
      </article>
      <article class="bg-white rounded-md p-8 space-y-4">
        <h3 class="font-bold text-xl">Что можно нанести</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="var(--primary-color)" aria-hidden="true">
              <rect width="18" height="18" rx="2" fill="var(--primary-color)" />
              <path d="M5 9.5L8 12.5L13 7.5" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <span>Логотип вашей компании</span>
          </li>
          <li class="flex items-start gap-3">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="var(--primary-color)" aria-hidden="true">
              <rect width="18" height="18" rx="2" fill="var(--primary-color)" />
              <path d="M5 9.5L8 12.5L13 7.5" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <span>QR-коды и ссылки на соцсети</span>
          </li>
          <li class="flex items-start gap-3">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="var(--primary-color)" aria-hidden="true">
              <rect width="18" height="18" rx="2" fill="var(--primary-color)" />
              <path d="M5 9.5L8 12.5L13 7.5" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <span>Манипуляционные знаки</span>
          </li>
        </ul>
      </article>
      <article class="flex bg-white rounded-md p-6 space-y-3">
        <img
          src="{{ Vite::asset('resources/images/logo-print-3.webp') }}"
          alt="Пример визуализации перед запуском"
          class="w-full object-contain rounded-md"
        />
      </article>
    </div>
  </section>

  <section class="main-block" aria-labelledby="process-title">
    <h2 id="process-title" class="font-semibold mb-4">Как мы работаем</h2>
    <ol class="grid gap-5 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
      <li class="group rounded border bg-white p-5">
        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded bg-blue-100 text-sm font-semibold text-blue-600">1</div>
        <h3 class="font-medium">Бриф и макет</h3>
        <p class="mt-1 text-sm text-gray-600">Вы присылаете макет и параметры нанесения.</p>
      </li>
      <li class="group rounded border bg-white p-5">
        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded bg-blue-100 text-sm font-semibold text-blue-600">2</div>
        <h3 class="font-medium">Подтверждение</h3>
        <p class="mt-1 text-sm text-gray-600">Проверяем файл макета на корректность.</p>
      </li>
      <li class="group rounded border bg-white p-5">
        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded bg-blue-100 text-sm font-semibold text-blue-600">3</div>
        <h3 class="font-medium">Визуализация</h3>
        <p class="mt-1 text-sm text-gray-600">Отправляем 3D-модель на согласование.</p>
      </li>
      <li class="group rounded border bg-white p-5">
        <div class="mb-6 flex h-10 w-10 items-center justify-center rounded bg-blue-100 text-sm font-semibold text-blue-600">4</div>
        <h3 class="font-medium">Нанесение</h3>
        <p class="mt-1 text-sm text-gray-600">Печатаем партию и проводим контроль качества.</p>
      </li>
    </ol>
  </section>

  <section class="main-block primary-bg-color text-white" aria-labelledby="files-title">
    <h2 id="files-title" class="font-semibold mb-4">Требования к макетам</h2>
    <ul class="text list-disc pl-5 space-y-1">
      <li>Предпочтительно вектор: SVG/PDF (текст в кривых).</li>
      <li>Прикрепите название шрифта, используемого в макете.</li>
      <li>Растровые макеты — PNG/JPG (300 dpi при 1:1, без фона).</li>
    </ul>
  </section>
</section>
@include('partials.maingalery')
@endsection
