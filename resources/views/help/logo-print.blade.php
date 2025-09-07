@extends('layouts.app')

@section('title', 'Печать логотипа | ' . config('app.name'))
@section('meta_description', 'Методы нанесения логотипа (1–2 цвета), как выбрать способ, требования к макетам и этапы работы.')

@section('content')
<section aria-labelledby="logo-printing-title">
    @php($slot = view('components.contact-form-button', [
        'buttonText' => 'Обратная связь',
        'title' => 'Обратная связь',
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
        'title' => 'Нанесение логотипа',
        'text' => 'Наносим логотипы на коробки методами тампо- и трафаретной печати. Работаем от малых тиражей и помогаем с подготовкой макета.',
        'image' => Vite::asset('resources/images/box-hero.webp'),
        'imageAlt' => 'Пример коробок с нанесением логотипа'
    ])


    <!-- Методы нанесения -->
    <section id="methods" class="main-block" aria-labelledby="methods-title">
      <h2 id="methods-title" class="text-xl font-semibold mb-4">Методы нанесения</h2>
      <div class="grid md:grid-cols-2 gap-6 items-start">
        <div class="space-y-4">
          <div>
            <h3 class="font-semibold">Шелкография (1–2 цвета)</h3>
            <p class="text-sm text-gray-700">Плотная заливка, чёткие края, высокая стойкость. Выгодна на средних и больших тиражах.</p>
          </div>
          <div>
            <h3 class="font-semibold">Термотрансфер (плёнка)</h3>
            <p class="text-sm text-gray-700">Подходит для небольших тиражей и срочных задач. Ровные контуры, ограничение по мелким деталям.</p>
          </div>
          <div>
            <h3 class="font-semibold">Тампопечать</h3>
            <p class="text-sm text-gray-700">Для небольших элементов и сложных поверхностей. Оптимальна, когда требуется аккуратное точечное нанесение.</p>
          </div>


        </div>

      </div>
    </section>

    <!-- Как мы работаем -->
    <section class="main-block" aria-labelledby="process-title">
      <h2 id="process-title" class="text-xl font-semibold mb-4">Как мы работаем</h2>
      <ol class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 1</p>
          <h3 class="font-medium">Бриф и макет</h3>
          <p class="text-sm text-gray-600">Вы присылаете макет и параметры нанесения. Поможем выбрать способ.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 2</p>
          <h3 class="font-medium">Подтверждение макета</h3>
          <p class="text-sm text-gray-600">Проверяем файл, цвета и технологичность. Согласуем визуализацию.</p>
        </li>
        <li class="rounded border bg-white p-4">
          <p class="text-xs uppercase text-gray-500">Шаг 3</p>
          <h3 class="font-medium">Нанесение</h3>
          <p class="text-sm text-gray-600">Печатаем партию, контролируем качество по контрольным образцам.</p>
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
            <li>Предпочтительно вектор: SVG/PDF (текст в кривых).</li>
            <li>1–2 цвета: укажите оттенки (Pantone/CMYK) либо пришлите образец.</li>
            <li>Растровые макеты — PNG/JPG (300 dpi при 1:1, без фона).</li>
          </ul>
        </div>
        <div class="rounded border bg-white p-5">
          <h3 class="font-medium mb-2">Технологичность</h3>
          <ul class="text-sm text-gray-700 list-disc pl-5 space-y-1">
            <li>Минимальная толщина линий и зазоров — от 0.3–0.4 мм.</li>
            <li>Безопасные отступы от края — не менее 3–5 мм.</li>
            <li>Сложные мелкие элементы лучше упростить или увеличить.</li>
          </ul>
        </div>
      </div>
    </section>

</section>

@endsection
