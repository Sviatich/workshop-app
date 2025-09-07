@extends('layouts.app')

@section('title', 'О нас — ' . config('app.name'))
@section('meta_description', 'О компании: производство упаковки на заказ, опыт, команда и преимущества.')

@section('content')
<section class="main-block">
{{-- Hero --}}
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-orange-50"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
      <div class="grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-7">
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">
            Мистер Пакерс — умная упаковка для малого бизнеса
          </h1>
          <p class="mt-5 text-lg text-gray-600 max-w-2xl">
            Производим <span class="font-medium text-gray-900">короба по FEFCO</span>, печать логотипа и доставку. 
            Онлайн-конфигуратор считает стоимость, а команда — помогает с выбором.
          </p>
          <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('help.delivery') }}" class="inline-flex items-center px-5 py-3 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 transition">
              Запустить конфигуратор
            </a>
            <a href="{{ route('contacts') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition">
              Связаться с нами
            </a>
          </div>
          <dl class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-6">
            <div class="p-4 rounded-xl bg-white/70 border">
              <dt class="text-sm text-gray-500">Срок производства</dt>
              <dd class="text-2xl font-semibold">от 3 дней</dd>
            </div>
            <div class="p-4 rounded-xl bg-white/70 border">
              <dt class="text-sm text-gray-500">Тираж</dt>
              <dd class="text-2xl font-semibold">от 10 шт</dd>
            </div>
            <div class="p-4 rounded-xl bg-white/70 border">
              <dt class="text-sm text-gray-500">Типов коробов</dt>
              <dd class="text-2xl font-semibold">20+</dd>
            </div>
            <div class="p-4 rounded-xl bg-white/70 border">
              <dt class="text-sm text-gray-500">Клиентов</dt>
              <dd class="text-2xl font-semibold">1 500+</dd>
            </div>
          </dl>
        </div>
        <div class="lg:col-span-5">
          <div class="aspect-[4/3] w-full rounded-2xl border bg-white shadow-sm overflow-hidden">
            {{-- Плейсхолдер: заменишь фото производства/упаковки --}}
            <img src="{{ Vite::asset('resources/images/about/production.jpg') }}" alt="Производство упаковки" class="h-full w-full object-cover">
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Кто мы / Миссия --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid lg:grid-cols-12 gap-10 items-start">
      <div class="lg:col-span-7">
        <h2 class="text-2xl sm:text-3xl font-bold">Кто мы</h2>
        <p class="mt-4 text-gray-600 leading-relaxed">
          Мы — команда инженеров, дизайнеров и производственников. Делаем упаковку, которая помогает продавать:
          аккуратную, прочную и экономичную. Фокус — быстрые малые и средние тиражи для e-commerce и маркетплейсов.
        </p>
        <p class="mt-4 text-gray-600">
          Ценим прозрачность, сроки и внятные расчёты — поэтому сделали онлайн-конфигуратор и понятные спецификации к заказу.
        </p>
      </div>
      <div class="lg:col-span-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="p-5 rounded-2xl border">
            <h3 class="font-semibold">Миссия</h3>
            <p class="mt-2 text-sm text-gray-600">Сделать профессиональную упаковку доступной малому бизнесу без сложностей и затяжных сроков.</p>
          </div>
          <div class="p-5 rounded-2xl border">
            <h3 class="font-semibold">Ценности</h3>
            <ul class="mt-2 text-sm text-gray-600 list-disc list-inside space-y-1">
              <li>Честные расчёты</li>
              <li>Скорость и аккуратность</li>
              <li>Поддержка клиента</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Преимущества --}}
  <section class="bg-gray-50 border-y">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
      <h2 class="text-2xl sm:text-3xl font-bold">Почему нас выбирают</h2>
      <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
          $benefits = [
            ['title'=>'Конфигуратор с расчётом','desc'=>'Стоимость и параметры считаются на лету, видны ближайшие стандартные размеры.'],
            ['title'=>'Малые тиражи','desc'=>'Печатаем от 10 штук — идеально для тестовых партий и нишевых запусков.'],
            ['title'=>'Печать и брендинг','desc'=>'Логотип одной краской или полноцвет — подскажем, как выгоднее.'],
            ['title'=>'Доставка по РФ','desc'=>'Сотрудничаем с СДЭК; рассчитываем габариты и вес автоматически.'],
            ['title'=>'Контроль качества','desc'=>'Спецификации и фотопруфы перед запуском партии.'],
            ['title'=>'Поддержка','desc'=>'Менеджер на связи в мессенджерах, быстрые ответы по макетам.'],
          ];
        @endphp

        @foreach($benefits as $b)
          <div class="p-6 rounded-2xl border bg-white">
            <h3 class="font-semibold">{{ $b['title'] }}</h3>
            <p class="mt-2 text-gray-600">{{ $b['desc'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Таймлайн --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl sm:text-3xl font-bold">Как мы росли</h2>
    <ol class="mt-10 relative border-s pl-6 space-y-10">
      <li class="relative">
        <div class="absolute -left-3 top-1 w-6 h-6 rounded-full bg-white border"></div>
        <h3 class="font-semibold">2022 — Запуск MVP</h3>
        <p class="mt-2 text-gray-600">Первые клиенты из Telegram-магазинов, отладка процессов.</p>
      </li>
      <li class="relative">
        <div class="absolute -left-3 top-1 w-6 h-6 rounded-full bg-white border"></div>
        <h3 class="font-semibold">2023 — Собственное производство</h3>
        <p class="mt-2 text-gray-600">Расширили линейку FEFCO, внедрили контроль качества и фотопруфы.</p>
      </li>
      <li class="relative">
        <div class="absolute -left-3 top-1 w-6 h-6 rounded-full bg-white border"></div>
        <h3 class="font-semibold">2024 — Интеграции</h3>
        <p class="mt-2 text-gray-600">СДЭК, CRM, автоспецификации; ускорили расчёты и согласования макетов.</p>
      </li>
      <li class="relative">
        <div class="absolute -left-3 top-1 w-6 h-6 rounded-full bg-white border"></div>
        <h3 class="font-semibold">2025 — Масштабирование</h3>
        <p class="mt-2 text-gray-600">Каталог B2B-решений, быстрый старт брендов на маркетплейсах.</p>
      </li>
    </ol>
  </section>

  {{-- Производство / как мы делаем --}}
  <section class="bg-gray-50 border-y">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-6">
          <div class="aspect-[16/9] w-full rounded-2xl border overflow-hidden bg-white shadow-sm">
            <img src="{{ Vite::asset('resources/images/about/workflow.jpg') }}" alt="Процесс производства коробов" class="h-full w-full object-cover">
          </div>
        </div>
        <div class="lg:col-span-6">
          <h2 class="text-2xl sm:text-3xl font-bold">Как мы работаем</h2>
          <ul class="mt-6 space-y-4 text-gray-700">
            <li><span class="font-medium">1.</span> Выбираете конструкцию и параметры в конфигураторе.</li>
            <li><span class="font-medium">2.</span> Загружаете логотип/макет, получаете расчёт и спецификацию.</li>
            <li><span class="font-medium">3.</span> Подтверждаем макеты, запускаем производство.</li>
            <li><span class="font-medium">4.</span> Упаковываем, доставляем, консультируем по повторным тиражам.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- Клиенты / логотипы --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between gap-6">
      <h2 class="text-2xl sm:text-3xl font-bold">Нам доверяют</h2>
      {{-- <a href="{{ route('cases.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Смотреть кейсы</a> --}}
    </div>
    <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
      @for ($i = 1; $i <= 6; $i++)
        <div class="aspect-[3/2] rounded-xl border bg-white p-4 flex items-center justify-center">
          <img src="{{ Vite::asset("resources/images/clients/client-$i.svg") }}" alt="Логотип клиента {{ $i }}" class="max-h-10 object-contain">
        </div>
      @endfor
    </div>
  </section>

  {{-- Отзывы --}}
  <section class="bg-gray-50 border-y">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
      <h2 class="text-2xl sm:text-3xl font-bold">Отзывы</h2>
      <div class="mt-8 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ([
          ['name'=>'Анна, маркетплейс','text'=>'Быстро помогли с размерами и печатью. Короба приехали вовремя, цвет попал идеально.'],
          ['name'=>'Сергей, e-commerce','text'=>'Удобный конфигуратор, видно конечную цену и ближайшие стандарты — просто супер.'],
          ['name'=>'Дарья, ритейл','text'=>'Качественно упаковали, дали рекомендации по повтору тиража. Будем работать дальше.'],
        ] as $r)
          <figure class="p-6 rounded-2xl border bg-white">
            <blockquote class="text-gray-700">“{{ $r['text'] }}”</blockquote>
            <figcaption class="mt-4 text-sm text-gray-500">— {{ $r['name'] }}</figcaption>
          </figure>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Команда (опционально можно скрыть) --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl sm:text-3xl font-bold">Команда</h2>
    <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ([
        ['name'=>'Алексей','role'=>'Операции и производство'],
        ['name'=>'Иван','role'=>'Разработка и продукт'],
        ['name'=>'Мария','role'=>'Дизайн и преформы'],
      ] as $m)
      <div class="p-6 rounded-2xl border">
        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100">
          <img src="{{ Vite::asset('resources/images/team/placeholder.jpg') }}" alt="{{ $m['name'] }}" class="w-full h-full object-cover">
        </div>
        <h3 class="mt-4 font-semibold">{{ $m['name'] }}</h3>
        <p class="text-sm text-gray-600">{{ $m['role'] }}</p>
      </div>
      @endforeach
    </div>
  </section>

  {{-- FAQ --}}
  <section class="bg-gray-50 border-y">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
      <h2 class="text-2xl sm:text-3xl font-bold">Частые вопросы</h2>
      <div class="mt-8 space-y-6">
        <details class="group p-5 rounded-2xl border bg-white">
          <summary class="cursor-pointer list-none flex items-center justify-between">
            <span class="font-medium">Можно ли заказать нестандартный размер?</span>
            <span class="text-gray-400 group-open:rotate-180 transition">▾</span>
          </summary>
          <p class="mt-3 text-gray-600">Да. Если нет точного совпадения, мы предложим ближайшие размеры или произведём по ТЗ. Для нестандарта возможна надбавка за переналадку.</p>
        </details>
        <details class="group p-5 rounded-2xl border bg-white">
          <summary class="cursor-pointer list-none flex items-center justify-between">
            <span class="font-medium">Какие сроки?</span>
            <span class="text-gray-400 group-open:rotate-180 transition">▾</span>
          </summary>
          <p class="mt-3 text-gray-600">Обычно 3–7 рабочих дней в зависимости от тиража и печати. Срочные заказы обсуждаем индивидуально.</p>
        </details>
        <details class="group p-5 rounded-2xl border bg-white">
          <summary class="cursor-pointer list-none flex items-center justify-between">
            <span class="font-medium">Доставляете ли вы по РФ?</span>
            <span class="text-gray-400 group-open:rotate-180 transition">▾</span>
          </summary>
          <p class="mt-3 text-gray-600">Да, работаем с СДЭК и ТК. Габариты и вес считаем автоматически в заказе.</p>
        </details>
      </div>
    </div>
  </section>

  <div class="flex gap-6">

  <!-- Первый тултип -->
  <div class="relative inline-block">
    <button class="peer px-3 py-1.5 rounded bg-blue-600 text-white">
      1
    </button>
    <div class="pointer-events-none absolute left-1/2 -translate-x-1/2 bottom-full mb-2
                z-50 rounded bg-gray-800 text-white text-xs px-2.5 py-1 shadow
                opacity-0 scale-95 transition ease-out duration-150
                peer-hover:opacity-100 peer-hover:scale-100">
      Указываются внутренние размеры
      <span class="absolute left-1/2 top-full -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45"></span>
    </div>
  </div>

  <!-- Второй тултип -->
  <div class="relative inline-block">
    <button class="peer px-3 py-1.5 rounded bg-green-600 text-white">
      2
    </button>
    <div class="text-center pointer-events-none absolute left-1/2 -translate-x-1/2 bottom-full mb-2
                z-50 rounded bg-gray-800 text-white text-xs px-2.5 py-1 shadow
                opacity-0 scale-95 transition ease-out duration-150
                peer-hover:opacity-100 peer-hover:scale-100">
      Внешний и внутренний слои картона
      <span class="absolute left-1/2 top-full -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45"></span>
    </div>
  </div>

</div>

  {{-- CTA --}}
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="rounded-2xl border p-8 lg:p-12 bg-white">
      <div class="grid lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-8">
          <h2 class="text-2xl sm:text-3xl font-bold">Готовы упаковать ваш продукт?</h2>
          <p class="mt-3 text-gray-600">Соберите заказ в конфигураторе или позвоните — поможем подобрать конструкцию и печать.</p>
        </div>
        <div class="lg:col-span-4 flex lg:justify-end gap-3">
          {{-- <a href="{{ route('delivery') }}" class="inline-flex items-center px-5 py-3 rounded-xl bg-gray-900 text-white hover:bg-gray-800 transition">Собрать заказ</a> --}}
          {{-- <a href="{{ route('contacts') }}" class="inline-flex items-center px-5 py-3 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 transition">Связаться</a> --}}
        </div>
      </div>
    </div>
  </section>
</section>


@endsection


