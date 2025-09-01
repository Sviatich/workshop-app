@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Заказ №{{ $order->id }}</h1>

        <p><strong>Статус:</strong> {{ $order->status }}</p>
        <p><strong>Тип плательщика:</strong>
            {{ $order->payer_type === 'individual' ? 'Физическое лицо' : 'Юридическое лицо / ИП' }}
        </p>
        <p><strong>ИНН:</strong> {{ $order->inn }}</p>
        <p><strong>ФИО:</strong> {{ $order->full_name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Телефон:</strong> {{ $order->phone }}</p>
        <p><strong>Адрес доставки:</strong> {{ $order->delivery_address }}</p>

        <h2 class="text-xl font-bold mt-4 mb-2">Товары:</h2>

        <ul class="space-y-4">
            @foreach($order->items as $item)
                <li class="border p-4 rounded bg-white">
                    <p class="font-semibold mb-1">
                        {{ $item->config_json['construction_name'] ?? $item->config_json['construction'] }}
                        —
                        {{ $item->config_json['length'] }} ×
                        {{ $item->config_json['width'] }} ×
                        {{ $item->config_json['height'] }} мм,
                        Цвет: {{ $item->config_json['color_name'] ?? $item->config_json['color'] }},
                        тираж {{ $item->config_json['tirage'] }}
                    </p>

                    <p class="text-sm text-gray-700">
                        Цена за единицу: {{ number_format($item->price_per_unit, 2, '.', ' ') }} ₽<br>
                        Итого: {{ number_format($item->total_price, 2, '.', ' ') }} ₽
                    </p>

                    @if (!empty($item->config_json['fullprint']['enabled']) && $item->total_price == 0)
                        <p class="text-orange-600 font-semibold text-sm mt-1">
                            Цена будет рассчитана менеджером индивидуально после оформления заказа.
                        </p>
                    @endif

                    {{-- Опции логотипа --}}
                    @if (!empty($item->config_json['logo']['enabled']))
                        <div class="mt-2">
                            <strong>Логотип:</strong> да
                            (размер: {{ $item->config_json['logo']['size'] ?? 'не указан' }})
                            @if (!empty($item->config_json['logo']['filename']))
                                <span class="text-sm text-gray-600"> — {{ $item->config_json['logo']['filename'] }}</span>
                            @endif
                        </div>
                    @endif

                    {{-- Опции полноформатной печати --}}
                    @if (!empty($item->config_json['fullprint']['enabled']))
                        <div class="mt-2">
                            <strong>Полноформатная печать:</strong> да
                            @if (!empty($item->config_json['fullprint']['description']))
                                <p class="text-sm text-gray-700">
                                    Комментарий: {{ $item->config_json['fullprint']['description'] }}
                                </p>
                            @endif
                            @if (!empty($item->config_json['fullprint']['file']))
                                <p class="text-sm text-gray-600">Файл: {{ $item->config_json['fullprint']['file'] }}</p>
                            @endif
                        </div>
                    @endif

                    {{-- Загруженные файлы --}}
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
                </li>
            @endforeach
        </ul>
    </div>
@endsection