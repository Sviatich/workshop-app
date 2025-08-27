<!--
  Единый модуль: «Производство» + «Нестандартная конструкция»
  — Семантика: один <section> с двумя подпунктами <article>.
  — Доступность: aria-labelledby на подпунктах, понятные заголовки и описания.
  — SEO: h2 для секции, h3 для подпунктов, чёткие тексты кнопок, rel="noopener".
  — Стили совместимы с твоей сеткой (CSS Grid), без JS.
-->
<section id="production-and-custom" class="module" aria-labelledby="module-title">
  <div class="module__header">
    <h2 id="module-title">Производство и индивидуальные решения</h2>
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