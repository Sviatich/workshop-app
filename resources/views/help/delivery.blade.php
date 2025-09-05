@extends('layouts.app')

@section('title', 'О доставке — ' . config('app.name'))
@section('meta_description', 'Информация о способах и сроках доставки, самовывоз и транспортные компании.')

@section('content')
    <section aria-labelledby="shipping-page-title">
        <div class="mx-auto">
            <div class="main-block mb-10 guide-header text-center">
                <nav aria-label="Навигация по разделам" class="mb-2">
                    <a class="underline" href="/help">Справка</a>
                </nav>
                <h1 id="shipping-page-title" class="main-h1">О доставке</h1>
            </div>

            <section class="main-block space-y-12">
                <div class="space-y-12">

                    <!-- Иллюстрация / баннер -->
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?um=constructor%3A3d3301515131ab79f791647d6919c21b7d09618f51108abb85888f98206eac3e&amp;source=constructor"
                        width="100%" height="450" frameborder="0"></iframe>

                    <!-- Способы доставки -->
                    <section role="region" aria-labelledby="shipping-methods-title">
                        <h2 id="shipping-methods-title" class="text-2xl font-semibold mb-4">🚚 Способы доставки</h2>

                        <ul class="space-y-6 guide-text">
                            <li>
                                <p>
                                    <span class="font-bold">Курьер до двери</span> — удобная доставка по указанному адресу в
                                    рабочие дни.
                                    Курьер заранее свяжется с вами для согласования времени визита.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">Курьер</span>
                                    <span class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">До
                                        двери</span>
                                </div>
                            </li>

                            <li>
                                <p>
                                    <span class="font-bold">Пункты выдачи СДЭК</span> — заберите заказ неподалёку от дома
                                    или офиса.
                                    Уведомление о поступлении придёт в СМС/мессенджер.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">ПВЗ</span>
                                    <span
                                        class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">СДЭК</span>
                                </div>
                            </li>

                            <li>
                                <p>
                                    <span class="font-bold">Самовывоз</span> — доступен по предварительному согласованию,
                                    когда партия готова.
                                    Точные адрес и график выдачи сообщит менеджер.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">Самовывоз</span>
                                    <span class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-800 font-medium">По
                                        записи</span>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- География и сроки -->
                    <section role="region" aria-labelledby="zones-lead-time-title">
                        <h2 id="zones-lead-time-title" class="text-2xl font-semibold mb-4">🗺️ География и сроки</h2>
                        <div class="grid md:grid-cols-2 gap-6 guide-text">
                            <div class="p-4 border rounded">
                                <h3 class="font-semibold mb-2">Москва и область</h3>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Курьер/ПВЗ: обычно <span class="font-medium">2–5 рабочих дней</span> после
                                        готовности партии.</li>
                                    <li>Доставка в ТТК/ЦАО согласовывается по времени и доступу.</li>
                                </ul>
                            </div>
                            <div class="p-4 border rounded">
                                <h3 class="font-semibold mb-2">Регионы РФ</h3>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Сроки зависят от адреса и тарифа перевозчика — ориентир даст менеджер при
                                        оформлении.</li>
                                    <li>Дальние регионы и труднодоступные зоны — по индивидуальному расчёту.</li>
                                </ul>
                            </div>
                        </div>
                        <p class="guide-text mt-3 text-gray-600">
                            В праздники и периоды пиковой нагрузки сроки могут увеличиваться — мы обязательно предупредим
                            заранее.
                        </p>
                    </section>

                    <!-- Стоимость и расчет -->
                    <section role="region" aria-labelledby="shipping-pricing-title">
                        <h2 id="shipping-pricing-title" class="text-2xl font-semibold mb-4">💰 Стоимость доставки</h2>
                        <div class="space-y-3 guide-text">
                            <p>Цена зависит от габаритов, веса, количества мест, адреса и выбранного способа (курьер / ПВЗ).
                                Мы считаем доставку по актуальным тарифам перевозчика (СДЭК) и показываем ориентир до
                                подтверждения.</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li><span class="font-medium">Стандартные партии</span> — быстрая калькуляция по тарифам.
                                </li>
                                <li><span class="font-medium">Крупногабарит</span> (большие коробки/объёмный вес) —
                                    индивидуальный расчёт.</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Упаковка и маркировка -->
                    <section role="region" aria-labelledby="packing-title">
                        <h2 id="packing-title" class="text-2xl font-semibold mb-4">📦 Упаковка и маркировка</h2>
                        <div class="space-y-3 guide-text">
                            <p>Учитываем особенности коробок: упаковываем аккуратно, защищаем от влаги и деформаций,
                                маркируем каждое место для удобного приёма на ПВЗ/складе.</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Групповая термоусадка / стретч по необходимости.</li>
                                <li>Маркировка с номером заказа и контактами получателя.</li>
                                <li>Отдельные места под печатные образцы и документацию.</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Процесс -->
                    <section role="region" aria-labelledby="shipping-process-title">
                        <h2 id="shipping-process-title" class="text-2xl font-semibold mb-4">📝 Как всё происходит</h2>
                        <ol class="list-decimal pl-6 space-y-3 guide-text">
                            <li>Вы оформляете заявку в конфигураторе и выбираете удобный способ доставки.</li>
                            <li>Мы подтверждаем заказ, сроки производства и ориентир по доставке.</li>
                            <li>Формируем партию и передаём в доставку (курьер / ПВЗ СДЭК / самовывоз).</li>
                            <li>Вы получаете уведомление с номером отправления и отслеживанием.</li>
                            <li>Получаете заказ и проверяете комплектность на месте выдачи.</li>
                        </ol>
                    </section>

                    <!-- Получение и проверка -->
                    <section role="region" aria-labelledby="receiving-title">
                        <h2 id="receiving-title" class="text-2xl font-semibold mb-4">✅ Получение и проверка</h2>
                        <div class="space-y-3 guide-text">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Осмотрите упаковку при выдаче: целостность, следы вскрытия, влажность.</li>
                                <li>При повреждениях — зафиксируйте фото/видео, попросите акт у сотрудника ПВЗ/курьера и
                                    свяжитесь с нами.</li>
                                <li>Несоответствия по количеству/комплектности — сообщите менеджеру в течение 24 часов после
                                    получения.</li>
                            </ul>
                            <p>Мы оперативно поможем с урегулированием и организуем замену/допоставку
                                при подтверждении случая.</p>
                        </div>
                    </section>

                </div>
            </section>

            <!-- Контакты/вопросы -->
            <section role="region" aria-labelledby="shipping-questions-title" class="main-block text-center">
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
                <h2 id="shipping-questions-title" class="text-2xl font-semibold">Нужна помощь с доставкой?</h2>
                <ul class="space-y-1 guide-text">
                    <li>Email: <a href="mailto:workshop@mp.market" class="text-blue-600 underline">workshop@mp.market</a>
                    </li>
                    <li>Телефон: 8 (800) 550-37-00</li>
                </ul>
            </section>
        </div>
    </section>

@endsection