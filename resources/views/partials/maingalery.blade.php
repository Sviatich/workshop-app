<!--
  Блок «Примеры работ» — сетка с управляемым паттерном рядов
  Изменения по твоим пунктам:
  1) Вместо «masonry» — детерминированная CSS Grid на 12‑колоночной сетке.
     Можно собирать строки как угодно: wide+small, small+wide, три small и т.д.
  2) Лайтбокс/скрипт просмотра — убран. Для твоего скрипта добавлен data-атрибут
     data-preview="image" на ссылках — ты перехватишь клики где нужно.
  Семантика и ARIA сохранены: <section> + <ul>/<li> + <figure>/<figcaption>.
-->
<section id="work-examples" class="works" aria-labelledby="works-title">
  <div class="works__header">
    <h2 id="works-title">Примеры работ</h2>
    <p class="works__desc">Выдержка проектов. Сетка управляется классами — можно задавать широкие/малые карточки под нужный паттерн.</p>
  </div>

  <!--
    Управляемая сетка:
    - .item--wide  → ширина 8 колонок из 12
    - .item--small → ширина 4 колонки из 12
    На мобильных все карточки растягиваются на всю ширину.

    Примеры раскладки ниже:
    Ряд 1: [wide (8)] + [small (4)]
    Ряд 2: [small (4)] + [wide (8)]
    Ряд 3: [small (4)] + [small (4)] + [small (4)]
  -->
  <ul class="works__grid" role="list">
    <!-- Ряд 1: wide + small -->
    <li class="grid__item item--wide" role="listitem">
      <figure class="card">
        <a class="card__link" href="/images/works/0427-full.jpg" data-preview="image" aria-label="Открыть работу: FEFCO 0427, бур/бур, тираж 150 шт">
          <img class="card__img"
               src="/images/works/0427-thumb.jpg"
               srcset="/images/works/0427-thumb.jpg 1x, /images/works/0427-thumb@2x.jpg 2x"
               width="1200" height="800"
               loading="lazy"
               alt="Самосборная коробка FEFCO 0427 из бурого картона, вид в три четверти" />
        </a>
        <figcaption class="card__caption">FEFCO 0427, бур/бур, тираж 150 шт</figcaption>
      </figure>
    </li>

    <li class="grid__item item--small" role="listitem">
      <figure class="card">
        <a class="card__link" href="/images/works/lid-bottom-full.jpg" data-preview="image" aria-label="Открыть работу: Крышка‑дно, полноцвет, 80 шт">
          <img class="card__img"
               src="/images/works/lid-bottom-thumb.jpg"
               width="800" height="800"
               loading="lazy"
               alt="Подарочная коробка крышка‑дно с полноцветной печатью и логотипом" />
        </a>
        <figcaption class="card__caption">Крышка‑дно, полноцвет, 80 шт</figcaption>
      </figure>
    </li>

    <!-- Ряд 2: три small (опционально) -->
    <li class="grid__item item--small" role="listitem">
      <figure class="card">
        <a class="card__link" href="/images/works/box-a-full.jpg" data-preview="image" aria-label="Открыть работу: Самосборная с печатью 1+0">
          <img class="card__img" src="/images/works/box-a-thumb.jpg" width="800" height="900" loading="lazy" alt="Небольшая коробка с одноцветной печатью 1+0" />
        </a>
        <figcaption class="card__caption">Самосборная, печать 1+0</figcaption>
      </figure>
    </li>

    <li class="grid__item item--small" role="listitem">
      <figure class="card">
        <a class="card__link" href="/images/works/box-b-full.jpg" data-preview="image" aria-label="Открыть работу: Транспортировочная, 5‑слой">
          <img class="card__img" src="/images/works/box-b-thumb.jpg" width="800" height="900" loading="lazy" alt="Коробка транспортировочная пятиислойная" />
        </a>
        <figcaption class="card__caption">Транспортировочная, 5‑слой</figcaption>
      </figure>
    </li>

    <li class="grid__item item--small" role="listitem">
      <figure class="card">
        <a class="card__link" href="/images/works/box-c-full.jpg" data-preview="image" aria-label="Открыть работу: Крышка‑дно, шелкография">
          <img class="card__img" src="/images/works/box-c-thumb.jpg" width="800" height="900" loading="lazy" alt="Подарочная коробка крышка‑дно с шелкографией" />
        </a>
        <figcaption class="card__caption">Крышка‑дно, шелкография</figcaption>
      </figure>
    </li>
  </ul>
</section>