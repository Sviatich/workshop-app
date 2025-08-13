<section class="py-12 bg-white main-block" aria-labelledby="testimonials-title">
  <div class="container mx-auto">
    <h2 id="testimonials-title" class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
      Что говорят клиенты
    </h2>

    {{-- Маркировка как «ленту» с ролью list, карточки — listitem --}}
    <div class="marquee mask-fade" role="region" aria-label="Отзывы клиентов, автопрокрутка справа налево">
      <ul class="marquee__track" role="list">
        {{-- Группа #1 --}}
        <li class="marquee__group" aria-hidden="false">
          {{-- Карточка --}}
          <article class="tcard" role="listitem" aria-label="Алексей, владелец магазина">
            <div class="tcard__quote">«Сервис помог запустить продажи за неделю. Упаковка — топ!»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/alexei.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Алексей</div>
                <div class="tcard__role">Владелец магазина</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Мария, маркетолог">
            <div class="tcard__quote">«Быстрый расчёт, аккуратная печать. Менеджер всегда на связи.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/maria.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Мария</div>
                <div class="tcard__role">Маркетолог</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Игорь, кофе-бренд">
            <div class="tcard__quote">«Коробки под размер стаканов — идеальная посадка, без люфта.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/igor.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Игорь</div>
                <div class="tcard__role">Основатель кофе‑бренда</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Анна, Etsy-продавец">
            <div class="tcard__quote">«Малые тиражи и печать логотипа спасли мой запуск на маркетплейсе.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/anna.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Анна</div>
                <div class="tcard__role">Продавец на Etsy</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Сергей, логистика">
            <div class="tcard__quote">«Транспортные коробки крепкие, выдержали дальние поездки без брака.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/sergey.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Сергей</div>
                <div class="tcard__role">Руководитель логистики</div>
              </div>
            </div>
          </article>
        </li>

        {{-- Группа #2 — точная копия, нужна для бесшовного зацикливания --}}
        <li class="marquee__group" aria-hidden="true">
          {{-- Скопируй те же карточки 1:1 --}}
          <article class="tcard" role="listitem" aria-label="Алексей, владелец магазина">
            <div class="tcard__quote">«Сервис помог запустить продажи за неделю. Упаковка — топ!»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/alexei.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Алексей</div>
                <div class="tcard__role">Владелец магазина</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Мария, маркетолог">
            <div class="tcard__quote">«Быстрый расчёт, аккуратная печать. Менеджер всегда на связи.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/maria.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Мария</div>
                <div class="tcard__role">Маркетолог</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Игорь, кофе-бренд">
            <div class="tcard__quote">«Коробки под размер стаканов — идеальная посадка, без люфта.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/igor.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Игорь</div>
                <div class="tcard__role">Основатель кофе‑бренда</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Анна, Etsy-продавец">
            <div class="tcard__quote">«Малые тиражи и печать логотипа спасли мой запуск на маркетплейсе.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/anna.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Анна</div>
                <div class="tcard__role">Продавец на Etsy</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Сергей, логистика">
            <div class="tcard__quote">«Транспортные коробки крепкие, выдержали дальние поездки без брака.»</div>
            <div class="tcard__meta">
              <img src="{{ Vite::asset('resources/images/testimonials/sergey.jpg') }}" alt="" aria-hidden="true" class="tcard__avatar">
              <div>
                <div class="tcard__name">Сергей</div>
                <div class="tcard__role">Руководитель логистики</div>
              </div>
            </div>
          </article>
        </li>
      </ul>
    </div>

    {{-- Примечание для пользователей со скринридером --}}
    <p class="sr-only" aria-live="polite">
      Лента отзывов прокручивается автоматически. Наведите курсор, чтобы остановить прокрутку.
    </p>
  </div>
</section>
