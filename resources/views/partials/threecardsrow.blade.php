<section class="main-container main-3cards-block">
    <div class="grid md:grid-cols-3 gap-6">

        {{-- Карточка 1 --}}
        <div class="main-3cards-block__card">
            <img src="{{ Vite::asset('resources/images/card1.jpg') }}" alt="Описание 1"
                class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-medium">Индивидуальный размер</h3>
                <p class="">Изготовим различные размеры и формы под вашу продукцию</p>
            </div>
        </div>

        {{-- Карточка 2 --}}
        <div class="main-3cards-block__card">
            <img src="{{ Vite::asset('resources/images/card2.jpg') }}" alt="Описание 2"
                class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-medium">Нанесение логотипа</h3>
                <p class="">Услуги по нанесению печати на коробки из картона</p>
            </div>
        </div>

        {{-- Карточка 3 --}}
        <div class="main-3cards-block__card">
            <img src="{{ Vite::asset('resources/images/card3.jpg') }}" alt="Описание 3"
                class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-medium">Быстрая доставка</h3>
                <p class="">Доставляем нашу продукцию по всей России</p>
            </div>
        </div>

    </div>
</section>