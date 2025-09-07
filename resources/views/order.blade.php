@extends('layouts.app')

@section('title', 'Страница заказа — Мастерская Упаковки')
@section('meta_description', 'Информация по вашему заказу: состав, стоимость и статус.')

@section('content')
    <div class="main-block order-block">
        <div class="flex justify-center mb-6 mt-6">
            <svg width="70px" fill="#2a6dcf" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><path d="M12,0A12,12,0,1,0,24,12,12,12,0,0,0,12,0ZM11.52,17L6,12.79l1.83-2.37L11.14,13l4.51-5.08,2.24,2Z"></path></g></svg>
        </div>
        <h1 class="text-2xl font-bold mb-4 text-center">Заказ успешно оформлен</h1>

        <div>
            <p class="text-center text p-2 mb-4">Наш менеджер свяжется с вами в ближайшее время и уточнит детали заказа. После этого вы сможете оплатить заказ и мы поставим его в производство.</p>
            </div>
            <p class="configurator-warning mb-6">
            Ссылка на заказ будет доступна в течение 30 дней.
        </p>
        <div class="rounded border p-4 mb-6">
            <div class="flex justify-between mb-2 border-b"><p>Статус заказа: </p><p class="text-right">{{ $order->public_status ?? 'В обработке' }}</p></div>
            <div class="flex justify-between mb-2 border-b"><p>Дата оформления: </p><p class="text-right">{{ $order->created_at->format('d.m.Y') }}</p></div>
            <div class="flex justify-between mb-2 border-b"><p>Сумма заказа: </p><p class="text-right">{{ number_format($order->total_price, 2, '.', ' ') }} ₽ </p></div>
            <div class="flex justify-between"><p>Номер заказа: </p><a class="text-right btn-hover-effect" href="" onclick="event.preventDefault(); navigator.clipboard.writeText(this.href);window.toast.success('Ссылка скопирована');"><u><svg class="inline mr-1" width="17px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g><path d="M9.16488 17.6505C8.92513 17.8743 8.73958 18.0241 8.54996 18.1336C7.62175 18.6695 6.47816 18.6695 5.54996 18.1336C5.20791 17.9361 4.87912 17.6073 4.22153 16.9498C3.56394 16.2922 3.23514 15.9634 3.03767 15.6213C2.50177 14.6931 2.50177 13.5495 3.03767 12.6213C3.23514 12.2793 3.56394 11.9505 4.22153 11.2929L7.04996 8.46448C7.70755 7.80689 8.03634 7.47809 8.37838 7.28062C9.30659 6.74472 10.4502 6.74472 11.3784 7.28061C11.7204 7.47809 12.0492 7.80689 12.7068 8.46448C13.3644 9.12207 13.6932 9.45086 13.8907 9.7929C14.4266 10.7211 14.4266 11.8647 13.8907 12.7929C13.7812 12.9825 13.6314 13.1681 13.4075 13.4078M10.5919 10.5922C10.368 10.8319 10.2182 11.0175 10.1087 11.2071C9.57284 12.1353 9.57284 13.2789 10.1087 14.2071C10.3062 14.5492 10.635 14.878 11.2926 15.5355C11.9502 16.1931 12.279 16.5219 12.621 16.7194C13.5492 17.2553 14.6928 17.2553 15.621 16.7194C15.9631 16.5219 16.2919 16.1931 16.9495 15.5355L19.7779 12.7071C20.4355 12.0495 20.7643 11.7207 20.9617 11.3787C21.4976 10.4505 21.4976 9.30689 20.9617 8.37869C20.7643 8.03665 20.4355 7.70785 19.7779 7.05026C19.1203 6.39267 18.7915 6.06388 18.4495 5.8664C17.5212 5.3305 16.3777 5.3305 15.4495 5.8664C15.2598 5.97588 15.0743 6.12571 14.8345 6.34955" stroke="#555" stroke-width="1.5" stroke-linecap="round"></path></g></svg>{{ $order->uuid }}</u></a></div>
        </div>

        <ul class="space-y-4">
            @foreach($order->items as $item)
                @php
                    $img = $item->config_json['construction_img'] ?? $item->config_json['color_img'] ?? null;
                @endphp
                <li class="p-4 border rounded bg-white relative">
                    <div class="flex gap-4 items-start">
                        <div class="flex-1">
                            <p class="font-semibold mb-1">
                                {{ $item->config_json['construction_name'] ?? $item->config_json['construction'] }}<br>
                                <span class="cart-item-badge gray-999 font-normal">
                                    {{ $item->config_json['length'] }} ×
                                    {{ $item->config_json['width'] }} ×
                                    {{ $item->config_json['height'] }} мм
                                </span>
                            </p>

                            <div class="grid gap-2 md:grid-cols-2 mt-2">
                                <p class="cart-item-badge"><span class="gray-999">Цвет: </span>{{ $item->config_json['color_name'] ?? $item->config_json['color'] }}</p>
                                <p class="cart-item-badge"><span class="gray-999">Тираж: </span>{{ $item->config_json['tirage'] }}</p>
                            </div>

                            <div class="grid gap-2 md:grid-cols-2 mt-2">
                                <p class="cart-item-badge"><span class="gray-999">Цена за изделие: </span>{{ number_format($item->price_per_unit, 2, '.', ' ') }} ₽</p>
                                <p class="cart-item-badge"><span class="gray-999">Итого: </span>{{ number_format($item->total_price, 2, '.', ' ') }} ₽</p>
                            </div>

                            @if (!empty($item->config_json['fullprint']['enabled']) && $item->total_price == 0)
                                <p class="configurator-warning mt-3">
                                    Стоимость с полноцветной печатью рассчитывается индивидуально менеджером.
                                </p>
                            @endif

                            {{-- Логотип --}}
                            @if (!empty($item->config_json['logo']['enabled']))
                                <div class="mt-2 cart-item-badge">
                                    <strong>Логотип:</strong> есть
                                    (Размер: {{ $item->config_json['logo']['size'] ?? 'не указан' }})
                                    @if (!empty($item->config_json['logo']['filename']))
                                        <span class="text-sm text-gray-600"> — {{ $item->config_json['logo']['filename'] }}</span>
                                    @endif
                                </div>
                            @endif

                            {{-- Полноцветный макет --}}
                            @if (!empty($item->config_json['fullprint']['enabled']))
                                <div class="mt-2 cart-item-badge">
                                    <strong>Полноцветный макет:</strong> есть
                                    @if (!empty($item->config_json['fullprint']['description']))
                                        <p class="text-sm text-gray-700">
                                            Описание: {{ $item->config_json['fullprint']['description'] }}
                                        </p>
                                    @endif
                                    @if (!empty($item->config_json['fullprint']['file']))
                                        <p class="text-sm text-gray-600">Файл: {{ $item->config_json['fullprint']['file'] }}</p>
                                    @endif
                                </div>
                            @endif

                            {{-- Прикрепленные файлы --}}
                            @if ($item->files->count())
                                <ul class="mt-3 text-sm text-blue-600 underline">
                                    @foreach ($item->files as $file)
                                        <li>
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                {{ $file->file_type === 'logo' ? 'Файл логотипа' : 'Файл печати' }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="mt-4 flex justify-center">
            <a class="rounded text-center p-4 order-button text-white btn-hover-effect cursor-pointer w-full" href="/">Вернуться на главную</a>
        </div>
    </div>
@endsection
