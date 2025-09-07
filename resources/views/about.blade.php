@extends('layouts.app')

@section('title', 'Упаковка, которая работает на вас')
@section('meta_description', 'О компании: производство упаковки на заказ, опыт, команда и преимущества.')

@section('content')

  {{-- Hero --}}
  <section class="relative main-block primary-bg-color">
    <div class="grid lg:grid-cols-12 gap-10 items-center">
      <div class="lg:col-span-7">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white">
          Мастерская Упаковки — делаем коробки, которые продают
        </h1>
        <p class="mt-5 text-lg max-w-2xl text-white">
          Производим <span class="font-bold">короба по каталогу FEFCO</span>, печать логотипа и доставку.
          Онлайн-конфигуратор считает стоимость, а команда — помогает с выбором.
        </p>
      </div>
      <div class="lg:col-span-5">
        <div class="aspect-[4/3] w-full">
          <img src="{{ Vite::asset('resources/images/doggy.png') }}" alt="Собака в коробке" class="object-cover">
        </div>
      </div>
    </div>
  </section>
  <section class="main-block">


    <dl class="grid grid-cols-2 sm:grid-cols-4 gap-6">
      <div class="p-4 rounded border">
        <dt class="text-sm text-gray-500">Богатый опыт</dt>
        <dd class="text-2xl font-semibold">{{ now()->year - 2009 }} лет</dd>
      </div>
      <div class="p-4 rounded border">
        <dt class="text-sm text-gray-500">Клиентов</dt>
        <dd class="text-2xl font-semibold">2 500 +</dd>
      </div>
      <div class="p-4 rounded border">
        <dt class="text-sm text-gray-500">Создали конструкций</dt>
        <dd class="text-2xl font-semibold">3 000 +</dd>
      </div>
      <div class="p-4 rounded border">
        <dt class="text-sm text-gray-500">Готовых форм</dt>
        <dd class="text-2xl font-semibold">1 200+</dd>
      </div>
    </dl>

    {{-- Кто мы / Миссия --}}
    <section class="mx-auto pt-8">
      <div class="grid lg:grid-cols-12 gap-10 items-start">
        <div class="lg:col-span-6">
          <div class="grid grid-cols-1 sm:grid-cols-1 gap-4">
            <a href="#" data-modal-open="" data-modal-type="video" data-title="Видео о производстве"
              data-video-src="https://rutube.ru/play/embed/ВАШ-ID"
              data-video-text="Короткий ролик о наших производственных мощностях.">
              <img class="btn-hover-effect rounded" src="http://[::1]:5173/resources/images/product-image.webp"
                alt="Ссылка на видео о производстве">
            </a>
          </div>
        </div>
        <div class="lg:col-span-6">
          <h2 class="text-2xl sm:text-3xl font-bold">Кто мы</h2>
          <p class="mt-4 leading-relaxed">
            Мы — команда инженеров, дизайнеров и производственников. Делаем упаковку, которая помогает продавать:
            аккуратную, прочную и экономичную. Фокус — быстрые малые и средние тиражи для e-commerce и маркетплейсов.
          </p>
        </div>
      </div>
    </section>
  </section>
  <section class="main-block">
    {{-- Преимущества --}}
    <div class="mx-auto">
      <h2 class="text-2xl sm:text-3xl font-bold">Почему нас выбирают</h2>
      <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
          $benefits = [
            [
              'icon' => 'calculator',
              'title' => 'Конфигуратор с расчётом',
              'desc' => 'Стоимость и параметры считаются на лету, видны ближайшие стандартные размеры.'
            ],
            [
              'icon' => 'layers',
              'title' => 'Малые тиражи',
              'desc' => 'Печатаем от 10 штук — идеально для тестовых партий и нишевых запусков.'
            ],
            [
              'icon' => 'paint-brush',
              'title' => 'Печать и брендинг',
              'desc' => 'Логотип одной краской или полноцвет — подскажем, как выгоднее.'
            ],
            [
              'icon' => 'truck',
              'title' => 'Доставка по РФ',
              'desc' => 'Сотрудничаем с СДЭК; рассчитываем габариты и вес автоматически.'
            ],
            [
              'icon' => 'check-circle',
              'title' => 'Контроль качества',
              'desc' => 'Спецификации и фотопруфы перед запуском партии.'
            ],
            [
              'icon' => 'headset',
              'title' => 'Поддержка',
              'desc' => 'Менеджер на связи в мессенджерах, быстрые ответы по макетам.'
            ],
          ];

          // Иконки SVG (можно заменить на компонент или @svg)
          $icons = [
            'calculator' => '<svg class="w-8 h-8" fill="none" stroke="#296fd1" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h2M12 15h2"/></svg>',
            'layers' => '<svg class="w-8 h-8" fill="none" stroke="#296fd1" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>',
            'paint-brush' => '<svg class="w-8 h-8" viewBox="0 0 24 24" fill="none""><path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2Z" stroke="#296fd1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 21.1679V14L12 7L16 14V21.1679" stroke="#296fd1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M8 14C8 14 9.12676 15 10 15C10.8732 15 12 14 12 14C12 14 13.1268 15 14 15C14.8732 15 16 14 16 14" stroke="#296fd1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>',
            'truck' => '<svg class="w-8 h-8" fill="none" stroke="#296fd1" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
            'check-circle' => '<svg class="w-8 h-8" fill="none" stroke="#296fd1" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2l4-4"/></svg>',
            'headset' => '<svg class="w-8 h-8" fill="none" stroke="#296fd1" stroke-width="2" viewBox="0 0 24 24"><path d="M4 15v-3a8 8 0 0 1 16 0v3"/><rect x="2" y="15" width="4" height="6" rx="2"/><rect x="18" y="15" width="4" height="6" rx="2"/></svg>',
          ];
        @endphp

        @foreach($benefits as $b)
          <div class="p-6 rounded border bg-white flex flex-col items-start">
            {!! $icons[$b['icon']] ?? '' !!}
            <h3 class="font-semibold mt-4">{{ $b['title'] }}</h3>
            <p class="mt-2">{{ $b['desc'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <section class="main-block">

    {{-- Производство / как мы делаем --}}
    <div class="mx-auto">
      <div class="grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-6">
          <h2 class="text-2xl sm:text-3xl font-bold">Как это работает</h2>
          <ul class="mt-6 space-y-4">
            <li><span class="font-medium">1.</span> Выбираете конструкцию и параметры в конфигураторе.</li>
            <li><span class="font-medium">2.</span> Загружаете логотип/макет, получаете расчёт и спецификацию.</li>
            <li><span class="font-medium">3.</span> Подтверждаем макеты, запускаем производство.</li>
          </ul>
        </div>
        <div class="lg:col-span-6">
          <div class="w-full">
            <img src="{{ Vite::asset('resources/images/about-pic-1.webp') }}" alt="Процесс настройки короба"
              class="h-full w-full object-cover">
          </div>
        </div>
      </div>
    </div>

  </section>
  @include('partials.review')


@endsection