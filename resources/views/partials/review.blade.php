<section class="py-12 bg-white main-block" aria-labelledby="testimonials-title">
  <div class="mx-auto">
    <div class="flex justify-between items-baseline">
      <h2 id="testimonials-title" class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
        Что пишут клиенты
      </h2>
      <a href="https://yandex.ru/profile/142486939387?lang=ru" target="_blank" class="flex gap-2 marquee__rating items-center btn-hover-effect-dark"><img
          width="15px" src="{{ Vite::asset('resources/images/yandex.svg') }}" alt="Yandex"> оставить отзыв</a>
    </div>
    <div class="marquee mask-fade" role="region" aria-label="Отзывы клиентов, автопрокрутка справа налево">
      <ul class="marquee__track" role="list">
        {{-- Группа #1 --}}
        <li class="marquee__group" aria-hidden="false">
          <article class="tcard" role="listitem" aria-label="Рыжова Таня">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Несколько месяцев работаю с этой компанией. Заказываю самосборные коробки.»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Рыжова Таня</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Кирилл Чирятьев">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Сервис на высоте, качество коробок шикарное, высокая клиентоориентированность.»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Кирилл Чирятьев</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Ирина Н">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Все отлично. Быстро, качественно и по очень хорошим ценам. Спасибо!»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Ирина Н.</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Максим Нижников">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Обслуживание и обратная связь на высоте, качество отличное.»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Максим Нижников</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Регина Бекетова">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Выражаю огромную благодарность! Всё на высшем уровне!»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Регина Бекетова</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>
        </li>

        {{-- Группа #2 --}}
        <li class="marquee__group" aria-hidden="true">
           <article class="tcard" role="listitem" aria-label="Рыжова Таня">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Несколько месяцев работаю с этой компанией. Заказываю самосборные коробки.»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Рыжова Таня</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Кирилл Чирятьев">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Сервис на высоте, качество коробок шикарное, высокая клиентоориентированность.»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Кирилл Чирятьев</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Ирина Н">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Все отлично. Быстро, качественно и по очень хорошим ценам. Спасибо!»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Ирина Н.</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Максим Нижников">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Обслуживание и обратная связь на высоте, качество отличное.»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Максим Нижников</div>
                <div class="tcard__role">Клиент</div>
              </div>
            </div>
          </article>

          <article class="tcard" role="listitem" aria-label="Регина Бекетова">
            <img width="80px" src="{{ Vite::asset('resources/images/stars.svg') }}" alt="5 звезд" class="object-cover">
            <div class="tcard__quote">«Выражаю огромную благодарность! Всё на высшем уровне!»</div>
            <div class="tcard__meta">
              <div>
                <div class="tcard__name">Регина Бекетова</div>
                <div class="tcard__role">Клиент</div>
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