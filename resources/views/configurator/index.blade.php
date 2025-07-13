@extends('layouts.app')

@section('content')
@include('partials.mainpagehero')
@include('partials.3cards')
<div class="card-container card-container-grid">
    <div>
        <form id="configurator-form">
            @csrf
            
            {{-- <div>
                <label>Тип коробки:</label>
                <select name="box_type_id">
                    @foreach ($boxTypes as $boxType)
                        <option value="{{ $boxType->id }}">{{ $boxType->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="box-type-options">
                @foreach ($boxTypes as $boxType)
                    <input type="radio" name="box_type_id" value="{{ $boxType->id }}" id="box_type_{{ $boxType->id }}" hidden>
                    <label for="box_type_{{ $boxType->id }}" class="box-type-card">
                        {{ $boxType->name }}
                    </label>
                @endforeach
            </div>

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
                <label>Тираж:</label>
                <select name="quantity">
                    {{-- @foreach ([10, 25, 50, 100, 200, 300, 500, 1000, 2000] as $qty)
                        <option value="{{ $qty }}">{{ $qty }} шт.</option>
                    @endforeach --}}
                    <option value="10">10 шт</option>
                    <option value="25">25 шт -3%</option>
                    <option value="100">100 шт -5%</option>
                    <option value="200">200 шт -10%</option>
                    <option value="300">300 шт -15%</option>
                    <option value="500">500 шт -20%</option>
                    <option value="1000">1000 шт -25%</option>
                    <option value="2000">2000 шт -30%</option>
                </select>
            </div>
    
            <div id="design-options" style="display: none; margin-top: 20px;">
    
                <h3>Оформление коробки</h3>
            
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
        
        </form>
    </div>
    <div>
        <div id="result" style="margin-top: 20px;">
            <p>Цена за коробку: 0 ₽</p>
            <p>Общая стоимость: 0 ₽</p>
            <p>Вес: 0 кг</p>
            <p>Объём: 0 м³</p>
        </div>
        <button id="checkout-button" type="button">Оформить заказ</button>
    </div>
</div>


@include('partials.pricemap')
@include('partials.reviews')

@endsection
