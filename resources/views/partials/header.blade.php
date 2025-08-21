<!-- Skip link для доступности -->
<a class="skip-link" href="#main">Перейти к содержимому</a>

<header class="site-header" role="banner">
  <!-- Верхняя вспомогательная полоса -->
  <div class="topbar" aria-label="Контакты и служебные ссылки">
    <div class="container">
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
    <div class="container mainbar-inner">
      <a class="brand" href="/" aria-label="На главную — Мастерская упаковки">
        <img src="{{ Vite::asset('resources/images/main-logo.svg') }}" alt="Мастерская упаковки" width="132" height="28" decoding="async">
      </a>

      <!-- Кнопка мобильного меню -->
      <button class="nav-toggle" aria-controls="primary-nav" aria-expanded="false">
        <span class="nav-toggle-box" aria-hidden="true"></span>
        <span class="nav-toggle-label">Меню</span>
      </button>

      <!-- Основная навигация -->
      <nav id="primary-nav" class="primary-nav" aria-label="Основная навигация">
        <ul class="nav-list" role="list">
          <li><a href="/">Главная</a></li>

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

          <li><a href="/cases">Кейсы</a></li>
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

<style>
  :root{
    --c-bg: #0d0d0f;
    --c-bg-2:#121217;
    --c-text:#ffffff;
    --c-dim:#9aa3af;
    --c-accent:#3b82f6;
    --c-border:#1f2937;
    --radius: 14px;
  }
  .container{max-width:800px;margin-inline:auto;padding-inline:16px}
  .skip-link{
    position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;
  }
  .skip-link:focus{
    left:16px;top:16px;width:auto;height:auto;background:#fff;color:#000;
    padding:8px 12px;border-radius:8px;z-index:1000
  }

  .site-header{color:var(--c-text);background:linear-gradient(180deg,var(--c-bg) 0,var(--c-bg-2) 100%)}
  .topbar{border-bottom:1px solid var(--c-border);font-size:14px}
  .topbar-list{display:flex;gap:16px;align-items:center;min-height:40px;margin:0;padding:0;list-style:none}
  .topbar-item{color:var(--c-dim)}
  .topbar a:hover .topbar-item{color:#fff;text-decoration:underline}
  .topbar-right{margin-left:auto}

  .mainbar{position:sticky;top:0;z-index:50;border-bottom:1px solid var(--c-border)}
  .mainbar-inner{display:flex;align-items:center;gap:16px;min-height:64px}
  .brand{display:inline-flex;align-items:center;gap:8px}

  .nav-toggle{
    margin-left:auto;display:inline-flex;align-items:center;gap:8px;
    border:1px solid var(--c-border);background:transparent;color:var(--c-text);
    padding:8px 10px;border-radius:10px;cursor:pointer
  }
  .nav-toggle-box{width:20px;height:2px;background:var(--c-text);position:relative;display:inline-block}
  .nav-toggle-box::before,.nav-toggle-box::after{
    content:"";position:absolute;left:0;width:20px;height:2px;background:var(--c-text);transition:transform .2s ease
  }
  .nav-toggle-box::before{top:-6px}.nav-toggle-box::after{top:6px}
  .nav-toggle[aria-expanded="true"] .nav-toggle-box{background:transparent}
  .nav-toggle[aria-expanded="true"] .nav-toggle-box::before{transform:translateY(6px) rotate(45deg)}
  .nav-toggle[aria-expanded="true"] .nav-toggle-box::after{transform:translateY(-6px) rotate(-45deg)}
  .nav-toggle-label{font-size:14px}

  .primary-nav{display:none}
  .primary-nav.open{display:block}
  .nav-list{display:flex;align-items:center;gap:20px;list-style:none;margin:0;padding:0}
  .nav-list a,.mega-toggle{
    color:#fff;text-decoration:none;padding:10px 8px;border-radius:10px;line-height:1
  }
  .nav-list a:hover,.mega-toggle:hover{background:rgba(255,255,255,.06)}

  .has-mega{position:relative}
  .mega-toggle{
    background:transparent;border:0;cursor:pointer;display:inline-flex;align-items:center;gap:6px
  }
  .mega-toggle::after{
    content:"";width:0;height:0;border-left:5px solid transparent;border-right:5px solid transparent;
    border-top:6px solid var(--c-dim);transition:transform .2s ease
  }
  .mega-toggle[aria-expanded="true"]::after{transform:rotate(180deg)}
  .mega-panel{
    position:absolute;left:0;right:0;top:calc(100% + 10px);
    background:#0f1116;border:1px solid var(--c-border);border-radius:var(--radius);
    padding:18px;display:none;box-shadow:0 12px 30px rgba(0,0,0,.35);min-width:560px
  }
  .mega-panel.open{display:block}
  .mega-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
  .mega-title{font-size:14px;color:var(--c-dim);margin:0 0 8px}
  .mega-col ul{list-style:none;margin:0;padding:0}
  .mega-col a{display:block;padding:8px;border-radius:10px;color:#fff;text-decoration:none}
  .mega-col a:hover{background:rgba(255,255,255,.06)}

  /* Десктоп */
  @media (min-width: 880px){
    .nav-toggle{display:none}
    .primary-nav{display:block;margin-left:auto}
    .mega-panel{left:-20px;right:auto}
  }

  /* Мобилка */
  @media (max-width: 879.98px){
    .primary-nav{border-top:1px solid var(--c-border);padding-top:8px}
    .nav-list{flex-direction:column;align-items:flex-start;padding-block:8px}
    .has-mega{width:100%}
    .mega-panel{
      position:static;display:none;margin-top:8px;min-width:unset;border-radius:12px
    }
    .mega-panel.open{display:block}
    .mega-grid{grid-template-columns:1fr}
  }

  /* Сужение фокуса для клавиатуры */
  :focus-visible{outline:2px solid var(--c-accent);outline-offset:2px;border-radius:10px}
</style>

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
