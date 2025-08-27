<!-- Skip link для доступности -->
<a class="skip-link" href="#main">Перейти к содержимому</a>

<header class="site-header" role="banner">
  <!-- Верхняя вспомогательная полоса -->
  <div class="topbar" aria-label="Контакты и служебные ссылки">
    <div class="main-container">
      <ul class="topbar-list" role="list">
        <li>
          <a href="mailto:hello@mp.market" aria-label="Написать на email hello@mp.market">
            <!-- можно заменить на иконку -->
            <span class="topbar-item">hello@mp.market</span>
          </a>
        </li>
        <li>
          <a href="tel:+79990000000" aria-label="Позвонить по номеру +7 999 000 00 00">
            <span class="topbar-item">+7 999 000‑00‑00</span>
          </a>
        </li>
        <li class="topbar-right">
          <a href="/about" class="topbar-item">О компании</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Основная полоса с логотипом и навигацией -->
  <div class="mainbar">
    <div class="main-container mainbar-inner">
      <a class="brand" href="/" aria-label="На главную — Мастерская упаковки">
        <img src="{{ Vite::asset('resources/images/main-logo.svg') }}" alt="Мастерская упаковки" width="170" height="28" decoding="async">
      </a>

      <!-- Кнопка мобильного меню -->
      <button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false">
        <span class="nav-toggle-box" aria-hidden="true"></span>
        <span class="nav-toggle-label">Меню</span>
      </button>

      <!-- Основная навигация -->
      <nav id="primary-nav" class="primary-nav" aria-label="Основная навигация">
        <ul class="nav-list" role="list">

          <!-- Пункт с мега-меню -->
          <li class="has-mega">
            <button class="mega-toggle"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-controls="mega-panel">
              Меню
            </button>
            <div id="mega-panel" class="mega-panel" role="group" aria-label="Разделы меню">
              <div class="mega-grid">
                <section class="mega-col">
                  <h3 class="mega-title">Коробки</h3>
                  <ul role="list">
                    <li><a href="/fefco-0427">FEFCO 0427 (самосборные)</a></li>
                    <li><a href="/lid-bottom">Крышка‑дно</a></li>
                    <li><a href="/transport">Транспортировочные</a></li>
                    <li><a href="/dovetail">«Ласточкин хвост»</a></li>
                  </ul>
                </section>
                <section class="mega-col">
                  <h3 class="mega-title">Опции</h3>
                  <ul role="list">
                    <li><a href="/logo-print">Печать логотипа</a></li>
                    <li><a href="/fullprint">Полноцветная печать</a></li>
                    <li><a href="/design">Разработка дизайна</a></li>
                  </ul>
                </section>
                <section class="mega-col">
                  <h3 class="mega-title">Клиентам</h3>
                  <ul role="list">
                    <li><a href="/delivery">Доставка</a></li>
                    <li><a href="/payment">Оплата</a></li>
                    <li><a href="/faq">FAQ</a></li>
                  </ul>
                </section>
              </div>
            </div>
          </li>
          
          <li><a href="/contacts">Контакты</a></li>
          <li><a href="/cart" aria-label="Перейти в корзину">Корзина</a></li>
        </ul>
      </nav>
    </div>
  </div>
</header>

<main id="main" tabindex="-1">
  <!-- Страница -->
</main>

<script>
  (function(){
    const nav = document.getElementById('primary-nav');
    const burger = document.querySelector('.nav-toggle');
    const megaToggle = document.querySelector('.mega-toggle');
    const megaPanel = document.getElementById('mega-panel');

    // Мобильный бургер
    burger.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('open');
      burger.setAttribute('aria-expanded', String(isOpen));
      // закрываем мега-меню при открытии/закрытии бургера
      if (!isOpen) {
        megaPanel.classList.remove('open');
        megaToggle.setAttribute('aria-expanded','false');
      }
    });

    // Мега-меню: кнопка
    megaToggle.addEventListener('click', (e) => {
      const open = megaPanel.classList.toggle('open');
      megaToggle.setAttribute('aria-expanded', String(open));
      // если в десктопе, закрывать кликом вне
      if (open) {
        document.addEventListener('click', outsideClose);
      }
    });

    // Закрытие мега‑меню по клику вне (десктоп)
    function outsideClose(e){
      if (!e.target.closest('.has-mega')) {
        megaPanel.classList.remove('open');
        megaToggle.setAttribute('aria-expanded','false');
        document.removeEventListener('click', outsideClose);
      }
    }

    // Закрытие ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (megaPanel.classList.contains('open')) {
          megaPanel.classList.remove('open');
          megaToggle.setAttribute('aria-expanded','false');
          megaToggle.focus();
        }
        if (nav.classList.contains('open')) {
          nav.classList.remove('open');
          burger.setAttribute('aria-expanded','false');
          burger.focus();
        }
      }
    });
  })();
</script>
