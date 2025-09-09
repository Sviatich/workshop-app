<!-- Skip link для доступности -->
<a class="skip-link" href="#main">Перейти к содержимому</a>

<header class="site-header header--transparent" role="banner">
  <div class="mainbar">
    <div class="main-container header-inner">
      <a class="brand" href="/" aria-label="На главную — Мастерская упаковки">
        <img src="{{ Vite::asset('resources/images/main-logo.svg') }}" alt="Мастерская упаковки" width="160" height="24"
          decoding="async">
      </a>
      <a href="https://mp.market/" class="btn-hover-effect brand-sub hidden lg:block">проект компании Мистер Пакерс</a>

      <nav class="primary-nav" aria-label="Основная навигация">
        <ul class="nav-list" role="list">

          <li class="nav-item has-mega">
            <a href="/help" class="nav-link" id="mega-btn" aria-expanded="false" aria-haspopup="true"
              aria-controls="mega-catalog">
              Меню
              <svg class="nav-link-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M17.9188 8.17969H11.6888H6.07877C5.11877 8.17969 4.63877 9.33969 5.31877 10.0197L10.4988 15.1997C11.3288 16.0297 12.6788 16.0297 13.5088 15.1997L15.4788 13.2297L18.6888 10.0197C19.3588 9.33969 18.8788 8.17969 17.9188 8.17969Z"
                  fill="#999"></path>
              </svg>
            </a>
          </li>

          <li class="nav-item has-contacts">
            <a href="/contacts" class="nav-link" id="contacts-btn" aria-expanded="false" aria-haspopup="true"
              aria-controls="contacts-panel">
              Контакты
              <svg class="nav-link-arrow" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M17.9188 8.17969H11.6888H6.07877C5.11877 8.17969 4.63877 9.33969 5.31877 10.0197L10.4988 15.1997C11.3288 16.0297 12.6788 16.0297 13.5088 15.1997L15.4788 13.2297L18.6888 10.0197C19.3588 9.33969 18.8788 8.17969 17.9188 8.17969Z"
                  fill="#999"></path>
              </svg>
            </a>
            <div id="contacts-panel" class="dropdown" role="group" aria-label="Контакты" hidden>
              <ul class="dropdown-list" role="list">
                <li><a href="tel:88005503700" aria-label="Позвонить 8 800 550 37 00">8&nbsp;800&nbsp;550-37-00 <br><span
                      class="contact-label">звонок бесплатный</span></a></li>
                <li><a href="mailto:workshop@mp.market" aria-label="Написать на workshop@mp.market">workshop@mp.market
                    <span class="contact-label">по любым вопросам</span></a></li>
                <li><span aria-label="Время работы">Пн-Пт 08:00–17:00 <span class="contact-label">рабочий
                      график</span></span></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/about" aria-label="Перейти в корзину">
              О нас
            </a>
          </li>

          <li class="nav-item cart">
            <a class="nav-link" href="/cart" aria-label="Перейти в корзину">
              Корзина
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="cart" fill="#333" width="20px">
                <path
                  d="M22,7.24l-2,8a1,1,0,0,1-.88.76l-11,1H8a1,1,0,0,1-1-.85l-1.38-9v0L5.14,4H3A1,1,0,0,1,3,2H5.14a2,2,0,0,1,2,1.69L7.48,6H21a1,1,0,0,1,.79.38A1,1,0,0,1,22,7.24ZM16.5,19A1.5,1.5,0,1,0,18,20.5,1.5,1.5,0,0,0,16.5,19Zm-6,0A1.5,1.5,0,1,0,12,20.5,1.5,1.5,0,0,0,10.5,19Z"
                  style="fill:#333"></path>
              </svg>
              <span class="cart-badge" aria-hidden="true" data-cart-count>0</span>
              <span class="sr-only" id="cart-status">Корзина пуста</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="mobile-cta">
        <a class="nav-link mobile-cart" href="/cart" aria-label="Перейти в корзину">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" id="cart" fill="#333" width="20px">
            <path
              d="M22,7.24l-2,8a1,1,0,0,1-.88.76l-11,1H8a1,1,0,0,1-1-.85l-1.38-9v0L5.14,4H3A1,1,0,0,1,3,2H5.14a2,2,0,0,1,2,1.69L7.48,6H21a1,1,0,0,1,.79.38A1,1,0,0,1,22,7.24ZM16.5,19A1.5,1.5,0,1,0,18,20.5,1.5,1.5,0,0,0,16.5,19Zm-6,0A1.5,1.5,0,1,0,12,20.5,1.5,1.5,0,0,0,10.5,19Z"
              style="fill:#333"></path>
          </svg><span class="cart-badge" aria-hidden="true" data-cart-count>0</span>
        </a>
        <button class="nav-toggle" id="mobile-menu-toggle" aria-controls="mega-catalog" aria-expanded="false">
          <span class="nav-toggle-box" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>

  <div id="mega-catalog" class="mega-layer" hidden>
    <div class="main-container">
      <div class="mega-grid">

        <section class="mega-col">
          <h3 class="mega-title">Справка</h3>
          <ul role="list" class="mega-list">
            <li><a href="/help/delivery">Доставка товара</a></li>
            <li><a href="/help/returns">Возврат товара</a></li>
            <li><a href="/help/payment">Оплата заказа</a></li>
            <li><a href="/help/faq">Частые вопросы</a></li>
            <li><a href="/help/how-to-order">Как оформить заказ</a></li>
          </ul>
        </section>

        <section class="mega-col">
          <h3 class="mega-title">Дополнительные услуги</h3>
          <ul role="list" class="mega-list">
            <li><a href="/help/logo-print">Печать логотипа</a></li>
            <li><a href="/help/fullprint">Полноцветная печать</a></li>
            <li><a href="/help/logo-design">Разработка дизайна</a></li>
          </ul>
        </section>

        <section class="mega-col only-mobile">
          <h3 class="mega-title">Контакты</h3>
          <ul role="list" class="mega-list">
            <li><a href="tel:88005503700">+7&nbsp;800&nbsp;550-37-00</a></li>
            <li><span>Пн-Пт 08:00–17:00</span></li>
            <li><a href="mailto:workshop@mp.market">workshop@mp.market</a></li>
          </ul>
        </section>

        <section class="mega-col">
          <div class="p-4 bg-gray-100 border rounded h-full flex flex-col justify-center items-center">
            <h3 class="text-center font-semibold mb-2">Нужна другая <div class="header-banner-badge">конструкция</div></h3>
            <p class="mb-3 text-xs text-center">
              Разработаем индивидуальное решение или предложим готовый вариант под ваши задачи
            </p>
            <img width="120px" src="{{ Vite::asset('resources/images/dieline.webp') }}" class="mb-4" alt="Конструкция">
            <a target="_blank" href="https://mp.market/factory/"
              class="inline-block mt-auto px-4 py-2 w-full text-center primary-bg-color btn-hover-effect text-white text-sm font-medium rounded hover:bg-blue-700 transition">
              Разработаем для вас
            </a>
          </div>
        </section>

      </div>
    </div>
  </div>

</header>