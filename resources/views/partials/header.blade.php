<!-- Skip link для доступности -->
<a class="skip-link" href="#main">Перейти к содержимому</a>

<header class="site-header header--transparent" role="banner">
  <div class="mainbar">
    <div class="main-container header-inner">
      <a class="brand" href="/" aria-label="На главную — Мастерская упаковки">
        <img src="{{ Vite::asset('resources/images/main-logo.svg') }}" alt="Мастерская упаковки" width="160" height="24"
          decoding="async">
      </a>
      <a href="https://mp.market/" class="brand-sub">проект компании Мистер Пакерс</a>

      <nav class="primary-nav" aria-label="Основная навигация">
        <ul class="nav-list" role="list">

          <li class="nav-item has-mega">
            <a href="/help" class="nav-link" id="mega-btn" aria-expanded="false" aria-haspopup="true"
              aria-controls="mega-catalog">
              Меню
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/about" aria-label="Перейти в корзину">
              О нас
            </a>
          </li>

          <li class="nav-item has-contacts">
            <a href="/contacts" class="nav-link" id="contacts-btn" aria-expanded="false" aria-haspopup="true"
              aria-controls="contacts-panel">
              Контакты
            </a>
            <div id="contacts-panel" class="dropdown" role="group" aria-label="Контакты" hidden>
              <ul class="dropdown-list" role="list">
                <li><a href="tel:88005503700" aria-label="Позвонить 8 800 550 37 00">8&nbsp;800&nbsp;550-37-00 <br><span
                      class="contact-label">звонок бесплатный</span></a></li>
                <li><a href="mailto:info@mp.market" aria-label="Написать на info@mp.market">info@mp.market <span
                      class="contact-label">по любым вопросам</span></a></li>
                <li><span aria-label="Время работы">Пн-Пт 08:00–17:00 <span class="contact-label">рабочий
                      график</span></span></li>
              </ul>
            </div>
          </li>

          <li class="nav-item cart">
            <a class="nav-link" href="/cart" aria-label="Перейти в корзину">
              Корзина
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="cart" fill="#333"
                width="20px">
                <g>
                  <path
                    d="M22,7.24l-2,8a1,1,0,0,1-.88.76l-11,1H8a1,1,0,0,1-1-.85l-1.38-9v0L5.14,4H3A1,1,0,0,1,3,2H5.14a2,2,0,0,1,2,1.69L7.48,6H21a1,1,0,0,1,.79.38A1,1,0,0,1,22,7.24ZM16.5,19A1.5,1.5,0,1,0,18,20.5,1.5,1.5,0,0,0,16.5,19Zm-6,0A1.5,1.5,0,1,0,12,20.5,1.5,1.5,0,0,0,10.5,19Z"
                    style="fill:#333"></path>
                </g>
              </svg>
              <span class="cart-badge" aria-hidden="true" data-cart-count>0</span>
              <span class="sr-only" id="cart-status">Корзина пуста</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="mobile-cta">
        <a class="nav-link mobile-cart" href="/cart" aria-label="Перейти в корзину">
          Корзина <span class="cart-badge" aria-hidden="true" data-cart-count>0</span>
        </a>
        <button class="nav-toggle" id="mobile-menu-toggle" aria-controls="mega-catalog" aria-expanded="false">
          Каталог
          <span class="nav-toggle-box" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>

  <div id="mega-catalog" class="mega-layer" hidden>
    <div class="main-container">
      <div class="mega-grid">
        <section class="mega-col">
          <h3 class="mega-title">Конструкции</h3>
          <ul role="list" class="mega-list">
            <li><a href="/fefco-0427">FEFCO 0427 (самосборные)</a></li>
            <li><a href="/lid-bottom">Крышка-дно</a></li>
            <li><a href="/transport">Транспортировочные</a></li>
            <li><a href="/dovetail">«Ласточкин хвост»</a></li>
          </ul>
        </section>

        <section class="mega-col">
          <h3 class="mega-title">Справка</h3>
          <ul role="list" class="mega-list">
            <li><a href="/help/delivery">О доставке</a></li>
            <li><a href="/help/payment">Об оплате</a></li>
            <li><a href="/help/returns">О возвратах</a></li>
            <li><a href="/help/faq">FAQ</a></li>
          </ul>
        </section>

        <section class="mega-col">
          <h3 class="mega-title">Опции</h3>
          <ul role="list" class="mega-list">
            <li><a href="/services/logo-print">Печать логотипа</a></li>
            <li><a href="/services/fullprint">Полноцветная печать</a></li>
            <li><a href="/services/logo-design">Разработка дизайна</a></li>
          </ul>
        </section>

        <section class="mega-col only-mobile">
          <h3 class="mega-title">Контакты</h3>
          <ul role="list" class="mega-list">
            <li><a href="tel:+79990000000">+7&nbsp;999&nbsp;000-00-00</a></li>
            <li><a href="mailto:hello@mp.market">hello@mp.market</a></li>
            <li><span>Пн-Пт 10:00–19:00</span></li>
          </ul>
        </section>
      </div>
    </div>
  </div>
</header>