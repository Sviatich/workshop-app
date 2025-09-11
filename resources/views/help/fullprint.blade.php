@extends('layouts.app')

@section('title', 'Полноцветная печать | ' . config('app.name'))
@section('meta_description', 'Полноцветная печать на упаковке. Требования к макетам и этапы работы.')

@section('content')
<section aria-labelledby="fullprint-title">
  <div class="mx-auto">
    @php($slot = view('components.contact-form-button', [
        'buttonText' => 'Запросить расчет',
        'title' => 'Запросить расчет',
        'selectLabel' => 'Тема обращения',
        'id' => 'contact-hero-fullprint',
        'page' => request()->path(),
        'selectOptions' => ['Полноцветная печать']
    ]))
    @include('partials.page-hero', [
        'breadcrumbs' => [
          ['label' => 'Главная', 'url' => route('home')],
          ['label' => 'Справка', 'url' => route('help.index')],
          ['label' => 'Полноцветная печать']
        ],
        'title' => 'Полноцветная печать',
        'text' => 'Печать на всей поверхности упаковки. Подготовим макеты, согласуем цветопробу и произведем тираж.',
        'image' => Vite::asset('resources/images/preview.webp'),
        'imageAlt' => 'Полноцветная печать на упаковке'
    ])

  <section class="main-block" aria-labelledby="process-title">
    <h2 id="process-title" class="font-semibold mb-4">Как мы работаем</h2>
    <ol class="grid gap-5 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
      <li class="bg-white flex flex-col items-start p-4 rounded border">
        <span class="mb-10">
          <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor"/>
            <path d="M8 8h8M8 12h8M8 16h4" stroke="currentColor" stroke-linecap="round"/>
          </svg>
        </span>
        <p class="text-xs uppercase text-gray-500 mb-2">Шаг 1</p>
        <h3 class="font-semibold mb-2">Бриф и макет</h3>
        <p class="text-base mb-4">Вы присылаете макет и параметры нанесения.</p>
      </li>
      <li class="bg-white flex flex-col items-start p-4 rounded border">
        <span class="mb-10">
          <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor"/>
            <path d="M8 12l2.5 2.5L16 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
        <p class="text-xs uppercase text-gray-500 mb-2">Шаг 2</p>
        <h3 class="font-semibold mb-2">Подтверждение</h3>
        <p class="text-base mb-4">Проверяем файл макета на корректность.</p>
      </li>
      <li class="bg-white flex flex-col items-start p-4 rounded border">
        <span class="mb-10">
          <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <polygon points="12 2 22 7 12 12 2 7 12 2" stroke="currentColor" stroke-linejoin="round"/>
            <polyline points="2 17 12 22 22 17" stroke="currentColor" stroke-linejoin="round"/>
            <polyline points="2 7 2 17" stroke="currentColor"/>
            <polyline points="22 7 22 17" stroke="currentColor"/>
            <polyline points="12 12 12 22" stroke="currentColor"/>
          </svg>
        </span>
        <p class="text-xs uppercase text-gray-500 mb-2">Шаг 3</p>
        <h3 class="font-semibold mb-2">Визуализация</h3>
        <p class="text-base mb-4">Отправляем вам 3D модель на согласование.</p>
      </li>
      <li class="bg-white flex flex-col items-start p-4 rounded border">
        <span class="mb-10">
          <svg class="h-8 w-8 text-primary stroke-current logo-pring-page-icons" fill="none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
            <rect x="6" y="9" width="12" height="7" rx="2" stroke="currentColor"/>
            <path d="M6 9V5h12v4" stroke="currentColor"/>
            <rect x="9" y="16" width="6" height="4" rx="1" stroke="currentColor"/>
          </svg>
        </span>
        <p class="text-xs uppercase text-gray-500 mb-2">Шаг 4</p>
        <h3 class="font-semibold mb-2">Нанесение</h3>
        <p class="text-base mb-4">Печатаем партию, контролируем качество.</p>
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

    @include('partials.ineeddesign')

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
      </article>
    </div>
  </section>

  </div>
</section>


@endsection
