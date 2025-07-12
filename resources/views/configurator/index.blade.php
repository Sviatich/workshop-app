@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Конфигуратор коробок</h1>

    <form id="configurator-form">
        @csrf

        <div>
            <label>Размеры (мм)</label><br>
            <input type="number" name="length" placeholder="Длина">
            <input type="number" name="width" placeholder="Ширина">
            <input type="number" name="height" placeholder="Высота">
        </div>

        <div>
            <label>Тип картона:</label>
            <select name="thickness">
                <option value="1.5">1.5 мм</option>
                <option value="3">3 мм</option>
            </select>
        </div>

        <div>
            <label>Цвет:</label>
            <select name="color">
                <option value="brown">Бурый</option>
                <option value="white">Белый</option>
            </select>
        </div>

        <div>
            <label>Прочность:</label>
            <select name="strength">
                <option value="econom">Эконом</option>
                <option value="business">Бизнес</option>
            </select>
        </div>

        <div>
            <label>Тип коробки:</label>
            <select name="box_type_id">
                @foreach ($boxTypes as $boxType)
                    <option value="{{ $boxType->id }}">{{ $boxType->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Тираж:</label>
            <select name="quantity">
                @foreach ([10, 25, 50, 100, 200, 300, 500, 1000, 2000] as $qty)
                    <option value="{{ $qty }}">{{ $qty }} шт.</option>
                @endforeach
            </select>
        </div>

        <div id="design-options" style="display: none; margin-top: 20px;">

            <h3>Оформление упаковки</h3>
        
            <div>
                <label>Тип оформления:</label><br>
                <label><input type="radio" name="print_type" value="print"> Печать</label>
                <label><input type="radio" name="print_type" value="sticker"> Наклейка</label>
                <label><input type="radio" name="print_type" value="wrapper"> Обечайка</label>
                <label><input type="radio" name="print_type" value="none" checked> Без оформления</label>
            </div>
        
            <div id="print-size-block" style="margin-top: 10px; display: none;">
                <label>Размер печати / наклейки:</label>
                <select name="print_size">
                    <option value="small">Малая</option>
                    <option value="medium">Средняя</option>
                    <option value="large">Большая</option>
                </select>
            </div>
        
            <div style="margin-top: 10px;">
                <label><input type="checkbox" name="need_logo_design" value="1"> Нужна разработка логотипа (+2000 ₽)</label>
            </div>
        
            <div style="margin-top: 10px;">
                <label>Файл дизайна:</label>
                <input type="file" name="design_file">
            </div>
        
        </div>
        

        <button type="button" id="calculate-button">Рассчитать</button>
    </form>

    <div id="result" style="margin-top: 20px;"></div>
</div>

<button id="checkout-button" type="button">Оформить заказ</button>

@endsection
