<section class="main-hero">
    <div class="hero-col">
        <div class="flex gap-4 mb-4">
            <a href="https://yandex.ru/profile/142486939387?lang=ru" target="_blank"
                class="flex gap-3 main-hero-rating btn-hover-effect"><img width="17px" src="{{ Vite::asset('resources/images/yandex.svg') }}"
                    alt="Yandex"> 5,0</a>
            <a href="https://go.2gis.com/ADktq" target="_blank" class="btn-hover-effect flex gap-3 main-hero-rating"><img
                    width="17px" src="{{ Vite::asset('resources/images/2gis.svg') }}" alt="2GIS"> 5,0</a>
            <a href="https://share.google/VN8Sj9bebDXzbaaAn" target="_blank" class="btn-hover-effect flex gap-3 main-hero-rating"><img
                    width="17px" src="{{ Vite::asset('resources/images/google.svg') }}" alt="Google"> 5,0</a>
        </div>
        <h1 class="main-h1 mb-4">
            Создайте короб для <br>вашего товара за <br>несколько кликов
        </h1>
        <div class="hero-content">
            <p>Выберите параметры, загрузите дизайн или логотип — мы изготовим и доставим готовую коробку в срок.</p>
        </div>
        <div class="flex gap-4">
            <a href="#configurator" class="main-hero-button btn-hover-effect">Калькулятор</a>
            <a target="_blank" title="Telegram" class="btn-hover-effect hero__social-link footer__social-link footer__social-link-tg"
                href="https://t.me/mister_packers_bot" aria-label="Telegram"><span class="hero__social-link-title">Телеграм </span>
                <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24">
                    <path
                        d="M9.9 16.2 9.8 19c.4 0 .6-.2.8-.4l1.9-1.8 3.9 2.9c.7.4 1.2.2 1.4-.7l2.6-12c.2-.9-.3-1.3-1.1-1L3.6 9c-.9.3-.9.8-.2 1l4.7 1.5 10.9-6.9-9.1 8.8Z" />
                </svg>
                <span class="visually-hidden">Telegram</span>
            </a>
            <a target="_blank" title="WhatsApp" class="btn-hover-effect hero__social-link footer__social-link footer__social-link-ws"
              href="https://wa.me/+79154282254" aria-label="WhatsApp"><span class="hero__social-link-title">WhatsApp </span>
              <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24">
                <path
                  d="M20.52 3.48A11.8 11.8 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.17 1.6 5.98L0 24l6.22-1.63A11.9 11.9 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.2-3.48-8.52M12 22a9.9 9.9 0 0 1-5.06-1.37l-.36-.21-3.69.97.99-3.59-.24-.37A9.9 9.9 0 0 1 2 12c0-5.51 4.49-10 10-10 2.67 0 5.18 1.04 7.07 2.93A9.9 9.9 0 0 1 22 12c0 5.51-4.49 10-10 10m5.14-7.44c-.28-.14-1.65-.81-1.9-.9-.25-.1-.43-.14-.61.14-.18.27-.7.9-.86 1.09-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.24-1.41-.83-.74-1.4-1.66-1.56-1.94-.16-.28-.02-.43.12-.57.12-.12.28-.32.42-.48.14-.16.18-.28.28-.46.1-.18.05-.34-.02-.48-.07-.14-.61-1.46-.84-2-.22-.53-.45-.46-.62-.47-.16 0-.34 0-.52 0-.18 0-.48.07-.73.34-.25.27-.96.93-.96 2.26 0 1.33.98 2.61 1.12 2.79.14.18 1.93 3.06 4.65 4.18.65.28 1.16.45 1.55.58.65.21 1.24.18 1.71.11.52-.08 1.57-.64 1.79-1.25.22-.61.22-1.12.16-1.25-.06-.13-.24-.2-.5-.34" />
              </svg>
              <span class="visually-hidden">WhatsApp</span>
            </a>
        </div>
    </div>
    <div class="hero-stream" aria-hidden="true">
        <video autoplay muted playsinline loop class="static hero-image">
            <source src="{{ Vite::asset('resources/videos/production-video.webm') }}" type="video/webm">
        </video>
    </div>
</section>
