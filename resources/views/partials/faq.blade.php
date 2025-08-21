<!-- FAQ Accordion: нативно доступный, без JSON-LD и без JS -->
<section id="faq" aria-labelledby="faq-heading">
  <div class="faq-wrap">
    <h2 id="faq-heading">Частые вопросы</h2>

    <details class="faq-item" open>
      <summary>
        <span class="q">Как оформить заказ?</span>
        <span class="faq-icon" aria-hidden="true"></span>
      </summary>
      <div class="faq-content">
        <p>Выберите конструкцию и укажите размеры, тираж и опции. После расчёта добавьте позицию в корзину и заполните контакты — система создаст номер и ссылку на заказ.</p>
        <ul>
          <li>Нестандартные размеры возможны — надбавка считается автоматически.</li>
          <li>Файлы (логотип/макет) можно загрузить сразу или позже на странице заказа.</li>
        </ul>
      </div>
    </details>

    <details class="faq-item">
      <summary>
        <span class="q">Сроки и доставка</span>
        <span class="faq-icon" aria-hidden="true"></span>
      </summary>
      <div class="faq-content">
        <p>Производство: 2–7 рабочих дней (зависит от тиража и опций). Доставка по России курьером/ТК, самовывоз — по согласованию.</p>
        <p>Итоговые сроки и стоимость доставки считаются при оформлении заказа после указания адреса.</p>
      </div>
    </details>

    <details class="faq-item">
      <summary>
        <span class="q">Оплата</span>
        <span class="faq-icon" aria-hidden="true"></span>
      </summary>
      <div class="faq-content">
        <p>Оплата для физлиц и юрлиц/ИП. Счёт и закрывающие формируются автоматически. Онлайн-оплата картой — после подтверждения заказа.</p>
      </div>
    </details>

    <details class="faq-item">
      <summary>
        <span class="q">Макет и печать</span>
        <span class="faq-icon" aria-hidden="true"></span>
      </summary>
      <div class="faq-content">
        <p>Загрузите логотип/макет (SVG/PNG/PDF) в конфигураторе или позже. Для полноцветной печати цена согласуется после проверки файла.</p>
        <p>Требования: поля 5 мм, шрифты в кривых, профиль CMYK.</p>
      </div>
    </details>
  </div>

  <style>
    /* layout */
    #faq .faq-wrap { max-width: 800px; margin: 0 auto; padding: 24px 16px; }
    #faq h2 { font-size: 1.75rem; line-height: 1.2; margin: 0 0 16px; }

    /* items */
    #faq .faq-item { border: 1px solid #e5e7eb; border-radius: 10px; background: #fff; }
    #faq .faq-item + .faq-item { margin-top: 10px; }

    /* summary (кнопка) */
    #faq summary {
      list-style: none; /* убрать маркер */
      display: flex; align-items: center; justify-content: space-between; gap: 12px;
      padding: 14px 16px; cursor: pointer; font-weight: 600;
    }
    #faq summary::-webkit-details-marker { display: none; } /* скрыть дефолтный треугольник */
    #faq summary:focus-visible { outline: 2px solid #2563eb; outline-offset: 2px; border-radius: 8px; }

    #faq .q { line-height: 1.35; }

    /* иконка: плюс -> минус */
    #faq .faq-icon::before {
      content: "+"; display: inline-block;
      font-size: 1.25rem; line-height: 1; width: 1em; text-align: center;
    }
    #faq details[open] .faq-icon::before { content: "–"; }

    /* контент */
    #faq .faq-content { padding: 0 16px 14px; color: #374151; }
    #faq .faq-content p { margin: 0 0 10px; }
    #faq .faq-content ul { margin: 0 0 10px 18px; }

    /* темная тема (если есть) */
    @media (prefers-color-scheme: dark) {
      #faq .faq-item { background: #0b0f14; border-color: #30363d; }
      #faq .faq-content { color: #cdd9e5; }
    }
  </style>
</section>
