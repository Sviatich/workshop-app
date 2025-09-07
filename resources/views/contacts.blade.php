@extends('layouts.app')

@section('title', 'Контакты — ' . config('app.name'))
@section('meta_description', 'Контактная информация, адрес и способы связи.')

@section('content')
<section class="main-block">
  <div class="mx-auto max-w-5xl">
    <header class="mb-6">
      <h1 class="h2 mb-4">Контакты</h1>
    </header>

    {{-- Узкая карта-строка --}}
    <div class="overflow-hidden rounded border border-gray-200 bg-white">
      <div class="h-36 w-full sm:h-40 lg:h-44">
        {{-- Замените src на ваш конструктор Яндекс.Карт / точный адрес --}}
        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aba5f69d653061d2b6ce50d8acd0ae134398483fb7983687f4b37166338708565&amp;source=constructor" width="100%" height="240" frameborder="0"></iframe>
      </div>
    </div>

    {{-- Карточка контактов на всю ширину --}}
    <div class="mt-6 rounded border border-gray-200 bg-white p-5 md:p-6">
      <div class="grid gap-6 md:grid-cols-2">
        {{-- Блок телефонов и адреса --}}
        <div class="space-y-5 text-gray-800">
          <div class="flex items-start gap-3">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M2 5c0-1.1.9-2 2-2h2.3c.8 0 1.5.5 1.8 1.2l1 2.3c.3.8.1 1.7-.5 2.3l-1.2 1.2a16 16 0 0 0 6.4 6.4l1.2-1.2c.6-.6 1.5-.8 2.3-.5l2.3 1c.7.3 1.2 1 1.2 1.8V20c0 1.1-.9 2-2 2h-1C9.9 22 2 14.1 2 5Z" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <div>
              <div class="text-sm text-gray-500">Телефон</div>
              <a href="tel:88005503700" class="font-medium hover:underline">8 (800) 550-37-00</a>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M12 22s7-5.1 7-11.1A7 7 0 0 0 5 10.9C5 16.9 12 22 12 22Z" stroke="currentColor" stroke-width="1.5"/>
              <circle cx="12" cy="10.9" r="2.5" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <div>
              <div class="text-sm text-gray-500">Адрес</div>
              <p class="font-medium">г. Черноголовка, ул. Первый проезд, зд. 8, помещ. 1</p>
              <a href="https://yandex.ru/maps/-/CLQDVEMv" class="text-sm text-blue-600 underline underline-offset-2">Открыть на карте</a>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
              <path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <div>
              <div class="text-sm text-gray-500">Режим работы</div>
              <p class="font-medium">Пн–Пт: 08:00–17:00</p>
              <p class="text-gray-600">Сб–Вс: выходной</p>
            </div>
          </div>

          <div class="border-t border-gray-100 pt-4">
            <p class="text-sm text-gray-500">Мы в мессенджерах</p>
            <div class="mt-2 flex flex-wrap gap-2">
              <a href="https://t.me/mister_packers_bot" class="inline-flex items-center rounded border border-gray-200 px-3 py-1 text-sm hover:bg-gray-50">Telegram</a>
              <a href="https://wa.me/+79154282254" class="inline-flex items-center rounded border border-gray-200 px-3 py-1 text-sm hover:bg-gray-50">WhatsApp</a>
            </div>
          </div>
        </div>

        {{-- Блок почт (главная + отделы) --}}
        <div>
          <ul class="mt-3 space-y-4 text-gray-800">
            <li class="flex items-start gap-3">
              <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4h13A2.5 2.5 0 0 1 21 6.5v11A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5v-11Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.5"/>
              </svg>
              <div>
                <div class="text-sm text-gray-500">Общая</div>
                <a href="mailto:workshop@mp.market" class="font-medium hover:underline">workshop@mp.market
                </a>
              </div>
            </li>

            <li class="flex items-start gap-3">
              <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4h13A2.5 2.5 0 0 1 21 6.5v11A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5v-11Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.5"/>
              </svg>
              <div>
                <div class="text-sm text-gray-500">Отдел продаж</div>
                <a href="mailto:info@mp.market" class="font-medium hover:underline">
                  info@mp.market
                </a>
              </div>
            </li>

            <li class="flex items-start gap-3">
              <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M3 6.5A2.5 2.5 0 0 1 5.5 4h13A2.5 2.5 0 0 1 21 6.5v11A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5v-11Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.5"/>
              </svg>
              <div>
                <div class="text-sm text-gray-500">Руководство</div>
                <a href="mailto:office@mp.market" class="font-medium hover:underline">
                  office@mp.market
                </a>
              </div>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

