@extends('layouts.app')

@section('content')
    @include('partials.hero')
    @include('partials.threecardsrow')
    <div class="main-block">
        <h2 class="mb-4">Конфигуратор упаковки</h2>
        <div class="flex">
            <form id="configForm" class="space-y-4 configurator-left">
                @csrf

                <div>
                    <label class="hidden-element">Конструкция</label>

                    {{-- Твой исходный select остаётся! --}}
                    <select name="construction" id="construction" class="border rounded w-full p-2 select-fixed">
                        <option value="fefco_0427"
                            data-img="{{ Vite::asset('resources/images/constructions/fefco_0427.webp') }}"
                            data-anim="{{ Vite::asset('resources/videos/fefco_0427.webm') }}">
                            Самосборная коробка
                        </option>
                        <option value="fefco_0426"
                            data-img="{{ Vite::asset('resources/images/constructions/fefco_0426.webp') }}"
                            data-anim="{{ Vite::asset('resources/videos/fefco_0426.webm') }}">
                            Коробка для пиццы
                        </option>
                        <option value="fefco_0201"
                            data-img="{{ Vite::asset('resources/images/constructions/fefco_0201.webp') }}"
                            data-anim="{{ Vite::asset('resources/videos/fefco_0201.webm') }}">
                            Обычный гофрокороб
                        </option>
                        <option value="fefco_0215"
                            data-img="{{ Vite::asset('resources/images/constructions/fefco_0215.webp') }}"
                            data-anim="{{ Vite::asset('resources/videos/fefco_0215.webm') }}">
                            Ласточкин хвост
                        </option>
                    </select>

                    {{-- Контейнер для карточек поверх селекта --}}
                    <div id="construction_cards" class="construction-grid"></div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">Длина (мм)</label>
                        <input type="number" name="length" id="length" value="" min="15" class="border rounded w-full p-2"
                            placeholder="200">
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Ширина (мм)</label>
                        <input type="number" name="width" id="width" value="" min="15" class="border rounded w-full p-2"
                            placeholder="150">
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Высота (мм)</label>
                        <input type="number" name="height" id="height" value="" min="15" class="border rounded w-full p-2"
                            placeholder="100">
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Цвет картона</label>

                    {{-- Селект остаётся --}}
                    <select name=" color" id="color" class="border rounded w-full p-2 select-fixed">
                        <option value=" brown" data-img="{{ Vite::asset('resources/images/colors/brown.jpg') }}">
                            Бур/Бур
                        </option>
                        <option value="white_in" data-img="{{ Vite::asset('resources/images/colors/white_in.jpg') }}">
                            Бел/Бур
                        </option>
                        <option value="white" data-img="{{ Vite::asset('resources/images/colors/white.jpg') }}">
                            Бел/Бел
                        </option>
                    </select>

                    {{-- Контейнер для карточек --}}
                    <div id="color_cards" class="mt-3 color-card-grid"></div>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Тираж</label>
                    <select id="tirage" name="tirage" class="styled-select">
                        <option value="25">25 штук</option>
                        <option value="50">50 штук</option>
                        <option value="100">100 штук</option>
                        <option value="150">150 штук</option>
                        <option value="200">200 штук</option>
                        <option value="250">250 штук</option>
                        <option value="300">300 штук</option>
                        <option value="350">350 штук</option>
                        <option value="400">400 штук</option>
                        <option value="450">450 штук</option>
                        <option value="500">500 штук</option>
                        <option value="1000">1000 штук</option>
                    </select>
                </div>

                <div id="nearest_sizes_block"></div>

                <div class="additional_service">
                    <p class="additional_service_text">дополнительные опции</p>
                </div>

                <!-- Чёрный логотип -->
                <div class="pt-4 mt-4">
                    <div class="switch-block">
                        <div style="width: 75%;">
                            <label for="has_logo" class="cursor-pointer font-semibold">Нанести логотип</label>
                            <p class="text-sm text-gray-600">Логотип будет нанесён в одном цвете на выбранный материал</p>
                        </div>
                        <input type="checkbox" id="has_logo" class="switch">
                    </div>

                    <div id="logo_options" class="mt-2 hidden space-y-2">
                        <div>
                            <label class="block font-semibold mb-1">Размер логотипа</label>
                            <select id="logo_size" class="border rounded w-full p-2">
                                <option value="20x40">20 мм × 40 мм</option>
                                <option value="10x40">10 мм × 40 мм</option>
                                <option value="26x40">26 мм × 40 мм</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Файл логотипа</label>
                            <input type="file" name="logo_file_0" id="logo_file" class="border rounded w-full p-2">
                            <div id="logo_status" class="text-sm text-gray-600 mt-1"></div>
                            <img id="logo_preview" src="" alt="" class="mt-2 max-w-[150px] hidden">
                        </div>
                    </div>
                </div>

                <!-- Полноформатная печать -->
                <div class="border-t border-b pt-4 mt-4 pb-4">
                    <div class="switch-block">
                        <div style="width: 75%;">
                            <label for="has_fullprint" class="cursor-pointer font-semibold">Полноцветная печать</label>
                            <p class="text-sm text-gray-600">Печать от 1 до 5 цветов на всей площади короба</p>
                        </div>
                        <input type="checkbox" id="has_fullprint" class="switch">
                    </div>

                    <div id="fullprint_options" class="mt-2 hidden space-y-2">
                        <div>
                            <label class="block font-semibold mb-1">Файл макета</label>
                            <input type="file" name="print_file_0" id="print_file" class="border rounded w-full p-2">
                            <div id="print_status" class="text-sm text-gray-600 mt-1"></div>
                            <img id="print_preview" src="" alt="" class="mt-2 max-w-[150px] hidden">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Комментарий к печати</label>
                            <textarea id="print_description" class="border rounded w-full p-2"
                                placeholder="Если макета нет — опишите, что нужно напечатать"></textarea>
                        </div>
                    </div>
                </div>

            </form>

            <div id="result" class="configurator-right">
                <table class="w-full text-left border-collapse">
                    <tbody>
                        <tr>
                            <th class="pr-4 font-semibold">Цена за 1 шт:</th>
                            <td class="text-right"><span id="price_per_unit">—</span> ₽</td>
                        </tr>
                        <tr class="result-main-other">
                            <th class="pr-4 font-normal">Общая цена:</th>
                            <td class="text-right"><span id="total_price">—</span> ₽</td>
                        </tr>
                        <tr class="result-main-other">
                            <th class="pr-4 font-normal">Вес:</th>
                            <td class="text-right"><span id="weight">—</span> кг</td>
                        </tr>
                        <tr class="result-main-other">
                            <th class="pr-4 font-normal">Объём:</th>
                            <td class="text-right"><span id="volume">—</span> м³</td>
                        </tr>
                    </tbody>
                </table>

                <button id="add_to_cart" class="add-to-cart-button mt-4">Добавить в корзину</button>
                <p class="form-copiration-text text-sm mt-2">
                    Нажимая эту кнопку вы соглашаетесь с нашей
                    <a href="/"><u>политикой обработки персональных данных</u></a>
                </p>
            </div>
        </div>
    </div>
    @include('partials.ineeddesign')
    @include('partials.maingalery')
    @include('partials.review')
    @include('partials.deliverymap')
    @include('partials.faq')
@endsection