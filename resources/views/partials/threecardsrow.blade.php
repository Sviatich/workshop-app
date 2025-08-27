<section class="main-container main-3cards-block">
    <div class="grid md:grid-cols-3 gap-6">

        {{-- Карточка 1 --}}
        <div class="main-3cards-block__card">
            <img src="{{ Vite::asset('resources/images/card1.webp') }}" alt="Описание 1"
                class="w-full h-48 object-cover">
            <div class="main-3cards-block__card_title-zone">
                <h3 class="main-3cards-block__card_title">Любой размер</h3>
                <p class="main-3cards-block__card_text">Изготовим любой необходимый вам размер</p>
            </div>
        </div>

        {{-- Карточка 2 --}}
        <div class="main-3cards-block__card">
            <img src="{{ Vite::asset('resources/images/card2.jpg') }}" alt="Описание 2"
                class="w-full h-48 object-cover">
            <div class="main-3cards-block__card_title-zone">
                <h3 class="main-3cards-block__card_title">Нанесение логотипа</h3>
                <p class="main-3cards-block__card_text">Разработаем и нанесем печать на вашу упаковку</p>
            </div>
        </div>

        {{-- Карточка 3 --}}
        <div class="main-3cards-block__card">
            <img src="{{ Vite::asset('resources/images/card3.jpg') }}" alt="Описание 3"
                class="w-full h-48 object-cover">
            <div class="main-3cards-block__card_title-zone">
                <h3 class="main-3cards-block__card_title">Доставка по РФ</h3>
                <p class="main-3cards-block__card_text">Быстрая доставка упаковки по всей России</p>
            </div>
        </div>

    </div>
</section>