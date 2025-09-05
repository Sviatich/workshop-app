@extends('layouts.app')

@section('title', 'О возвратах — ' . config('app.name'))
@section('meta_description', 'Условия обмена и возврата продукции.')

@section('content')
  <section aria-labelledby="returns-page-title">
    <div class="mx-auto">
      <div class="main-block mb-10 guide-header text-center">
        <nav aria-label="Навигация по разделам" class="mb-2">
          <a class="underline" href="/help">Справка</a>
        </nav>
        <h1 id="returns-page-title" class="main-h1">Возвраты и обмен</h1>
      </div>

      <section class="main-block space-y-12">
        <div class="space-y-12">

          <!-- Блоки по типам клиентов с чипсами -->
          <section role="region" aria-labelledby="who-returns-title">
            <h2 id="who-returns-title" class="text-2xl font-semibold mb-4">Как оформить возврат</h2>

            <!-- Физ. лица -->
            <div class="rounded border p-5 mb-6">
              <div class="mb-3">
                <span
                  class="inline-flex items-center rounded px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800">Физические
                  лица</span>
              </div>
              <ol class="list-decimal pl-6 space-y-2 guide-text">
                <li>Свяжитесь с менеджером и опишите проблему, приложите фото/видео.</li>
                <li>Заполните заявление на возврат.</li>
                <li>Передайте товар на склад или отправьте согласованным способом.</li>
                <li><span class="font-medium">Возврат средств</span>: на карту/способ исходной оплаты в течение <span
                    class="font-medium">14 рабочих дней</span> после рассмотрения заявления.</li>
              </ol>
            </div>

            <!-- Юр. лица / ИП -->
            <div class="rounded border p-5">
              <div class="mb-3">
                <span
                  class="inline-flex items-center rounded px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800">Юр.
                  лица / ИП</span>
              </div>
              <ol class="list-decimal pl-6 space-y-2 guide-text">
                <li>Сообщите менеджеру о несоответствии, прикрепите акт/фото приёмки (если есть) и
                  фото/видео-подтверждение.</li>
                <li>Заполните заявление и предоставьте реквизиты для возврата (или документы для обмена).</li>
                <li>Передайте товар на склад Продавца или согласуйте возврат ТК.</li>
                <li><span class="font-medium">Возврат средств</span>: на расчётный счёт по платёжным реквизитам в течение
                  <span class="font-medium">14 рабочих дней</span> после рассмотрения заявления.</li>
              </ol>
            </div>
          </section>

          <!-- Приёмка и фиксация -->
          <section role="region" aria-labelledby="acceptance-title">
            <h2 id="acceptance-title" class="text-2xl font-semibold mb-4">Приёмка заказа</h2>
            <ul class="space-y-3 guide-text">
              <li>При получении <span class="font-medium">обязательно проверьте целостность и комплектность</span> вместе
                с курьером/водителем или сотрудником склада/ТК.</li>
              <li><span class="font-medium">Заявки на возврат</span> без фото-/видео-фиксации выявленных повреждений <span
                  class="font-medium">не рассматриваются</span>.</li>
              <li>Товар <span class="font-medium">не подлежит возврату или обмену</span> при вскрытии/повреждении
                заводской упаковки или использовании части продукции.</li>
            </ul>
          </section>

          <!-- Неподлежащие возврату -->
          <section role="region" aria-labelledby="nonreturnable-title">
            <h2 id="nonreturnable-title" class="text-2xl font-semibold mb-4">Товары, не подлежащие возврату и обмену</h2>
            <p class="guide-text mb-3">
              В соответствии с перечнем непродовольственных товаров надлежащего качества, не подлежащих возврату или
              обмену
              (Постановления Правительства РФ от 20.10.1998 № 1222, от 06.02.2002 № 81):
            </p>
            <ul class="space-y-3 guide-text">
              <li><span class="font-medium">Одноразовая посуда и пищевая упаковка</span> — изделия и материалы из
                полимеров, контактирующие с пищей (в т.ч. одноразовые).</li>
              <li>Посуда и принадлежности столовые и кухонные, ёмкости и упаковочные материалы для хранения и
                транспортирования пищевых продуктов.</li>
            </ul>
          </section>

          <!-- Ненадлежащее качество -->
          <section role="region" aria-labelledby="defect-title">
            <h2 id="defect-title" class="text-2xl font-semibold mb-4">Возврат товара ненадлежащего качества</h2>
            <ol class="list-decimal pl-6 space-y-3 guide-text">
              <li><span class="font-medium">Срок:</span> обмен/возврат возможен в течение <span class="font-medium">14
                  календарных дней</span> с момента получения заказа.</li>
              <li><span class="font-medium">Сообщите менеджеру</span> о браке/повреждениях/неполной комплектации по
                телефону или email. Приложите фото/видео-подтверждение.</li>
              <li>
                <span class="font-medium">Заполните заявление</span> на возврат.
              </li>
              <li><span class="font-medium">Передача товара:</span> сдача осуществляется на склад Продавца по адресу:<br>
                Московская область, г. Черноголовка, ул. Первый проезд, зд. 8.
                <br>Схема проезда — в разделе <a class="underline text-blue-600" href="/help/delivery">«Доставка»</a>.
              </li>
            </ol>
            <p class="guide-text mt-4">
              За повреждения товара/упаковки, возникшие в результате перевозки, транспортировки или иных действий третьих
              лиц,
              Продавец ответственности не несёт.
            </p>
          </section>

          <!-- Возврат денег: резюме -->
          <section role="region" aria-labelledby="refund-title">
            <h2 id="refund-title" class="text-2xl font-semibold mb-4">Возврат денежных средств</h2>
            <ul class="space-y-3 guide-text">
              <li>Деньги возвращаются <span class="font-medium">тем же способом, которым была произведена оплата</span>.
              </li>
              <li>Срок зачисления — <span class="font-medium">до 14 рабочих дней</span> после рассмотрения письменного
                заявления клиента.</li>
            </ul>
          </section>
        </div>
      </section>

      <!-- Контакты -->
      <section role="region" aria-labelledby="returns-questions-title" class="main-block text-center">
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
        <h2 id="returns-questions-title" class="text-2xl font-semibold">Нужна помощь с возвратом?</h2>
        <ul class="space-y-1 guide-text">
          <li>Email: <a href="mailto:workshop@mp.market" class="text-blue-600 underline">workshop@mp.market</a></li>
          <li>Телефон: 8 (800) 550-37-00</li>
        </ul>
      </section>
    </div>
  </section>


@endsection