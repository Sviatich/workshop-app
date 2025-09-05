@extends('layouts.app')

@section('title', 'Об оплате — Мастерская Упаковки')
@section('meta_description', 'Доступные способы оплаты и реквизиты.')

@section('content')
    <section aria-labelledby="payment-page-title">
        <div class="mx-auto">
            <div class="main-block mb-10 guide-header text-center">
                <nav aria-label="Навигация по разделам" class="mb-2">
                    <a class="underline" href="/help">Справка</a>
                </nav>
                <h1 id="payment-page-title" class="main-h1">Оплата заказов</h1>
            </div>

            <!-- НЕ используем role="main" здесь: главный landmark уже выше -->
            <section class="main-block space-y-12">
                <div class="space-y-12">

                    <!-- Способы оплаты -->
                    <h2 id="payment-methods-title" class="text-2xl font-semibold mb-4">Способы оплаты</h2>
                    <section class="grid gap-6 md:grid-cols-2 md:gap-10 items-start">
                        <!-- Левая колонка: Способы оплаты -->
                        <section role="region" aria-labelledby="payment-methods-title" class="order-2 md:order-1 mt-0">

                            <ul class="space-y-6 guide-text">
                                <li>
                                    <p>
                                        <span class="font-bold">Для физических лиц.</span>
                                        После подтверждения заказа менеджером вы получаете безопасную ссылку на оплату онлайн через сервис
                                        ЮKassa.
                                    </p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span
                                            class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">МИР</span>
                                        <span
                                            class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">VISA</span>
                                        <span
                                            class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">Mastercard</span>
                                    </div>
                                </li>

                                <li>
                                    <p>
                                        <span class="font-bold">Для юридических лиц и ИП.</span>
                                        Выставляем счёт после согласования параметров. Оплата производится с расчётного
                                        счёта вашей компании.
                                    </p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">Оплата по счету</span>
                                    </div>
                                </li>
                            </ul>
                        </section>

                        <!-- Правая колонка: изображение -->
                        <figure
                            class="p-6 order-1 md:order-2 w-full bg-gray-100 border rounded overflow-hidden flex items-center justify-center">
                            <img src="{{ Vite::asset('resources/images/payment-info-1.webp') }}"
                                alt="Выбор способа оплаты на сайте" class="w-full h-auto object-contain md:object-cover">
                        </figure>
                    </section>


                    <!-- Безопасность -->
                    <section role="region" aria-labelledby="payment-security-title">
                        <h2 id="payment-security-title" class="text-2xl font-semibold mb-4">Это безопасно</h2>
                        <ul class="space-y-3 guide-text">
                            <li>
                                Платёжная страница защищена: данные карты обрабатываются на стороне платёжного провайдера с
                                использованием
                                SSL-шифрования и стандартов безопасности PCI DSS. Мы не храним реквизиты карт на своём
                                сервере.
                            </li>
                        </ul>
                    </section>

                    <!-- Процесс -->
                    <section role="region" aria-labelledby="payment-process-title">
                        <h2 id="payment-process-title" class="text-2xl font-semibold mb-4">Как всё происходит</h2>
                        <ol class="list-decimal pl-6 space-y-3 guide-text">
                            <li>Вы формируете заявку через калькулятор.</li>
                            <li>Менеджер уточняет детали и подтверждает заказ.</li>
                            <li>
                                <span class="font-bold">Физ. лица:</span> отправляем ссылку на онлайн-оплату через ЮKassa.
                                <br>
                                <span class="font-bold">Юр. лица/ИП:</span> выставляем счёт для безналичной оплаты.
                            </li>
                            <li>После поступления оплаты запускаем производство и держим вас в курсе сроков.</li>
                        </ol>
                    </section>

                    <!-- Возвраты/корректировки -->
                    <section role="region" aria-labelledby="refunds-title">
                        <h2 id="refunds-title" class="text-2xl font-semibold mb-4">Возвраты и корректировки</h2>
                        <p class="guide-text mb-2">
                            Если нужно изменить заказ — сообщите менеджеру. Пересчитаем стоимость и согласуем новые условия.
                        </p>
                        <p class="guide-text">
                            Возвраты (при необходимости) оформляем в соответствии с согласованным договором и действующим
                            законодательством:
                            <span class="font-medium">физ. лицам</span> — на карту/способ оплаты; <span
                                class="font-medium">юр. лицам/ИП</span> — на расчётный счёт.
                        </p>
                    </section>
                </div>
            </section>

            <!-- Контакты/вопросы -->
            <section role="region" aria-labelledby="questions-title" class="main-block text-center">
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
                <h2 id="questions-title" class="text-2xl font-semibold">Остались вопросы?</h2>
                <ul class="space-y-1 guide-text">
                    <li>Email: <a href="mailto:workshop@mp.market" class="text-blue-600 underline">workshop@mp.market</a>
                    </li>
                    <li>Телефон: 8 (800) 550-37-00</li>
                </ul>
            </section>
        </div>
    </section>


@endsection