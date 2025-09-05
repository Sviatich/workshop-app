@extends('layouts.app')

@section('title', 'Реквизиты — Мастерская Упаковки')
@section('meta_description', 'Реквизиты компании: ИНН, КПП, ОГРН, расчетный счёт, банк, адрес.')

@section('content')
<section class="main-block">
    <h1 class="h2 font-bold mb-4">Реквизиты</h1>

    <div class="space-y-3 text-gray-800">
        <p><strong>Наименование:</strong> ООО «Новая Упаковочная Компания»</p>
        <p><strong>ИНН / КПП:</strong> 7709903904 / 503101001</p>
        <p><strong>ОГРН:</strong> 1127746383170</p>
        <p><strong>Юридический адрес:</strong> 142432, Московская область, г Черноголовка, проезд 1-Й, зд. 8, помещ. 1 </p>

        <p class="mt-4"><strong>Банк:</strong> ПАО Сбербанк</p>
        <p><strong>Расчётный счёт:</strong> 40702810440000024410</p>
        <p><strong>Корреспондентский счёт:</strong> 30101810400000000225</p>
        <p><strong>БИК:</strong> 044525225</p>

        <p><strong>Электронная почта:</strong> <a href="mailto:office@mp.market" class="text-blue-600 underline">office@mp.market</a></p>
        <p><strong>Телефон:</strong> <a href="tel:88005503700" class="text-blue-600 underline">8 (800) 550-37-00</a></p>
    </div>
</section>
@endsection

