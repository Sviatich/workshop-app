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
    <h2 id="works-title" class="works__title">Примеры работ</h2>
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

<style>
  .works { padding: 2rem 0; }
  .works__header { margin-bottom: 1rem; }
  .works__title { font-size: 1.75rem; line-height: 1.2; margin: 0 0 .25rem; }
  .works__desc { color: #666; margin: 0; }

  /* 12‑колоночная управляемая сетка */
  .works__grid {
    display: grid;
    grid-template-columns: repeat(12, minmax(0, 1fr));
    gap: 1rem;
    list-style: none;
    padding: 0;
    margin: 1rem 0 0;
  }

  .grid__item { display: block; }
  .item--wide  { grid-column: span 8; }
  .item--small { grid-column: span 4; }

  /* Мобильные: по одной в ряд */
  @media (max-width: 639px) {
    .item--wide,
    .item--small { grid-column: 1 / -1; }
  }

  /* Карточка */
  .card { display: block; margin: 0; background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow: hidden; border: 1px solid rgba(0,0,0,.06); }
  .card__link { display: block; line-height: 0; }
  .card__link:focus-visible { outline: 3px solid #005fcc; outline-offset: 2px; border-radius: 2px; }
  .card__img { display: block; width: 100%; height: auto; }
  .card__caption { font-size: .875rem; color: #444; padding: .5rem .75rem .75rem; }

  /* Умеренный hover для мыши */
  @media (hover: hover) and (pointer: fine) {
    .card__link:hover .card__img { filter: brightness(.98); transform: translateY(-1px); transition: transform .2s ease, filter .2s ease; }
  }
</style>


{{-- ывфвы --}}

<!--
  Единый модуль: «Производство» + «Нестандартная конструкция»
  — Семантика: один <section> с двумя подпунктами <article>.
  — Доступность: aria-labelledby на подпунктах, понятные заголовки и описания.
  — SEO: h2 для секции, h3 для подпунктов, чёткие тексты кнопок, rel="noopener".
  — Стили совместимы с твоей сеткой (CSS Grid), без JS.
-->
<section id="production-and-custom" class="module" aria-labelledby="module-title">
  <div class="module__header">
    <h2 id="module-title" class="module__title">Производство и индивидуальные решения</h2>
    <p class="module__desc">Собственное производство, быстрые сроки и возможность спроектировать любую конструкцию под ваш бренд.</p>
  </div>

  <div class="module__grid" role="list">
    <!-- Подмодуль: Производство -->
    <article class="card card--primary" role="listitem" aria-labelledby="production-title">
      <div class="card__body">
        <h3 id="production-title" class="card__title">Наше производство</h3>
        <p class="card__lead">Полный цикл: от резки и высечки до печати и финиша. Контроль качества на каждом этапе.</p>

        <ul class="features" role="list">
          <li class="features__item">
            <span class="features__icon" aria-hidden="true">🔧</span>
            <div>
              <p class="features__title">Собственный парк оборудования</p>
              <p class="features__text">Высекальные штампы, плоттерная резка, флексо‑ и шелкография, тиснение.</p>
            </div>
          </li>
          <li class="features__item">
            <span class="features__icon" aria-hidden="true">⏱️</span>
            <div>
              <p class="features__title">Сроки от 2–5 дней</p>
              <p class="features__text">Экспресс‑тиражи малых объёмов без потери качества.</p>
            </div>
          </li>
          <li class="features__item">
            <span class="features__icon" aria-hidden="true">📦</span>
            <div>
              <p class="features__title">Тиражи от 10 штук</p>
              <p class="features__text">Индивидуальная упаковка для маркетплейсов и небольших брендов.</p>
            </div>
          </li>
          <li class="features__item">
            <span class="features__icon" aria-hidden="true">🧪</span>
            <div>
              <p class="features__title">Прототипирование</p>
              <p class="features__text">Тестовые образцы перед запуском тиража.</p>
            </div>
          </li>
        </ul>

        <div class="kp">
          <p class="kp__hint">Нужен расчёт прямо сейчас?</p>
          <a class="btn" href="#configurator" aria-label="Перейти к конфигуратору для расчёта стоимости">Рассчитать в конфигураторе</a>
        </div>
      </div>
    </article>

    <!-- Подмодуль: Индивидуальная конструкция / отдельный сайт -->
    <article class="card card--accent" role="listitem" aria-labelledby="custom-title">
      <div class="card__body">
        <h3 id="custom-title" class="card__title">Нестандартная конструкция</h3>
        <p class="card__lead">Если вам нужна уникальная коробка или сложная конструкция — разработаем под задачу и запустим в производство.</p>

        <ul class="bullets" role="list">
          <li class="bullets__item">Разработка КД и штампа по ТЗ или образцу</li>
          <li class="bullets__item">Подбор картона, печати и финишной отделки</li>
          <li class="bullets__item">Пилотная партия и отладка упаковки под логистику</li>
        </ul>

        <div class="cta">
          <a class="btn btn--outline" href="https://example-custom-site.tld" target="_blank" rel="noopener" aria-label="Открыть сайт для заказа индивидуальной конструкции в новой вкладке">Заказать на нашем втором сайте</a>
          <p class="cta__note">Продвинутый бриф, примеры конструкций и калькулятор — на отдельном сайте.</p>
        </div>
      </div>
    </article>
  </div>
</section>

<style>
  .module { padding: 2rem 0; }
  .module__header { margin-bottom: 1rem; }
  .module__title { font-size: 1.75rem; line-height: 1.2; margin: 0 0 .25rem; }
  .module__desc { color: #666; margin: 0; }

  /* Сетка: две карточки рядом на десктопе, одна под другой — на мобиле */
  .module__grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  @media (min-width: 1024px) {
    .module__grid { grid-template-columns: 1fr 1fr; }
  }

  .card { background: #fff; border: 1px solid rgba(0,0,0,.06); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,.08); overflow: hidden; }
  .card--primary { background: #fff; }
  .card--accent { background: #0f172a; color: #e5e7eb; border-color: rgba(255,255,255,.12); }
  .card__body { padding: 1rem 1rem 1.25rem; }
  .card__title { font-size: 1.25rem; margin: 0 0 .5rem; }
  .card__lead { margin: 0 0 .75rem; color: #444; }
  .card--accent .card__lead { color: #cbd5e1; }

  .features, .bullets { list-style: none; padding: 0; margin: 0 0 1rem; display: grid; gap: .75rem; }
  .features { grid-template-columns: 1fr; }
  @media (min-width: 640px) { .features { grid-template-columns: 1fr 1fr; } }

  .features__item { display: grid; grid-template-columns: auto 1fr; gap: .5rem .75rem; align-items: start; padding: .5rem; border-radius: 10px; background: rgba(0,0,0,.02); }
  .card--accent .features__item { background: rgba(255,255,255,.06); }
  .features__icon { font-size: 1.1rem; line-height: 1; }
  .features__title { margin: 0; font-weight: 600; }
  .features__text { margin: .2rem 0 0; color: #555; }
  .card--accent .features__text { color: #cbd5e1; }

  .bullets__item { padding-left: 1.25rem; position: relative; color: #333; }
  .bullets__item::before { content: "•"; position: absolute; left: 0; top: 0; }
  .card--accent .bullets__item { color: #dbeafe; }

  .kp { display: flex; gap: .75rem; align-items: center; flex-wrap: wrap; }
  .kp__hint { margin: 0; color: #666; }

  .cta { display: grid; gap: .5rem; }
  .cta__note { margin: 0; font-size: .9rem; color: #64748b; }
  .card--accent .cta__note { color: #93c5fd; }

  .btn { display: inline-block; border: 1px solid #0f172a; background: #0f172a; color: #fff; padding: .625rem 1rem; border-radius: 10px; text-decoration: none; font-weight: 600; }
  .btn:hover { filter: brightness(.95); }
  .btn:focus-visible { outline: 3px solid #005fcc; outline-offset: 2px; }

  .btn--outline { background: transparent; color: currentColor; border-color: currentColor; }
</style>