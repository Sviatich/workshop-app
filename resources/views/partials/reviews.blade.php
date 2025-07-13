<section class="reviews" role="region" aria-label="Отзывы клиентов">
    <div class="reviews-container">
      <div class="reviews-card">
        <h2 class="reviews-title">Что говорят наши клиенты</h2>
  
        <div class="reviews-marquee">
          <div class="reviews-track">
            <!-- Отзывы — повторяются дважды для зацикливания -->
            @for ($i = 0; $i < 2; $i++)
              <div class="review-item">
                <p class="review-text">Отличная упаковка — быстро доставили, качество на высоте!</p>
                <span class="review-author">— Анна, Wildberries</span>
              </div>
              <div class="review-item">
                <p class="review-text">Уже 3 раза заказывали — каждый раз всё чётко. Спасибо!</p>
                <span class="review-author">— Дмитрий, Ozon</span>
              </div>
              <div class="review-item">
                <p class="review-text">Очень стильные коробки. Упаковываем подарки — клиенты довольны.</p>
                <span class="review-author">— Лена, Telegram-магазин</span>
              </div>
            @endfor
          </div>
        </div>
  
      </div>
    </div>
  </section>