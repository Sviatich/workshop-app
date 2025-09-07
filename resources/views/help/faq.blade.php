@extends('layouts.app')

@section('title', 'FAQ — Мастерская Упаковки')
@section('meta_description', 'Часто задаваемые вопросы о заказе, доставке и оплате.')

@section('content')
    <div class="main-block mb-10 guide-header">
        @include('partials.breadcrumbs', ['items' => [
            ['label' => 'Главная', 'url' => route('home')],
            ['label' => 'Справка', 'url' => route('help.index')],
            ['label' => 'Вопросы и ответы']
        ]])
        <h1 id="payment-page-title" class="main-h1">Часто задаваемые вопросы</h1>
    </div>
    <section id="faq" aria-labelledby="faq-heading" class="main-block">
        <div class="faq-wrap">
            <h2>Заказ и оплата</h2>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Как оформить заказ?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Выберите конструкцию и укажите размеры, тираж и опции. После расчёта добавьте позицию в корзину и
                        заполните контакты — система создаст номер и ссылку на заказ.</p>
                    <ul>
                        <li>Нестандартные размеры возможны — надбавка считается автоматически.</li>
                        <li>Файлы (логотип/макет) можно загрузить сразу или позже на странице заказа.</li>
                    </ul>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Как оплатить заказ?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Оплата для физлиц и юрлиц/ИП. Онлайн-оплата картой или по счету — после
                        подтверждения заказа со стороны менеджера. Все необходимые чеки и закрывающие документы предоставим.
                    </p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Можно ли внести предоплату, а остаток оплатить позже?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Нет. Заказ будет поставлен в производство только после 100% предоплаты.</p>
                </div>
            </details>
            <h2 class="mt-8">Сроки и доставка</h2>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Какие сроки изготовления?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Производство: 2–7 рабочих дней (зависит от тиража и опций). Доставка по России курьером/ТК, самовывоз
                        — по
                        согласованию.</p>
                    <p>Итоговые сроки и стоимость доставки считаются при оформлении заказа после указания адреса.</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Сколько занимает доставка?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>После передачи заказа транспортной компании, доставка занимает в среднем 1-2 рабочих дня по Москве и
                        области, в регионы — индивидуально.</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Можно ли ускорить изготовление?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Все заказы выполняются в порядке очереди. Однако мы готовы рассмотреть приоритетное размещение, если
                        у вас форс-мажорная ситуация. В таком случае обратитесь к менеджеру компании по телефону
                        8&nbsp;800&nbsp;550-37-00.</p>
                </div>
            </details>
            <h2 class="mt-8">Печать и дизайн</h2>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Какие требования к макету?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Загрузите логотип/макет (SVG/PNG/PDF) в конфигураторе или позже. Для полноцветной печати цена
                        согласуется
                        после проверки файла.</p>
                    <p>Требования: поля 5 мм, шрифты в кривых, профиль CMYK.</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Поможете с дизайном, если нет макета?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Да, можно выбрать опцию «Разработка дизайна» при оформлении:</p>
                    <ul>
                        <li>Базовая подготовка (логотип/текст) — +500 ₽</li>
                        <li>Макет по чертежу — +2 000 ₽</li>
                        <li>Полноценный дизайн упаковки — +5 500 ₽</li>
                    </ul>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Как считается полноцветная печать?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Калькулятор покажет предварительный расчёт без цены на полноцвет — требуется проверка менеджером.
                        Загрузите
                        макет, мы оценим и пришлём итоговую стоимость на согласование.</p>
                </div>
            </details>
            <h2 class="mt-8">Производство и материалы</h2>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Есть ли минимальный тираж?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Минимальный тираж — от 25 шт. Пробный образец возможен, но только по согласованию и оплачивается
                        отдельно.
                    </p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Что с нестандартными размерами?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Сначала предложим ближайшие стандартные размеры (±80 мм) — это дешевле и быстрее. Если требуется свой
                        размер, применяется надбавка 5 000 ₽ и срок согласуется индивидуально.</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Какие варианты картона есть?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Предлагаем бурый, бело-бурый и бело-белый картон разной прочности. Подбор зависит от тиража и условий
                        использования упаковки. По умолчанию коробки изготавливаются из картона профиля Е (1.5 мм) и профиля
                        В (2.0 мм).</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Можно ли заказать разные конструкции в одном тираже?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Да, в заказ можно добавить несколько конструкций. Каждая позиция рассчитывается отдельно и
                        учитывается в
                        общем заказе.</p>
                </div>
            </details>
            <h2 class="mt-8">Дополнительно</h2>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Делаете ли вы бесплатные образцы?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Образцы коробок изготавливаются платно по предварительному согласованию. Бесплатно можем предоставить
                        3D визуализацию вашего короба.</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Можно ли хранить коробки на складе?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>При необходимости можем организовать хранение вашей партии на нашем складе. Условия и сроки
                        обговариваются индивидуально.</p>
                </div>
            </details>
            <details class="faq-item btn-hover-effect-dark">
                <summary>
                    <span class="q">Предоставляете ли вы скидки на большие тиражи?</span>
                    <span class="faq-icon" aria-hidden="true"></span>
                </summary>
                <div class="faq-content main-gray-color">
                    <p>Акции, персональные скидки и купоны не предоставляются, однако цена за одну коробку автоматически
                        уменьшается обратно пропорционально тиражу — чем больше тираж, тем ниже стоимость одной коробки.</p>
                </div>
            </details>
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
            <x-contact-form-button button-text="Задать вопрос" title="Что хотели бы узнать?" select-label="Тема обращения"
                :select-options="['Оплата заказа', 'Сроки и доставка', 'Печать и дизайн', 'Производство и материалы', 'Другое']" />
        </div>
    </section>
@endsection
