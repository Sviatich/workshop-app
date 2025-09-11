@extends('layouts.app')

@section('title', 'Доставка товара — Мастерская Упаковки')
@section('meta_description', 'Информация о способах и сроках доставки, самовывоз и транспортные компании.')

@section('content')
    <section aria-labelledby="shipping-page-title">
        <div class="main-block mb-10 guide-header">
            @include('partials.breadcrumbs', ['items' => [
                ['label' => 'Главная', 'url' => route('home')],
                ['label' => 'Справка', 'url' => route('help.index')],
                ['label' => 'Доставка']
            ]])
            <h1 id="shipping-page-title" class="main-h1">Доставка товара</h1>
        </div>
        <section class="main-block">
            <h2 class="sr-only">Варианты получения заказа</h2>
            <div class="overflow-hidden">
                <div role="tablist" aria-label="Варианты получения" class="mb-6 rounded p-2 flex bg-gray-100 border">
                    <button role="tab" id="tab-pickup" aria-controls="panel-pickup" aria-selected="true" tabindex="0"
                        class="cursor-pointer w-full rounded flex-1 px-4 py-3 text-sm font-medium focus:outline-none focus-visible:ring">
                        Самовывоз
                    </button>
                    <button role="tab" id="tab-carriers" aria-controls="panel-carriers" aria-selected="false"
                        tabindex="-1"
                        class="cursor-pointer w-full rounded flex-1 px-4 py-3 text-sm font-medium focus:outline-none focus-visible:ring">
                        Транспортные компании
                    </button>
                </div>
                <div>
                    <section id="panel-pickup" role="tabpanel" aria-labelledby="tab-pickup" tabindex="0"
                        class="md:pt-0">
                        <div class="grid lg:grid-cols-1 gap-6">
                            <div class="rounded border overflow-hidden bg-gray-100">
                                <div class="aspect-video md:h-full">
                                    <iframe
                                        src="https://yandex.ru/map-widget/v1/?um=constructor%3A3d3301515131ab79f791647d6919c21b7d09618f51108abb85888f98206eac3e&amp;source=constructor"
                                        class="w-full h-full" frameborder="0" title="Карта: адрес самовывоза"></iframe>
                                </div>
                            </div>
                            <div class="mb-4 grid sm:grid-cols-2 gap-4">
                                <div class="p-4 md:p-6 rounded bg-gray-100">
                                    <h4 class="font-semibold mb-2 flex gap-2 mb-4">
                                        <svg width="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM3.00683 12C3.00683 16.9668 7.03321 20.9932 12 20.9932C16.9668 20.9932 20.9932 16.9668 20.9932 12C20.9932 7.03321 16.9668 3.00683 12 3.00683C7.03321 3.00683 3.00683 7.03321 3.00683 12Z" fill="#333"></path>
                                            <path d="M12 5C11.4477 5 11 5.44771 11 6V12.4667C11 12.4667 11 12.7274 11.1267 12.9235C11.2115 13.0898 11.3437 13.2343 11.5174 13.3346L16.1372 16.0019C16.6155 16.278 17.2271 16.1141 17.5032 15.6358C17.7793 15.1575 17.6155 14.5459 17.1372 14.2698L13 11.8812V6C13 5.44772 12.5523 5 12 5Z" fill="#333"></path>
                                        </svg>
                                        График работы склада
                                    </h4>
                                    <div class="flex gap-6 relative justify-between text-sm">
                                        <p class="time-badge">09:00</p>
                                        <p class="time-badge">13:00</p>
                                        <p class="time-badge">14:00</p>
                                        <p class="time-badge">17:00</p>
                                    </div>
                                    <div class="flex gap-2 justify-between mb-5 mx-4">   
                                        <div class="primary-bg-color h-1 w-[32%] rounded mt-4"></div>
                                        <div class="bg-gray-400 h-1 w-[32%] rounded mt-4"></div>
                                        <div class="primary-bg-color h-1 w-[32%] rounded mt-4"></div>
                                    </div>
                                    <div class="flex gap-2 justify-between">
                                        <div class="text-sm text-center bg-blue-200 rounded w-full primary-text-color">Пн</div>
                                        <div class="text-sm text-center bg-blue-200 rounded w-full primary-text-color">Вт</div>
                                        <div class="text-sm text-center bg-blue-200 rounded w-full primary-text-color">Ср</div>
                                        <div class="text-sm text-center bg-blue-200 rounded w-full primary-text-color">Чт</div>
                                        <div class="text-sm text-center bg-blue-200 rounded w-full primary-text-color">Пт</div>
                                        <div class="text-sm text-center bg-gray-200 rounded w-full text-gray-500">Сб</div>
                                        <div class="text-sm text-center bg-gray-200 rounded w-full text-gray-500">Вс</div>
                                    </div>
                                </div>
                                <div class="p-4 md:p-6 rounded bg-gray-100">
                                    <h4 class="font-semibold mb-2 flex gap-2">
                                        <svg width="15px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                                            fill="#333">
                                            <g>
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z">
                                                </path>
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z">
                                                </path>
                                            </g>
                                        </svg>
                                        Адрес склада
                                    </h4>
                                    <address class="not-italic">
                                        <div class="block">Московская область, г.
                                            Черноголовка, ул. Первый проезд,
                                            зд. 8, стр. 1</a>
                                    </address>
                                    <a target="_blank" href="https://yandex.ru/profile/142486939387?lang=ru" class="flex gap-2 mt-4 primary-text-color underline">
                                        <img width="17px" src="{{ Vite::asset('resources/images/yandex.svg') }}" alt="Иконка Yandex"> Открыть на карте
                                    </a>
                                </div>
                            </div>
                            <div class="space-y-5">
                                <h3 class="text-xl font-semibold">Самовывоз со склада </h3>
                                <div class="mb-6">
                                    <h4 class="font-semibold mb-2">Условия самовывоза</h4>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Выдача только после уведомления о готовности заказа.</li>
                                        <li>Необходимо заранее согласовать дату и время с менеджером компании. Вам
                                            приготовят пропуск на территорию.</li>
                                        <li>Для водителя — при необходимости доверенность.</li>
                                        <li>Сотрудники склада помогут с подъемом и погрузкой в ваш транспорт.</li>
                                    </ul>
                                </div>
                                <div class="">
                                    <h4 class="font-semibold mb-2">Порядок получения</h4>
                                    <ol class="list-decimal pl-6 space-y-2">
                                        <li>Согласуем дату/окно выдачи с менеджером.</li>
                                        <li>Готовим партию и документы, отправляем уведомление.</li>
                                        <li>Забираете на складе, проверяете комплектность.</li>
                                        <li>Если возникли вопросы по качеству или количеству товара, Вы можете
                                            обратиться к менеджеру компании на месте.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="panel-carriers" role="tabpanel" aria-labelledby="tab-carriers" tabindex="0" hidden
                        class="md:pt-0">
                        <div class="space-y-6">
                            <div class="p-4 md:p-8 border rounded">
                                <div class="flex items-center justify-start gap-4 mb-4">
                                    <figure
                                        class="p-2 bg-gray-100 border rounded overflow-hidden flex items-center justify-center">
                                        <img width="70px" src="{{ Vite::asset('resources/images/pek.webp') }}"
                                            alt="ТК «ПЭК»" class="object-contain md:object-cover">
                                    </figure>
                                    <h3 class="text-xl font-semibold">ТК ПЭК</h3>
                                </div>
                                <p class="mt-1">Бесплатно довезём до терминала «ПЭК» по адресу ниже. Оплата
                                    межгорода — по тарифам «ПЭК» при получении или по счёту перевозчика.</p>
                                <div class="mt-4 grid sm:grid-cols-1 gap-4">
                                    <div>
                                        <h4 class="font-semibold mb-1">Терминал отгрузки</h4>
                                        <address class="not-italic">
                                            <a target="_blank" href="https://yandex.ru/maps/-/CLQoJTor" class="block underline primary-text-color">Электростальское шоссе, 25, Ногинск, Богородский городской округ, Московская область, 142410</a>
                                        </address>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-1">Что важно знать</h4>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Габариты/вес — по факту приёмки на терминале.</li>
                                            <li>Подъем и разгрузка при получении согласуется с представителем транспортной компании.</li>
                                            <li>Менеджер заранее свяжется с вами и сообщит о передаче вашего заказа транспортной компании.</li>
                                            <li>Мы не несем ответственности за целостность груза, после его передачи транспорной компании.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="p-8 border rounded space-y-4">
                                <div class="flex items-center justify-start gap-4 mb-4">
                                    <figure
                                        class="p-2 bg-gray-100 border rounded overflow-hidden flex items-center justify-center">
                                        <img width="70px" src="{{ Vite::asset('resources/images/sdek.webp') }}"
                                            alt="ТК «СДЭК»" class="object-contain md:object-cover">
                                    </figure>
                                    <h3 class="text-xl font-semibold">ТК СДЭК</h3>
                                </div>
                                <p class="mt-1">Оплата доставки — по тарифам «СДЭК». Вы можете получить расчет доставки по вашему адресу или до ближайшего к вам ПВЗ на странице оформления заказа.</p>
                                <div class="grid md:grid-cols-1 gap-4">
                                    <div>
                                        <h4 class="font-semibold mb-2">Доставка до двери</h4>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Курьерская доставка по указанному адресу.</li>
                                            <li>Сроки и цена зависят от региона и габаритов и веса.</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold mb-2">Доставка до ПВЗ</h4>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Получение в удобном пункте выдачи.</li>
                                            <li>Сроки и цена зависят от региона и габаритов и веса.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="p-8 border rounded">
                                <h3 class="text-xl font-semibold">Другая ТК по вашему выбору</h3>
                                <p class="mt-1">Можем отправить любой транспортной компанией по вашему желанию или
                                    передать груз вашему перевозчику.</p>
                                <ul class="list-disc pl-5 space-y-1 mt-2">
                                    <li>Передача со склада в будни в рабочее время.</li>
                                    <li>Необходимы данные ТК/контакты менеджера/номер заявки.</li>
                                    <li>Условия упаковки/паллетирования — по требованиям выбранной ТК.</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
        <section role="region" aria-labelledby="shipping-terms-title" class="main-block text-center">
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
            <h2 id="shipping-terms-title" class="guide-h2-margin text-2xl font-semibold text-center mb-4">Остались
                вопросы?</h2>
            <p>Наши менеджеры всегда готовы помочь</p>
            <div class="mt-4">
                <x-contact-form-button button-text="Задать вопрос" title="Вопрос по доставке"
                    select-label="Тема обращения" :select-options="['Вопрос по доставке', 'Другое']" />
            </div>
        </section>
    </section>
@endsection
@vite(['resources/js/deliverypagescript.js'])
