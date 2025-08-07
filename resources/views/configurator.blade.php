@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Конфигуратор коробок</h1>

        <form id="configForm" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-semibold">Конструкция</label>
                <select name="construction" id="construction" class="border rounded w-full p-2">
                    <option value="fefco_0427">Самосборная (FEFCO 0427)</option>
                    <option value="fefco_0426">Пицца (FEFCO 0426)</option>
                    <option value="fefco_0201">Транспортировочный (FEFCO 0201)</option>
                    <option value="fefco_0300">Крышка-дно (FEFCO 0300)</option>
                </select>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block mb-1 font-semibold">Длина (мм)</label>
                    <input type="number" name="length" id="length" value="200" class="border rounded w-full p-2">
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Ширина (мм)</label>
                    <input type="number" name="width" id="width" value="150" class="border rounded w-full p-2">
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Высота (мм)</label>
                    <input type="number" name="height" id="height" value="100" class="border rounded w-full p-2">
                </div>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Цвет картона</label>
                <select name="color" id="color" class="border rounded w-full p-2">
                    <option value="brown">Бурый</option>
                    <option value="white_in">Белый/Бурый</option>
                    <option value="white">Белый</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Тираж</label>
                <input type="number" name="tirage" id="tirage" value="100" class="border rounded w-full p-2">
            </div>
            <!-- Чёрный логотип -->
            <div class="border-t pt-4 mt-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="has_logo">
                    <span class="font-semibold">Нанести чёрный логотип (+10 ₽ к каждой коробке)</span>
                </label>

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
            <div class="border-t pt-4 mt-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" id="has_fullprint">
                    <span class="font-semibold">Полноформатная печать (1–5 цветов)</span>
                </label>

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

        <div id="result" class="mt-6 p-4 border rounded bg-gray-50">
            <p><strong>Цена за штуку:</strong> <span id="price_per_unit">—</span> ₽</p>
            <p><strong>Общая цена:</strong> <span id="total_price">—</span> ₽</p>
            <p><strong>Вес:</strong> <span id="weight">—</span> кг</p>
            <p><strong>Объём:</strong> <span id="volume">—</span> м³</p>
        </div>

        <button id="add_to_cart" class="mt-4 px-4 py-2 bg-green-600 text-white rounded">
            Добавить в корзину
        </button>
    </div>
@endsection