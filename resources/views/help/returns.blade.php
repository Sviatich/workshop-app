@extends('layouts.app')

@section('title', 'Возврат товара — Мастерская Упаковки')
@section('meta_description', 'Условия обмена и возврата продукции.')

@section('content')
  <section aria-labelledby="returns-page-title">
    <div class="main-block mb-10 guide-header">
      @include('partials.breadcrumbs', ['items' => [
        ['label' => 'Главная', 'url' => route('home')],
        ['label' => 'Справка', 'url' => route('help.index')],
        ['label' => 'Возврат']
      ]])
      <h1 id="returns-page-title" class="main-h1">Возврат товара</h1>
    </div>
    <section class="main-block space-y-12">
      <div class="space-y-12">
        <section role="region" aria-labelledby="who-returns-title">
          <h2 id="who-returns-title" class="text-2xl font-semibold mb-4">Как оформить возврат</h2>
          <div class="rounded border p-5 mb-6">
            <div class="mb-3">
              <span
                class="inline-flex items-center rounded px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800">Физические
                лица</span>
            </div>
            <ol class="list-decimal pl-6 space-y-2">
              <li>Свяжитесь с менеджером и опишите проблему, приложите фото/видео.</li>
              <li>Заполните заявление на возврат.</li>
              <li>Передайте товар на склад или отправьте согласованным способом.</li>
              <li><span class="font-medium">Возврат средств</span>: на карту/способ исходной оплаты в течение <span
                  class="font-medium">14 рабочих дней</span> после рассмотрения заявления.</li>
            </ol>
          </div>
          <div class="rounded border p-5">
            <div class="mb-3">
              <span
                class="inline-flex items-center rounded px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800">Юр.
                лица / ИП</span>
            </div>
            <ol class="list-decimal pl-6 space-y-2">
              <li>Сообщите менеджеру о несоответствии, прикрепите акт/фото приёмки (если есть) и
                фото/видео-подтверждение.</li>
              <li>Заполните заявление и предоставьте реквизиты для возврата (или документы для обмена).</li>
              <li>Передайте товар на склад Продавца или согласуйте возврат ТК.</li>
              <li><span class="font-medium">Возврат средств</span>: на расчётный счёт по платёжным реквизитам в течение
                <span class="font-medium">14 рабочих дней</span> после рассмотрения заявления.
              </li>
            </ol>
          </div>
        </section>
        <section role="region" aria-labelledby="acceptance-title">
          <h2 id="acceptance-title" class="text-2xl font-semibold mb-4">Приёмка заказа</h2>
          <ul class="space-y-3">
            <li>При получении <span class="font-medium">обязательно проверьте целостность и комплектность</span> вместе
              с курьером/водителем или сотрудником склада/ТК.</li>
            <li><span class="font-medium">Заявки на возврат</span> без фото-/видео-фиксации выявленных повреждений <span
                class="font-medium">не рассматриваются</span>.</li>
            <li>Товар <span class="font-medium">не подлежит возврату или обмену</span> при вскрытии/повреждении
              заводской упаковки или использовании части продукции.</li>
          </ul>
        </section>
        <section role="region" aria-labelledby="nonreturnable-title">
          <h2 id="nonreturnable-title" class="text-2xl font-semibold mb-4">Товары, не подлежащие возврату и обмену</h2>
          <p class="mb-3">
            В соответствии с перечнем непродовольственных товаров надлежащего качества, не подлежащих возврату или
            обмену
            (Постановления Правительства РФ от 20.10.1998 № 1222, от 06.02.2002 № 81):
          </p>
          <ul class="space-y-3">
            <li><span class="font-medium">Одноразовая посуда и пищевая упаковка</span> — изделия и материалы из
              полимеров, контактирующие с пищей (в т.ч. одноразовые).</li>
            <li>Посуда и принадлежности столовые и кухонные, ёмкости и упаковочные материалы для хранения и
              транспортирования пищевых продуктов.</li>
          </ul>
        </section>
        <section role="region" aria-labelledby="defect-title">
          <h2 id="defect-title" class="text-2xl font-semibold mb-4">Возврат товара ненадлежащего качества</h2>
          <ol class="list-decimal pl-6 space-y-3">
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
          <p class="mt-4">
            За повреждения товара/упаковки, возникшие в результате перевозки, транспортировки или иных действий третьих
            лиц,
            Продавец ответственности не несёт.
          </p>
        </section>
        <section role="region" aria-labelledby="refund-title">
          <h2 id="refund-title" class="text-2xl font-semibold mb-4">Возврат денежных средств</h2>
          <ul class="space-y-3">
            <li>Деньги возвращаются <span class="font-medium">тем же способом, которым была произведена оплата</span>.
            </li>
            <li>Срок зачисления — <span class="font-medium">до 14 рабочих дней</span> после рассмотрения письменного
              заявления клиента.</li>
          </ul>
        </section>
      </div>
    </section>
  </section>
  <section role="region" aria-labelledby="returns-questions-title" class="main-block text-center">
    <h2 id="returns-questions-title" class="guide-h2-margin text-2xl font-semibold">Получили некачественный товар?</h2>
    <p>Наши менеджеры всегда готовы помочь</p>
    <div class="mt-4">
      <x-contact-form-button button-text="Сообщить о браке" title="Возврат товара" select-label="Тема обращения"
        :select-options="['Товар плохого качества', 'Товар поврежден']" />
    </div>
  </section>
@endsection
