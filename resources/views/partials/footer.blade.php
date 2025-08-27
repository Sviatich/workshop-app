<!-- Footer -->
<footer class="footer" role="contentinfo" aria-labelledby="footer-title" itemscope itemtype="https://schema.org/Organization">
  <h2 id="footer-title" class="visually-hidden">Сведения о компании и навигация по разделам сайта</h2>

  <div class="footer__top">
    <!-- Brand / About -->
    <section class="footer__brand" aria-labelledby="footer-brand-title">
      <img src="{{ Vite::asset('resources/images/main-logo.svg') }}" alt="Мастерская упаковки" width="170" height="40" decoding="async">
      <p class="footer__tagline" itemprop="description">
        Упаковка на заказ от 10 шт. Производство, дизайн и быстрая доставка.
      </p>

      <address class="footer__address" aria-label="Контакты">
        <span itemprop="name" class="visually-hidden">Мистер Пакерс</span>
        <p>
          <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <span itemprop="postalCode">142432</span>, 
            <span itemprop="addressLocality">Черноголовка</span>, 
            <span itemprop="streetAddress">ул. Первый проезд, 8</span>
          </span>
        </p>
        <p>
          Тел: <a href="tel:88005503700" itemprop="telephone">8 800 550 37 00</a><br>
          Email: <a href="mailto:info@mp.market" itemprop="email">info@mp.market</a>
        </p>
        <p aria-label="График работы">
          Пн–Пт: <time datetime="09:00">08:00</time>—<time datetime="19:00">17:00</time>, Сб–Вс: выходной
        </p>
      </address>

    </section>

    <!-- Link columns -->
    <nav class="footer__nav" aria-label="Разделы сайта">

      <section class="footer__col" aria-labelledby="footer-col-help">
        <h3 id="footer-col-help" class="footer__heading">Помощь</h3>
        <ul class="footer__list">
          <li><a href="/how-to-order">Как оформить заказ</a></li>
          <li><a href="/delivery">Доставка и оплата</a></li>
          <li><a href="/file-requirements">Требования к макетам</a></li>
          <li><a href="/returns">Возврат и обмен</a></li>
          <li><a href="/faq">FAQ</a></li>
          <li><a href="/contacts">Контакты</a></li>
        </ul>
      </section>

      <section class="footer__col" aria-labelledby="footer-col-company">
        <h3 id="footer-col-company" class="footer__heading">Компания</h3>
        <ul class="footer__list">
          <li><a href="/about">О нас</a></li>
          <li><a href="/production">Производство</a></li>
          <li><a href="/blog">Блог</a></li>
        </ul>
      </section>
    </nav>

    <!-- Newsletter -->
    <section class="footer__subscribe" aria-labelledby="footer-subscribe-title">
      <div class="footer__payments" aria-label="Мы принимаем">
        <span class="footer__muted">Принимаем к оплате:</span>
        <ul class="footer__paylist">
          <li aria-label="Visa" title="Visa"><span class="pay pay--visa" aria-hidden="true"></span></li>
          <li aria-label="Mastercard" title="Mastercard"><span class="pay pay--mc" aria-hidden="true"></span></li>
          <li aria-label="Мир" title="Мир"><span class="pay pay--mir" aria-hidden="true"></span></li>
          <li aria-label="ЮKassa" title="ЮKassa"><span class="pay pay--yk" aria-hidden="true"></span></li>
        </ul>
      </div>
      <div>
        <span class="footer__muted">Наши соц-сети:</span>
        <ul class="footer__social" aria-label="Мы в соцсетях">
          <li><a class="footer__social-link" href="#" aria-label="Telegram">
            <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24"><path d="M9.9 16.2 9.8 19c.4 0 .6-.2.8-.4l1.9-1.8 3.9 2.9c.7.4 1.2.2 1.4-.7l2.6-12c.2-.9-.3-1.3-1.1-1L3.6 9c-.9.3-.9.8-.2 1l4.7 1.5 10.9-6.9-9.1 8.8Z" /></svg>
            <span class="visually-hidden">Telegram</span></a></li>
          <li><a class="footer__social-link" href="#" aria-label="VK">
            <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24"><path d="M3 7c0-.6.4-1 1-1h16a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7Zm4.1 2.5c.2 3 1.7 5 4.5 5.5V12h1.3c.2.8.8 1.5 2.1 2 0 0-1.8 1.6-3.4 1.6-3.1 0-5-2.4-4.5-5.1h0Z"/></svg>
            <span class="visually-hidden">VK</span></a></li>
          <li><a class="footer__social-link" href="#" aria-label="YouTube">
            <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24"><path d="M22 12c0-2.2-.2-3.6-.5-4.4-.3-.7-.8-1.2-1.5-1.4C18.9 6 12 6 12 6s-6.9 0-8 .2c-.7.2-1.2.7-1.5 1.4C2.2 8.4 2 9.8 2 12s.2 3.6.5 4.4c.3.7.8 1.2 1.5 1.4 1.1.2 8 .2 8 .2s6.9 0 8-.2c.7-.2 1.2-.7 1.5-1.4.3-.8.5-2.2.5-4.4ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg>
            <span class="visually-hidden">YouTube</span></a></li>
        </ul>
      </div>
      <div>
        <span class="footer__muted">Отзывы Яндекс:</span>
        <ul class="footer__social" aria-label="Отзывы о нас">
          <li>
            <iframe style="outline: 1px solid #ddd;border-radius: 4px;" src="https://yandex.ru/sprav/widget/rating-badge/142486939387?type=rating" width="150" height="50" frameborder="0"></iframe>
          </li>
        </ul>
      </div>
    </section>
  </div>

  <!-- Bottom bar -->
  <div class="footer__bottom" role="navigation" aria-label="Правовая информация и язык">
    <ul class="footer__legal">
      <li><a href="/privacy">Политика конфиденциальности</a></li>
      <li><a href="/terms">Пользовательское соглашение</a></li>
      <li><a href="/cookies" aria-describedby="cookie-note">Cookies</a></li>
    </ul>

    <p id="cookie-note" class="visually-hidden">Мы используем cookies для работы сайта и аналитики.</p>
    <a class="footer__to-top" href="#top" aria-label="Вернуться к началу страницы">↑ Наверх</a>
  </div>

  <div class="footer__copyright">
    <p>&copy; <span id="footer-year">{{ date('Y') }}</span> <span itemprop="name">ООО «НУК»</span>. Вся информация, размещенная на сайте, носит справочный характер и не является публичной офертой, определяемой положениями ч.2, ст. 437 Гражданского кодекса РФ. Производитель товаров вправе вносить изменения в описание, внешний вид и комплектацию товаров без предварительного уведомления. Администрация сайта стремится предоставлять актуальную информацию своевременно, но не исключает возможность ошибок. Уточняйте данные перед оформлением заказа по телефону: 8 (800) 550 37 00.</p>
  </div>
</footer>
