@extends('layouts.app')

@section('title', 'Печать логотипа | ' . config('app.name'))
@section('meta_description', 'Методы нанесения логотипа (1–2 цвета), как выбрать способ, требования к макетам и этапы работы.')

@section('content')
<section aria-labelledby="logo-printing-title">
  <div class="mx-auto">
    <!-- Hero -->
    <header class="main-block text-center">
      <h1 id="logo-printing-title" class="main-h1">Печать логотипа</h1>
      <p class="mt-2 text-gray-600 max-w-2xl mx-auto">Нанесение 1–2 цвета на изделия. Подберём способ под ваш тираж, материал и дизайн.</p>
    </header>

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

          <div class="mt-4 rounded border bg-blue-50 p-4 text-sm">
            <p class="text-blue-900">Если дизайн содержит фото, градиенты или много цветов — рекомендуем полноцветную печать (CMYK). См. раздел «Полноцветная печать».</p>
          </div>
        </div>

        <figure class="rounded border bg-gray-50 overflow-hidden">
          <button type="button" data-zoom-src="{{ Vite::asset('resources/images/help/logo-methods.webp') }}" class="w-full">
            <img src="{{ Vite::asset('resources/images/help/logo-methods.webp') }}" alt="Методы нанесения логотипа" class="w-full h-auto">
          </button>
          <figcaption class="p-3 text-sm text-gray-600">Примеры нанесения логотипа: шелкография, термотрансфер, тампопечать.</figcaption>
        </figure>
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

    <!-- FAQ -->
    <section class="main-block" aria-labelledby="faq-title">
      <h2 id="faq-title" class="text-xl font-semibold mb-4">Частые вопросы</h2>
      <div class="space-y-2">
        <details class="rounded border bg-white p-4">
          <summary class="font-medium cursor-pointer">Можно ли нанести логотип в 1 экземпляре?</summary>
          <p class="mt-2 text-gray-700">Обычно возможно через термотрансфер. Минимальный тираж и способ уточним по макету и материалу.</p>
        </details>
        <details class="rounded border bg-white p-4">
          <summary class="font-medium cursor-pointer">Какие файлы прислать?</summary>
          <p class="mt-2 text-gray-700">Идеально — вектор SVG/PDF с текстом в кривых. Также подойдёт PNG/JPG в 300 dpi при масштабе 1:1.</p>
        </details>
      </div>
    </section>

    <!-- CTA -->
    <section role="region" aria-labelledby="cta-title" class="main-block text-center">
      <h2 id="cta-title" class="text-2xl font-semibold mb-2">Нужна помощь с выбором способа?</h2>
      <p class="text-gray-600 mb-4">Пришлите макет — подскажем оптимальный метод нанесения и подготовим файл к печати.</p>
      <div class="mt-2">
        <x-contact-form-button
          button-text="Получить консультацию"
          title="Вопрос по печати логотипа"
          select-label="Тема обращения"
          :select-options="['Печать логотипа', 'Проверка макета', 'Подбор способа']" />
      </div>
    </section>
  </div>

</section>
@endsection

