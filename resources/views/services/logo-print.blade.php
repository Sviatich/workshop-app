@extends('layouts.app')

@section('title', 'Нанесение логотипа — ' . config('app.name'))
@section('meta_description', 'Информация о нанесении логотипа: способы, требования к макетам, ограничения на гофрокартоне, порядок работы.')

@section('content')
<section aria-labelledby="logo-printing-title">
    <div class="mx-auto">

        <!-- Способы печати -->
        <section id="methods" class="main-block scroll-mt-24" aria-labelledby="methods-title">
            <h2 id="methods-title" class="text-xl font-semibold mb-4">Способы печати</h2>
            <div class="grid md:grid-cols-2 gap-6 items-start">
                <div class="space-y-3">
                    <h3 class="font-semibold">Флексопечать (1–2 цвета)</h3>
                    <p>Оптимальна для коробок из бурого/белого гофрокартона. Чёткий плоский оттиск без полутонов. Хороша для логотипов, пиктограмм, текста.</p>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700">
                        <li>Экономично на средних и крупных тиражах.</li>
                        <li>Линии и шрифты должны быть достаточно жирными.</li>
                        <li>Плашки и мелкие детали требуют теста на выбранном картоне.</li>
                    </ul>

                    <h3 class="font-semibold mt-5">Трафарет/шелкография (по запросу)</h3>
                    <p>Подходит для небольших площадей печати и акцентных элементов. Даёт насыщенный цвет, но ниже скорость.</p>
                </div>
                <figure class="rounded border bg-gray-50 overflow-hidden">
                    <button type="button" data-zoom-src="{{ Vite::asset('resources/images/help/logo-methods.webp') }}" class="w-full">
                        <img src="{{ Vite::asset('resources/images/help/logo-methods.webp') }}" alt="Примеры нанесения логотипа на коробки" class="w-full h-auto">
                    </button>
                    <figcaption class="p-3 text-sm text-gray-600">Примеры расположения логотипа: крышка, бок, торец.</figcaption>
                </figure>
            </div>

            <div class="mt-4 rounded border bg-blue-50 p-4 text-sm">
                <p class="text-blue-900">
                    Если в конфигураторе вы включаете опцию «Логотип», надбавка за печать рассчитывается автоматически. Для сложных случаев менеджер уточнит условия.
                </p>
            </div>
        </section>

        <!-- Как это работает -->
        <section id="howitworks" class="main-block scroll-mt-24" aria-labelledby="howitworks-title">
            <h2 id="howitworks-title" class="text-xl font-semibold mb-4">Как это работает</h2>
            <div class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6 items-start">
                    <div>
                        <h3 class="font-semibold mb-2">1. Включите опцию «Логотип» в конфигураторе</h3>
                        <p>Задайте размер/позицию (если требуется), отметьте цвет(а) печати и добавьте файл логотипа. Предпросмотр доступен сразу.</p>
                    </div>
                    <figure class="rounded border bg-gray-50 overflow-hidden">
                        <button type="button" data-zoom-src="{{ Vite::asset('resources/images/help/logo-step-1.webp') }}" class="w-full">
                            <img src="{{ Vite::asset('resources/images/help/logo-step-1.webp') }}" alt="Опция логотипа в конфигураторе" class="w-full h-auto">
                        </button>
                        <figcaption class="p-3 text-sm text-gray-600">Опция «Логотип» в карточке конфигуратора.</figcaption>
                    </figure>
                </div>

                <div class="grid md:grid-cols-2 gap-6 items-start">
                    <div>
                        <h3 class="font-semibold mb-2">2. Загрузите файл</h3>
                        <p>Поддерживаются векторные форматы (предпочтительно) и растровые. Система проверит тип и покажет превью.</p>
                        <ul class="list-disc pl-5 space-y-1 text-gray-700">
                            <li><strong>Лучше всего:</strong> SVG, PDF (кривые), AI/EPS.</li>
                            <li>Допустимо: PNG/JPG с высоким разрешением (см. требования ниже).</li>
                        </ul>
                    </div>
                    <figure class="rounded border bg-gray-50 overflow-hidden">
                        <button type="button" data-zoom-src="{{ Vite::asset('resources/images/help/logo-step-2.webp') }}" class="w-full">
                            <img src="{{ Vite::asset('resources/images/help/logo-step-2.webp') }}" alt="Загрузка файла логотипа" class="w-full h-auto">
                        </button>
                        <figcaption class="p-3 text-sm text-gray-600">Загрузка и предпросмотр логотипа.</figcaption>
                    </figure>
                </div>

                <div class="grid md:grid-cols-2 gap-6 items-start">
                    <div>
                        <h3 class="font-semibold mb-2">3. Проверка и согласование</h3>
                        <p>Мы проверяем файл на соответствие требованиям, при необходимости подскажем корректировки (толщина линий, инверсия, размер).</p>
                    </div>
                    <figure class="rounded border bg-gray-50 overflow-hidden">
                        <button type="button" data-zoom-src="{{ Vite::asset('resources/images/help/logo-step-3.webp') }}" class="w-full">
                            <img src="{{ Vite::asset('resources/images/help/logo-step-3.webp') }}" alt="Согласование оттиска и позиции" class="w-full h-auto">
                        </button>
                        <figcaption class="p-3 text-sm text-gray-600">Согласование позиции и масштаба.</figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- Требования к макетам -->
        <section id="requirements" class="main-block scroll-mt-24" aria-labelledby="requirements-title">
            <h2 id="requirements-title" class="text-xl font-semibold mb-4">Требования к макетам</h2>
            <div class="grid md:grid-cols-2 gap-6 items-start">
                <div class="space-y-3">
                    <h3 class="font-semibold">Форматы и цвет</h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700">
                        <li>Вектор: <strong>SVG, PDF (все шрифты в кривых), AI/EPS</strong> — предпочтительно.</li>
                        <li>Растр: <strong>PNG/JPG</strong> от <strong>300&nbsp;dpi</strong> в масштабе 1:1, без полупрозрачностей.</li>
                        <li>Цвета — <strong>спот (Pantone)</strong> или 1–2 фирменных цвета. Градиенты/полутона не применяются для логотипной печати.</li>
                    </ul>

                    <h3 class="font-semibold mt-4">Линии и шрифты</h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700">
                        <li>Минимальная толщина линий: <strong>0,6–0,8&nbsp;мм</strong> (для бурого картона — ближе к 0,8 мм).</li>
                        <li>Минимальная высота строчных букв: <strong>3,5–4&nbsp;мм</strong>.</li>
                        <li>Избегайте инверсии тонких элементов (белое по тёмному полю).</li>
                    </ul>
                </div>
                <div class="space-y-3">
                    <h3 class="font-semibold">Размер и расположение</h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700">
                        <li>Указывайте желаемый размер логотипа на стороне коробки (ширина/высота) или приложите схему.</li>
                        <li>Отступы от краёв: не менее <strong>10–15&nbsp;мм</strong> от линий биговки/сгиба.</li>
                        <li>Не размещайте плашки и микро-элементы на участках сильной «гофры» или складок.</li>
                    </ul>

                    <div class="rounded border bg-gray-50 p-3 text-sm">
                        <p>Если файла нет — отметьте это при оформлении. Мы предложим подготовку простого логотипного макета (по вашему бренд-гайду или описанию).</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ограничения гофрокартона -->
        <section id="limits" class="main-block scroll-mt-24" aria-labelledby="limits-title">
            <h2 id="limits-title" class="text-xl font-semibold mb-4">Особенности и ограничения гофрокартона</h2>
            <div class="grid md:grid-cols-2 gap-6 items-start">
                <div>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700">
                        <li>Фактура и пружинистость материала могут слегка «раскидывать» тонкие штрихи.</li>
                        <li>Сплошные заливки на буром картоне выглядят темнее; возможна небольшая неоднородность.</li>
                        <li>Мелкие детали и тонкие выворотки лучше избегать.</li>
                        <li>Совмещение 2 цветов требует технологического зазора; минимальные допуски уточняются при согласовании.</li>
                    </ul>
                </div>
                <figure class="rounded border bg-gray-50 overflow-hidden">
                    <button type="button" data-zoom-src="{{ Vite::asset('resources/images/help/logo-limits.webp') }}" class="w-full">
                        <img src="{{ Vite::asset('resources/images/help/logo-limits.webp') }}" alt="Особенности печати на гофрокартоне" class="w-full h-auto">
                    </button>
                    <figcaption class="p-3 text-sm text-gray-600">Текстура материала влияет на тонкие элементы.</figcaption>
                </figure>
            </div>
            <div class="mt-4 rounded border bg-amber-50 p-4 text-sm">
                <p class="text-amber-900">
                    Предварительные визуализации и расчёты на сайте носят справочный характер и не являются публичной офертой. Итоговые параметры подтверждаем с менеджером после проверки макета и образца картона.
                </p>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="main-block scroll-mt-24" aria-labelledby="faq-title">
            <h2 id="faq-title" class="text-xl font-semibold mb-4">Частые вопросы</h2>
            <div class="divide-y rounded border">
                <details class="p-4">
                    <summary class="font-medium cursor-pointer">Можно ли нанести логотип на одну сторону и на крышку?</summary>
                    <div class="mt-2 text-gray-700">Да. В конфигураторе укажите желаемые позиции, либо приложите схему/комментарий — менеджер предложит вариант расположения и рассчитает надбавку.</div>
                </details>
                <details class="p-4">
                    <summary class="font-medium cursor-pointer">Подходит ли чёрно-белый PNG?</summary>
                    <div class="mt-2 text-gray-700">Если PNG достаточно крупный (300&nbsp;dpi в 1:1) и без полутонов — подойдёт. Но для наилучшего качества рекомендуем вектор (SVG/PDF c кривыми).</div>
                </details>
                <details class="p-4">
                    <summary class="font-medium cursor-pointer">Можно ли перед печатью получить пробный оттиск?</summary>
                    <div class="mt-2 text-gray-700">Да, для средних/крупных тиражей можем сделать тест/пробу, сроки и стоимость уточняет менеджер.</div>
                </details>
                <details class="p-4">
                    <summary class="font-medium cursor-pointer">Чем «логотип» отличается от «полноцветной печати»?</summary>
                    <div class="mt-2 text-gray-700">Логотип — это 1–2 спот-цвета без градиентов и полутонов. Полноцвет — фотореалистичные макеты, иллюстрации, градиенты; такие заказы согласуются индивидуально и считаются отдельно.</div>
                </details>
            </div>
        </section>

        <!-- CTA -->
        <section role="region" aria-labelledby="cta-title" class="main-block text-center">
            <div class="flex justify-center mb-6" aria-hidden="true">
                <svg class="guide-icon-bg" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <g>
                        <path d="M19 22H5c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2z"></path>
                        <line x1="16" y1="2" x2="16" y2="4"></line>
                        <line x1="8" y1="2" x2="8" y2="4"></line>
                        <circle cx="12" cy="11" r="3"></circle>
                        <path d="M17 18.5c-1.4-1-3.1-1.5-5-1.5s-3.6.6-5 1.5"></path>
                    </g>
                </svg>
            </div>
            <h2 id="cta-title" class="guide-h2-margin text-2xl font-semibold text-center mb-2">Нужна помощь с файлом?</h2>
            <p>Прикрепите то, что есть — мы подскажем, как довести до печати.</p>
            <div class="mt-4">
                <x-contact-form-button
                    button-text="Задать вопрос"
                    title="Вопрос по нанесению логотипа"
                    select-label="Тема обращения"
                    :select-options="['Нанесение логотипа', 'Подготовка макета', 'Другое']" />
            </div>
        </section>
    </div>

</section>
@endsection
