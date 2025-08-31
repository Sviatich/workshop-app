<!-- Footer -->
<footer class="footer" role="contentinfo" aria-labelledby="footer-title" itemscope
  itemtype="https://schema.org/Organization">
  <h2 id="footer-title" class="visually-hidden">Сведения о компании и навигация по разделам сайта</h2>

  <div class="footer__top">
    <!-- Brand / About -->
    <section class="footer__brand" aria-labelledby="footer-brand-title">
      <img src="{{ Vite::asset('resources/images/main-logo.svg') }}" alt="Мастерская упаковки" width="150" height="40"
        decoding="async" class="mb-2">
      <p class="footer__tagline" itemprop="description">
        С 2008 года производим упаковку, которая работает на ваш бизнес.
      </p>

      <address class="footer__address" aria-label="Контакты">
        <span itemprop="name" class="visually-hidden">Мистер Пакерс | Мастерская упаковки</span>
        <p class="mb-3">
          <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <span itemprop="postalCode">142432</span>,
            <span itemprop="addressLocality">Черноголовка</span>,
            <span itemprop="streetAddress">ул. Первый проезд, 8</span>
          </span>
        </p>
        <p class="flex gap-2">
          <svg width="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g>
              <path
                d="M14.3308 15.9402L15.6608 14.6101C15.8655 14.403 16.1092 14.2384 16.3778 14.1262C16.6465 14.014 16.9347 13.9563 17.2258 13.9563C17.517 13.9563 17.8052 14.014 18.0739 14.1262C18.3425 14.2384 18.5862 14.403 18.7908 14.6101L20.3508 16.1702C20.5579 16.3748 20.7224 16.6183 20.8346 16.887C20.9468 17.1556 21.0046 17.444 21.0046 17.7351C21.0046 18.0263 20.9468 18.3146 20.8346 18.5833C20.7224 18.8519 20.5579 19.0954 20.3508 19.3L19.6408 20.02C19.1516 20.514 18.5189 20.841 17.8329 20.9541C17.1469 21.0672 16.4427 20.9609 15.8208 20.6501C10.4691 17.8952 6.11008 13.5396 3.35083 8.19019C3.03976 7.56761 2.93414 6.86242 3.04914 6.17603C3.16414 5.48963 3.49384 4.85731 3.99085 4.37012L4.70081 3.65015C5.11674 3.23673 5.67937 3.00464 6.26581 3.00464C6.85225 3.00464 7.41488 3.23673 7.83081 3.65015L9.40082 5.22021C9.81424 5.63615 10.0463 6.19871 10.0463 6.78516C10.0463 7.3716 9.81424 7.93416 9.40082 8.3501L8.0708 9.68018C8.95021 10.8697 9.91617 11.9926 10.9608 13.04C11.9994 14.0804 13.116 15.04 14.3008 15.9102L14.3308 15.9402Z"
                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
          </svg>
          <a href="tel:88005503700" itemprop="telephone">8 800 550 37 00</a>
        </p>
        <p class="flex gap-2 mb-3">
          <svg width="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g>
              <path d="M4 7.00005L10.2 11.65C11.2667 12.45 12.7333 12.45 13.8 11.65L20 7" stroke="#000000"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              <rect x="3" y="5" width="18" height="14" rx="2" stroke="#000000" stroke-width="2" stroke-linecap="round">
              </rect>
            </g>
          </svg>
          <a href="mailto:info@mp.market" itemprop="email">info@mp.market</a>
        </p>
        <p aria-label="График работы">
          Пн–Пт: <time datetime="09:00">08:00</time>—<time datetime="19:00">17:00</time><br> Сб–Вс: выходной
        </p>
        <img width="120px" class="mt-4" src="{{ Vite::asset('resources/images/workdays.svg') }}" alt="Рабочий график">
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
        <span class="footer__muted">Принимаем к оплате</span>
        <ul class="footer__paylist">
          <li aria-label="Visa" title="Visa">
            <span class="pay pay--visa" aria-hidden="true">
              <svg fill="#FFF" viewBox="-1 4 35 20" version="1.1" xmlns="http://www.w3.org/2000/svg"
                style="width: 40px;height: 20px;">
                <g>
                  <path
                    d="M15.854 11.329l-2.003 9.367h-2.424l2.006-9.367zM26.051 17.377l1.275-3.518 0.735 3.518zM28.754 20.696h2.242l-1.956-9.367h-2.069c-0.003-0-0.007-0-0.010-0-0.459 0-0.853 0.281-1.019 0.68l-0.003 0.007-3.635 8.68h2.544l0.506-1.4h3.109zM22.429 17.638c0.010-2.473-3.419-2.609-3.395-3.714 0.008-0.336 0.327-0.694 1.027-0.785 0.13-0.013 0.28-0.021 0.432-0.021 0.711 0 1.385 0.162 1.985 0.452l-0.027-0.012 0.425-1.987c-0.673-0.261-1.452-0.413-2.266-0.416h-0.001c-2.396 0-4.081 1.275-4.096 3.098-0.015 1.348 1.203 2.099 2.122 2.549 0.945 0.459 1.262 0.754 1.257 1.163-0.006 0.63-0.752 0.906-1.45 0.917-0.032 0.001-0.071 0.001-0.109 0.001-0.871 0-1.691-0.219-2.407-0.606l0.027 0.013-0.439 2.052c0.786 0.315 1.697 0.497 2.651 0.497 0.015 0 0.030-0 0.045-0h-0.002c2.546 0 4.211-1.257 4.22-3.204zM12.391 11.329l-3.926 9.367h-2.562l-1.932-7.477c-0.037-0.364-0.26-0.668-0.57-0.82l-0.006-0.003c-0.688-0.338-1.488-0.613-2.325-0.786l-0.066-0.011 0.058-0.271h4.124c0 0 0.001 0 0.001 0 0.562 0 1.028 0.411 1.115 0.948l0.001 0.006 1.021 5.421 2.522-6.376z">
                  </path>
                </g>
              </svg>
            </span>
          </li>
          <li aria-label="Mastercard" title="Mastercard">
            <span class="pay pay--mc" aria-hidden="true">
              <svg viewBox="0 -3 24 24" xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF"
                style="width: 40px;height: 20px;">
                <g>
                  <path fill="none" d="M0 0h24v24H0z"></path>
                  <path fill-rule="nonzero"
                    d="M12 18.294a7.3 7.3 0 1 1 0-12.588 7.3 7.3 0 1 1 0 12.588zm1.702-1.384a5.3 5.3 0 1 0 0-9.82A7.273 7.273 0 0 1 15.6 12c0 1.89-.719 3.614-1.898 4.91zm-3.404-9.82a5.3 5.3 0 1 0 0 9.82A7.273 7.273 0 0 1 8.4 12c0-1.89.719-3.614 1.898-4.91zM12 8.205A5.284 5.284 0 0 0 10.4 12c0 1.488.613 2.832 1.6 3.795A5.284 5.284 0 0 0 13.6 12 5.284 5.284 0 0 0 12 8.205z">
                  </path>
                </g>
              </svg>
            </span>
          </li>
          <li aria-label="Мир" title="Мир">
            <span class="pay pay--mir" aria-hidden="true">
              <svg height="22px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 780 440" xml:space="preserve" fill="#000000">
                <g transform="translate(-91.000000, -154.000000)">
                  <g transform="translate(91.000000, 154.000000)">
                    <path style="fill: #FFFFFF;"
                      d="M544.1,240.5v108h60v-64h68c28.6-0.2,52.9-18.5,62.1-44H544.1z"></path>
                    <path style="fill: #FFFFFF;"
                      d="M536.1,151.5c3.5,44.1,45.3,79,96.3,79c0.2,0,104.3,0,104.3,0 c0.8-4,1.2-8.2,1.2-12.5c0-36.6-29.5-66.2-66-66.5L536.1,151.5z">
                    </path>
                    <path style="fill: #FFFFFF;"
                      d="M447.3,229.4l0-0.1L447.3,229.4c0.7-1.2,1.8-1.9,3.2-1.9c2,0,3.5,1.6,3.6,3.5l0,0 v116.5h60v-196h-60c-7.6,0.3-16.2,5.8-19.4,12.7L387,266.6c-0.1,0.4-0.3,0.8-0.5,1.2l0,0l0,0c-0.7,1-1.9,1.7-3.3,1.7 c-2.2,0-4-1.8-4-4v-114h-60v196h60v0c7.5-0.4,15.9-5.9,19.1-12.7l49-105.1C447.2,229.6,447.3,229.5,447.3,229.4L447.3,229.4z">
                    </path>
                    <path style="fill: #FFFFFF;"
                      d="M223.3,232.8l-35.1,114.7H145L110,232.7c-0.3-1.8-1.9-3.2-3.9-3.2 c-2.2,0-3.9,1.8-3.9,3.9c0,0,0,0,0,0l0,114h-60v-196h51.5H109c11,0,22.6,8.6,25.8,19.1l29.2,95.5c1.5,4.8,3.8,4.7,5.3,0 l29.2-95.5c3.2-10.6,14.8-19.1,25.8-19.1h15.3h51.5v196h-60v-114c0,0,0,0,0-0.1c0-2.2-1.8-3.9-3.9-3.9 C225.2,229.5,223.6,230.9,223.3,232.8L223.3,232.8z">
                    </path>
                  </g>
                </g>
              </svg>
            </span>
          </li>
        </ul>
      </div>
      <div>
        <span class="footer__muted">Наши соц-сети</span>
        <ul class="footer__social" aria-label="Мы в соцсетях">
          <li>
            <a target="_blank" title="Telegram" class="btn-hover-effect footer__social-link footer__social-link-tg"
              href="https://t.me/mister_packers_bot" aria-label="Telegram">
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24">
                <path
                  d="M9.9 16.2 9.8 19c.4 0 .6-.2.8-.4l1.9-1.8 3.9 2.9c.7.4 1.2.2 1.4-.7l2.6-12c.2-.9-.3-1.3-1.1-1L3.6 9c-.9.3-.9.8-.2 1l4.7 1.5 10.9-6.9-9.1 8.8Z" />
              </svg>
              <span class="visually-hidden">Telegram</span>
            </a>
          </li>
          <li>
            <a target="_blank" title="WhatsApp" class="btn-hover-effect footer__social-link footer__social-link-ws"
              href="https://wa.me/+79154282254" aria-label="WhatsApp">
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24">
                <path
                  d="M20.52 3.48A11.8 11.8 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.17 1.6 5.98L0 24l6.22-1.63A11.9 11.9 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.2-3.48-8.52M12 22a9.9 9.9 0 0 1-5.06-1.37l-.36-.21-3.69.97.99-3.59-.24-.37A9.9 9.9 0 0 1 2 12c0-5.51 4.49-10 10-10 2.67 0 5.18 1.04 7.07 2.93A9.9 9.9 0 0 1 22 12c0 5.51-4.49 10-10 10m5.14-7.44c-.28-.14-1.65-.81-1.9-.9-.25-.1-.43-.14-.61.14-.18.27-.7.9-.86 1.09-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.24-1.41-.83-.74-1.4-1.66-1.56-1.94-.16-.28-.02-.43.12-.57.12-.12.28-.32.42-.48.14-.16.18-.28.28-.46.1-.18.05-.34-.02-.48-.07-.14-.61-1.46-.84-2-.22-.53-.45-.46-.62-.47-.16 0-.34 0-.52 0-.18 0-.48.07-.73.34-.25.27-.96.93-.96 2.26 0 1.33.98 2.61 1.12 2.79.14.18 1.93 3.06 4.65 4.18.65.28 1.16.45 1.55.58.65.21 1.24.18 1.71.11.52-.08 1.57-.64 1.79-1.25.22-.61.22-1.12.16-1.25-.06-.13-.24-.2-.5-.34" />
              </svg>
              <span class="visually-hidden">WhatsApp</span>
            </a>
          </li>
        </ul>
      </div>
      <div>
        <span class="footer__muted">Отзывы Яндекс</span>
        <ul class="footer__social btn-hover-effect" aria-label="Отзывы о нас">
          <li>
            <iframe style="border-radius: 4px;filter: brightness(1.05);"
              src="https://yandex.ru/sprav/widget/rating-badge/142486939387?type=rating" width="150" height="50"
              frameborder="0"></iframe>
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
    <p>&copy; 2008 - <span id="footer-year">{{ date('Y') }}</span> <span itemprop="name">ООО «НУК»</span>. Вся информация,
      размещенная на сайте, носит справочный характер и не является публичной офертой, определяемой положениями ч.2, ст.
      437 Гражданского кодекса РФ. Производитель товаров вправе вносить изменения в описание, внешний вид и комплектацию
      товаров без предварительного уведомления. Администрация сайта стремится предоставлять актуальную информацию
      своевременно, но не исключает возможность ошибок. Уточняйте данные перед оформлением заказа по телефону: 8 800
      550 37 00.</p>
  </div>
</footer>