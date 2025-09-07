@extends('layouts.app')

@section('title', 'Как оформить заказ — Мастерская Упаковки')
@section('meta_description', 'Пошаговая инструкция оформления заказа: выбор коробки, конфигуратор, загрузка логотипа/макета, корзина, доставка и передача менеджеру.')

@section('content')
<section aria-labelledby="howto-title">
    <div class="main-block mb-10 guide-header">
        @include('partials.breadcrumbs', ['items' => [
            ['label' => 'Главная', 'url' => route('home')],
            ['label' => 'Справка', 'url' => route('help.index')],
            ['label' => 'Как оформить заказ']
        ]])
        <h1 id="howto-title" class="main-h1">Как оформить заказ?</h1>
    </div>
    <div class="space-y-8">
        <section id="step-1" class="main-block scroll-mt-24" aria-labelledby="step-1-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div class="space-y-3">
                    <h2 id="step-1-title" class="text-xl font-semibold mb-4">1. Выберите конструкцию коробки</h2>
                    <p>Перейдите на страницу конфигуратора и выберите подходящую конструкцию.</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Если сомневаетесь — ориентируйтесь на назначение (отправка, витрина, хранение).</li>
                        <li>Можно начать с типовых размеров или задать свои.</li>
                    </ul>
                </div>
                <figure class="flex flex-col justify-center items-center">
                    <img width="90%" src="{{ Vite::asset('resources/images/order-step-1.webp') }}" alt="Выбор конструкции на странице конфигуратора">
                </figure>
            </div>
        </section>
        <section id="step-2" class="main-block scroll-mt-24" aria-labelledby="step-2-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <figure class="flex flex-col justify-center items-center order-2 md:order-1">
                    <img width="60%" src="{{ Vite::asset('resources/images/order-step-2.webp') }}" alt="Форма параметров коробки">
                </figure>
                <div class="space-y-3 order-1 md:order-2">
                    <h2 id="step-2-title" class="text-xl font-semibold mb-4">2. Задайте параметры</h2>
                    <p>Укажите размеры (Д×Ш×В), тип картона, цвет/покрытие, тираж. Конфигуратор автоматически пересчитает параметры при изменении любого поля.</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Приближённые стандартные размеры предложатся автоматически (±80&nbsp;мм).</li>
                        <li>Если точного совпадения нет — может быть рассчитана надбавка за нестандарт.</li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="step-3" class="main-block scroll-mt-24" aria-labelledby="step-3-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div class="space-y-3">
                    <h2 id="step-3-title" class="text-xl font-semibold mb-4">3. Загрузите логотип и/или макет печати</h2>
                    <p>При необходимости добавьте логотип (простая печать) или макет полноцветной печати. Файлы предварительно загружаются, показан превью и статус.</p>
                    <p>При полноцветной печати стоимость не рассчитывается автоматически — позиция уйдёт менеджеру на согласование.</p>
                </div>
                <figure class="flex flex-col justify-center items-center">
                    <img width="90%" src="{{ Vite::asset('resources/images/order-step-3.webp') }}" alt="Загрузка логотипа и макета">
                </figure>
            </div>
        </section>
        <section id="step-4" class="main-block scroll-mt-24" aria-labelledby="step-4-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <figure class="flex flex-col justify-center items-center order-2 md:order-1">
                    <img width="40%" src="{{ Vite::asset('resources/images/order-step-4.webp') }}" alt="Блок стоимости и подсказок">
                </figure>
                <div class="space-y-3 order-1 md:order-2">
                    <h2 id="step-4-title" class="text-xl font-semibold mb-4">4. Проверка стоимости</h2>
                    <p>Цена пересчитывается автоматически по формуле для выбранной конструкции. Если включён логотип — добавляется доплата. При полноцветном макете — показывается отметка “требуется согласование”, стоимость и доставка не отображаются.</p>
                </div>
            </div>
        </section>
        <section id="step-5" class="main-block scroll-mt-24" aria-labelledby="step-5-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div class="space-y-3">
                    <h2 id="step-5-title" class="text-xl font-semibold mb-4">5. Добавьте позицию в корзину</h2>
                    <p>Нажмите “Добавить в корзину”. Позиция сохраняется (включая загруженные файлы). Можно добавить несколько позиций с разными параметрами.</p>
                    <p>Позиции с полноцветной печатью также добавляются, но без расчёта цены и доставки.</p>
                </div>
                <figure class="flex flex-col justify-center items-center">
                    <img width="80%" src="{{ Vite::asset('resources/images/order-step-5.webp') }}" alt="Добавление позиции в корзину">
                </figure>
            </div>
        </section>
        <section id="step-6" class="main-block scroll-mt-24" aria-labelledby="step-6-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <figure class="flex flex-col justify-center items-center order-2 md:order-1">
                    <img width="40%" src="{{ Vite::asset('resources/images/order-step-6.webp') }}" alt="Выбор способа доставки">
                </figure>
                <div class="space-y-3 order-1 md:order-2">
                    <h2 id="step-6-title" class="text-xl font-semibold mb-4">6. Доставка</h2>
                    <p>Выберите удобный способ: самовывоз, СДЭК (до двери или ПВЗ) или любая другая ТК. Для СДЭК доставка может быть рассчитана по вашему адресу/ПВЗ на этапе оформления.</p>
                </div>
            </div>
        </section>
        <section id="step-7" class="main-block scroll-mt-24" aria-labelledby="step-7-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <div class="space-y-3">
                    <h2 id="step-7-title" class="text-xl font-semibold mb-4">7. Оформление заказа</h2>
                    <p>На странице оформления заполните контакты, комментарии к заказу, при необходимости — прикрепите дополнительные файлы.</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Проверьте все позиции, тиражи и опции печати.</li>
                        <li>Для юридических лиц укажите реквизиты для счёта.</li>
                    </ul>
                </div>
                <figure class="flex flex-col justify-center items-center">
                    <img width="60%" src="{{ Vite::asset('resources/images/order-step-7.webp') }}" alt="Страница оформления заказа">
                </figure>
            </div>
        </section>
        <section id="step-8" class="main-block scroll-mt-24" aria-labelledby="step-8-title">
            <div class="grid md:grid-cols-2 gap-6 items-center">
                <figure class="flex flex-col justify-center items-center order-2 md:order-1">
                    <img width="70%" src="{{ Vite::asset('resources/images/order-step-8.webp') }}" alt="Экран подтверждения">
                </figure>
                <div class="space-y-3 order-1 md:order-2">
                    <h2 id="step-8-title" class="text-xl font-semibold mb-4">8. Подтверждение и связь с менеджером</h2>
                    <p>После отправки заявки мы свяжемся с вами для финального согласования макетов, сроков и условий. Для позиций с полноцветной печатью менеджер сообщит стоимость после проверки макета.</p>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
