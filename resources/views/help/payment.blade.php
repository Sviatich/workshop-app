@extends('layouts.app')

@section('title', 'Оплата заказа — Мастерская Упаковки')
@section('meta_description', 'Доступные способы оплаты и реквизиты.')

@section('content')
    <section aria-labelledby="payment-page-title">
        <div class="main-block mb-10 guide-header">
            @include('partials.breadcrumbs', ['items' => [
                ['label' => 'Главная', 'url' => route('home')],
                ['label' => 'Справка', 'url' => route('help.index')],
                ['label' => 'Оплата']
            ]])
            <h1 id="payment-page-title" class="main-h1">Оплата заказов</h1>
        </div>
        <section class="main-block space-y-12">
            <div class="space-y-12">
                <h2 id="payment-methods-title" class="text-2xl font-semibold mb-4">Способы оплаты</h2>
                <section class="grid gap-6 md:grid-cols-2 md:gap-10 items-start">
                    <section role="region" aria-labelledby="payment-methods-title" class="order-2 md:order-1 mt-0">
                        <ul class="space-y-6">
                            <li>
                                <p>
                                    <span class="font-bold">Для физических лиц.</span>
                                    После подтверждения заказа менеджером вы получаете безопасную ссылку на оплату
                                    онлайн через сервис
                                    ЮKassa.
                                </p>
                                <div class="mt-3">
                                    <ul class="footer__paylist">
                                      <li aria-label="Visa" title="Visa">
                                        <span class="pay pay--visa" aria-hidden="true">
                                          <svg fill="#FFF" viewBox="-1 4 35 20" version="1.1" xmlns="http://www.w3.org/2000/svg" style="width: 40px;height: 20px;">
                                            <path d="M15.854 11.329l-2.003 9.367h-2.424l2.006-9.367zM26.051 17.377l1.275-3.518 0.735 3.518zM28.754 20.696h2.242l-1.956-9.367h-2.069c-0.003-0-0.007-0-0.010-0-0.459 0-0.853 0.281-1.019 0.68l-0.003 0.007-3.635 8.68h2.544l0.506-1.4h3.109zM22.429 17.638c0.010-2.473-3.419-2.609-3.395-3.714 0.008-0.336 0.327-0.694 1.027-0.785 0.13-0.013 0.28-0.021 0.432-0.021 0.711 0 1.385 0.162 1.985 0.452l-0.027-0.012 0.425-1.987c-0.673-0.261-1.452-0.413-2.266-0.416h-0.001c-2.396 0-4.081 1.275-4.096 3.098-0.015 1.348 1.203 2.099 2.122 2.549 0.945 0.459 1.262 0.754 1.257 1.163-0.006 0.63-0.752 0.906-1.45 0.917-0.032 0.001-0.071 0.001-0.109 0.001-0.871 0-1.691-0.219-2.407-0.606l0.027 0.013-0.439 2.052c0.786 0.315 1.697 0.497 2.651 0.497 0.015 0 0.030-0 0.045-0h-0.002c2.546 0 4.211-1.257 4.22-3.204zM12.391 11.329l-3.926 9.367h-2.562l-1.932-7.477c-0.037-0.364-0.26-0.668-0.57-0.82l-0.006-0.003c-0.688-0.338-1.488-0.613-2.325-0.786l-0.066-0.011 0.058-0.271h4.124c0 0 0.001 0 0.001 0 0.562 0 1.028 0.411 1.115 0.948l0.001 0.006 1.021 5.421 2.522-6.376z">
                                            </path>
                                          </svg>
                                        </span>
                                      </li>
                                      <li aria-label="Mastercard" title="Mastercard">
                                        <span class="pay pay--mc" aria-hidden="true">
                                          <svg viewBox="0 -3 24 24" xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" style="width: 40px;height: 20px;">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path fill-rule="nonzero" d="M12 18.294a7.3 7.3 0 1 1 0-12.588 7.3 7.3 0 1 1 0 12.588zm1.702-1.384a5.3 5.3 0 1 0 0-9.82A7.273 7.273 0 0 1 15.6 12c0 1.89-.719 3.614-1.898 4.91zm-3.404-9.82a5.3 5.3 0 1 0 0 9.82A7.273 7.273 0 0 1 8.4 12c0-1.89.719-3.614 1.898-4.91zM12 8.205A5.284 5.284 0 0 0 10.4 12c0 1.488.613 2.832 1.6 3.795A5.284 5.284 0 0 0 13.6 12 5.284 5.284 0 0 0 12 8.205z"></path>
                                          </svg>
                                        </span>
                                      </li>
                                      <li aria-label="Мир" title="Мир">
                                        <span class="pay pay--mir" aria-hidden="true">
                                          <svg height="22px" width="40px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 780 440" xml:space="preserve" fill="#000000">
                                            <g transform="translate(-91.000000, -154.000000)">
                                              <g transform="translate(91.000000, 154.000000)">
                                                <path style="fill: #FFFFFF;" d="M544.1,240.5v108h60v-64h68c28.6-0.2,52.9-18.5,62.1-44H544.1z"></path>
                                                <path style="fill: #FFFFFF;" d="M536.1,151.5c3.5,44.1,45.3,79,96.3,79c0.2,0,104.3,0,104.3,0 c0.8-4,1.2-8.2,1.2-12.5c0-36.6-29.5-66.2-66-66.5L536.1,151.5z">
                                                </path>
                                                <path style="fill: #FFFFFF;" d="M447.3,229.4l0-0.1L447.3,229.4c0.7-1.2,1.8-1.9,3.2-1.9c2,0,3.5,1.6,3.6,3.5l0,0 v116.5h60v-196h-60c-7.6,0.3-16.2,5.8-19.4,12.7L387,266.6c-0.1,0.4-0.3,0.8-0.5,1.2l0,0l0,0c-0.7,1-1.9,1.7-3.3,1.7 c-2.2,0-4-1.8-4-4v-114h-60v196h60v0c7.5-0.4,15.9-5.9,19.1-12.7l49-105.1C447.2,229.6,447.3,229.5,447.3,229.4L447.3,229.4z">
                                                </path>
                                                <path style="fill: #FFFFFF;" d="M223.3,232.8l-35.1,114.7H145L110,232.7c-0.3-1.8-1.9-3.2-3.9-3.2 c-2.2,0-3.9,1.8-3.9,3.9c0,0,0,0,0,0l0,114h-60v-196h51.5H109c11,0,22.6,8.6,25.8,19.1l29.2,95.5c1.5,4.8,3.8,4.7,5.3,0 l29.2-95.5c3.2-10.6,14.8-19.1,25.8-19.1h15.3h51.5v196h-60v-114c0,0,0,0,0-0.1c0-2.2-1.8-3.9-3.9-3.9 C225.2,229.5,223.6,230.9,223.3,232.8L223.3,232.8z">
                                                </path>
                                              </g>
                                            </g>
                                          </svg>
                                        </span>
                                      </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <p>
                                    <span class="font-bold">Для юридических лиц и ИП.</span>
                                    Выставляем счёт после согласования параметров. Оплата производится с расчётного
                                    счёта вашей компании.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">Оплата
                                        по счету</span>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <figure
                        class="p-6 order-1 md:order-2 w-full bg-gray-100 border rounded overflow-hidden flex items-center justify-center">
                        <img src="{{ Vite::asset('resources/images/payment-info-1.webp') }}"
                            alt="Выбор способа оплаты на сайте" class="w-full h-auto object-contain md:object-cover">
                    </figure>
                </section>
                <section role="region" aria-labelledby="payment-security-title">
                    <h2 id="payment-security-title" class="text-2xl font-semibold mb-4">Это безопасно</h2>
                    <ul class="space-y-3">
                        <li>
                            Платёжная страница защищена: данные карты обрабатываются на стороне платёжного провайдера с
                            использованием
                            SSL-шифрования и стандартов безопасности PCI DSS. Мы не храним реквизиты карт на своём
                            сервере.
                        </li>
                    </ul>
                </section>
                <section role="region" aria-labelledby="payment-process-title">
                    <h2 id="payment-process-title" class="text-2xl font-semibold mb-4">Как всё происходит</h2>
                    <ol class="list-decimal pl-6 space-y-3">
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
                <section role="region" aria-labelledby="refunds-title">
                    <h2 id="refunds-title" class="text-2xl font-semibold mb-4">Возвраты и корректировки</h2>
                    <p class="mb-2">
                        Если нужно изменить заказ — сообщите менеджеру. Пересчитаем стоимость и согласуем новые условия.
                    </p>
                    <p>
                        Возвраты (при необходимости) оформляем в соответствии с согласованным договором и действующим
                        законодательством:
                        <span class="font-medium">физ. лицам</span> — на карту/способ оплаты; <span
                            class="font-medium">юр. лицам/ИП</span> — на расчётный счёт.
                    </p>
                </section>
            </div>
        </section>
        <section role="region" aria-labelledby="questions-title" class="main-block text-center">
            <div class="flex justify-center mb-6" aria-hidden="true">
                <svg class="guide-icon-bg" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 22H5c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2z"></path>
                    <line x1="16" y1="2" x2="16" y2="4"></line>
                    <line x1="8" y1="2" x2="8" y2="4"></line>
                    <circle cx="12" cy="11" r="3"></circle>
                    <path d="M17 18.5c-1.4-1-3.1-1.5-5-1.5s-3.6.6-5 1.5"></path>
                </svg>
            </div>
            <h2 id="questions-title" class="guide-h2-margin text-2xl font-semibold">Остались вопросы?</h2>
            <p>Наши менеджеры всегда готовы помочь</p>
            <div class="mt-4">
                <x-contact-form-button button-text="Задать вопрос" title="Вопрос по оплате" select-label="Тема обращения"
                    :select-options="['Вопрос по оплате заказа', 'Другое']" />
            </div>
        </section>
    </section>
@endsection
