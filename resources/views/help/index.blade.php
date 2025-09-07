@extends('layouts.app')

@section('title', 'Справка — Мастерская Упаковки')
@section('meta_description', 'Раздел помощи: ответы на вопросы по заказу, доставке, оплате и возвратам.')

@section('content')
<section aria-labelledby="help-title">
    <div class="mx-auto">
        <!-- Шапка раздела -->
        <header class="main-block guide-header text-center mb-8">
            <nav aria-label="Навигация по разделам" class="mb-2">
                <a class="underline" href="/">На главную</a>
            </nav>
            <h1 id="help-title" class="main-h1">Справка</h1>
        </header>

        <!-- Карточки разделов -->
        <section class="main-block" aria-labelledby="help-sections-title">
            <h2 id="help-sections-title" class="sr-only">Разделы помощи</h2>

            <ul id="help-list" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                <!-- Как оформить заказ -->
                <li class="help-item" data-tags="заказ оформление инструкция конфигуратор">
                    <a href="{{ route('help.how_to_order') }}"
                       class="group block rounded border bg-white p-5 transition hover:shadow-md focus:outline-none focus-visible:ring">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded bg-blue-50 border">
                                <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 6h16M4 12h16M4 18h10" stroke="#1e40af" stroke-width="1.6" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold group-hover:underline">Как оформить заказ</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Пошагово: выбор конструкции, параметры, файлы, корзина, оформление.</p>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Доставка -->
                <li class="help-item" data-tags="доставка сдэк самовывоз транспортные компании">
                    <a href="{{ route('help.delivery') }}"
                       class="group block rounded border bg-white p-5 transition hover:shadow-md focus:outline-none focus-visible:ring">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded bg-emerald-50 border">
                                <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 7h11v10H3zM14 10h4l3 3v4h-7zM7 20a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill="#065f46"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold group-hover:underline">О доставке</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Самовывоз, СДЭК, другие ТК. Сроки, условия и адреса терминалов.</p>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Оплата -->
                <li class="help-item" data-tags="оплата счет квитанция безнал карта">
                    <a href="{{ route('help.payment') }}"
                       class="group block rounded border bg-white p-5 transition hover:shadow-md focus:outline-none focus-visible:ring">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded bg-amber-50 border">
                                <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 6h18v4H3zM3 12h18v6H3z" fill="#92400e"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold group-hover:underline">Об оплате</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Способы и реквизиты оплаты для физлиц и компаний.</p>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Возвраты -->
                <li class="help-item" data-tags="возврат рекламация брак гарантия">
                    <a href="{{ route('help.returns') }}"
                       class="group block rounded border bg-white p-5 transition hover:shadow-md focus:outline-none focus-visible:ring">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded bg-rose-50 border">
                                <svg width="20px" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" fill="#9f1239"><g><path d="M0 0h48v48H0z" fill="none"></path><g><path d="M10,22v2c0,7.72,6.28,14,14,14s14-6.28,14-14s-6.28-14-14-14h-6.662l3.474-4.298l-3.11-2.515L10.577,12l7.125,8.813 l3.11-2.515L17.338,14H24c5.514,0,10,4.486,10,10s-4.486,10-10,10s-10-4.486-10-10v-2H10z"></path></g></g></svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold group-hover:underline">О возвратах</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Порядок возврата, обмена и рассмотрения претензий.</p>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- FAQ -->
                <li class="help-item" data-tags="faq вопросы ответы справка">
                    <a href="{{ route('help.faq') }}"
                       class="group block rounded border bg-white p-5 transition hover:shadow-md focus:outline-none focus-visible:ring">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded bg-indigo-50 border">
                                <svg width="20px" fill="#3730a3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M4,23H20a1,1,0,0,0,1-1V6a1,1,0,0,0-.293-.707l-4-4A1,1,0,0,0,16,1H4A1,1,0,0,0,3,2V22A1,1,0,0,0,4,23ZM5,3H15.586L19,6.414V21H5Zm8,13v1a1,1,0,0,1-2,0V16a1,1,0,0,1,2,0Zm1.954-7.429a3.142,3.142,0,0,1-1.789,3.421.4.4,0,0,0-.165.359V13a1,1,0,0,1-2,0v-.649a2.359,2.359,0,0,1,1.363-2.191A1.145,1.145,0,0,0,12.981,8.9a1.069,1.069,0,0,0-.8-.88.917.917,0,0,0-.775.2,1.155,1.155,0,0,0-.4.9,1,1,0,1,1-2,0,3.151,3.151,0,0,1,1.127-2.436,2.946,2.946,0,0,1,2.418-.632A3.085,3.085,0,0,1,14.954,8.571Z"></path></g></svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold group-hover:underline">FAQ</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">Короткие ответы на самые частые вопросы.</p>
                            </div>
                        </div>
                    </a>
                </li>

            </ul>
        </section>
    </div>

</section>
@endsection
