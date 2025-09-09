@php
    // Конфигурация по умолчанию; можно переопределить через include([...])
    $feedPath = $feedPath ?? resource_path('feeds/yandex_709235.php.xml');
    $wantedCategory = $wantedCategory ?? 'Картонные коробки';
    $limit = isset($limit) ? (int) $limit : 12;

    // Уникальный id для слайдера (на случай нескольких блоков на странице)
    $sliderId = 'feedGallery_' . substr(md5(($feedPath ?? '') . ($wantedCategory ?? '') . ($limit ?? '')), 0, 8) . '_' . random_int(10, 99);

    // Ключ инвалидации по времени + по изменению файла
    $fileMTime = is_file($feedPath) ? filemtime($feedPath) : 0;
    $cacheKeyAll = 'feed_gallery_all_' . md5(($feedPath ?? '') . '|' . ($wantedCategory ?? '')) . '_' . $fileMTime;

    // 1) Парсим фид и кэшируем ПОЛНЫЙ список подходящих товаров на 6 часов
    $allItems = cache()->remember($cacheKeyAll, now()->addHours(6), function () use ($feedPath, $wantedCategory) {
        try {
            if (!is_file($feedPath)) return [];
            $body = @file_get_contents($feedPath);
            if (!$body) return [];

            libxml_use_internal_errors(true);
            $xml = @simplexml_load_string($body);
            if ($xml === false || !isset($xml->shop)) return [];

            // Сбор категорий: id => [name, parentId]
            $categoryName = [];
            $categoryParent = [];
            if (isset($xml->shop->categories->category)) {
                foreach ($xml->shop->categories->category as $cat) {
                    $id = (string) ($cat['id'] ?? '');
                    $name = trim((string) $cat);
                    $parent = (string) ($cat['parentId'] ?? '');
                    if ($id) {
                        $categoryName[$id] = $name;
                        if ($parent) $categoryParent[$id] = $parent;
                    }
                }
            }

            // Находим id корневых категорий, чье имя содержит искомую строку
            $rootIds = [];
            foreach ($categoryName as $id => $name) {
                if ($name !== '' && mb_stripos($name, $wantedCategory) !== false) {
                    $rootIds[$id] = true;
                }
            }
            if (!$rootIds) return [];

            // Собираем множество всех потомков корневых категорий (включая сами корни)
            $targetIds = $rootIds;
            $added = true;
            // Простой обход вниз по parentId
            while ($added) {
                $added = false;
                foreach ($categoryParent as $id => $parentId) {
                    if (isset($targetIds[$parentId]) && !isset($targetIds[$id])) {
                        $targetIds[$id] = true;
                        $added = true;
                    }
                }
            }

            $offers = [];
            if (isset($xml->shop->offers->offer)) {
                foreach ($xml->shop->offers->offer as $offer) {
                    $catId = (string) ($offer->categoryId ?? '');
                    if (!$catId || !isset($targetIds[$catId])) continue;

                    // Первая картинка, если есть
                    $picture = null;
                    if (isset($offer->picture)) {
                        foreach ($offer->picture as $pic) {
                            $src = trim((string) $pic);
                            if ($src) { $picture = $src; break; }
                        }
                    }

                    $offers[] = [
                        'id'         => (string) ($offer['id'] ?? ''),
                        'name'       => trim((string) ($offer->name ?? '')),
                        'url'        => trim((string) ($offer->url ?? '')),
                        'price'      => (string) ($offer->price ?? ''),
                        'currency'   => trim((string) ($offer->currencyId ?? '')),
                        'vendor'     => trim((string) ($offer->vendor ?? '')),
                        'vendorCode' => trim((string) ($offer->vendorCode ?? '')),
                        'available'  => mb_strtolower((string) ($offer['available'] ?? '')),
                        'category'   => $categoryName[$catId] ?? '',
                        'picture'    => $picture,
                    ];
                }
            }

            return $offers;
        } catch (\Throwable $e) {
            return [];
        }
    });

    // 2) Берём случайные товары из кэша и ограничиваем лимитом
    $items = [];
    if (!empty($allItems)) {
        $count = count($allItems);
        if ($count <= $limit) {
            $items = $allItems;
        } else {
            $randKeys = array_rand($allItems, $limit);
            if (!is_array($randKeys)) $randKeys = [$randKeys];
            foreach ($randKeys as $k) {
                $items[] = $allItems[$k];
            }
        }
    }
@endphp

<section id="{{ $sliderId }}" class="feed-gallery main-block" aria-labelledby="{{ $sliderId }}_title">
  <div class="feed-gallery__header">
    <h2 id="{{ $sliderId }}_title">Ассортимент магазина</h2>
    <div class="feed-gallery__controls">
      <button type="button" class="fg-btn fg-prev btn-hover-effect" aria-label="Предыдущие">‹</button>
      <button type="button" class="fg-btn fg-next btn-hover-effect" aria-label="Следующие">›</button>
    </div>
  </div>

  @if(empty($items))
    <p class="text-muted">Товары не найдены или временно недоступны.</p>
  @else
    <div class="fg-viewport">
      <div class="fg-track">
        @foreach($items as $item)
          <article class="product-card btn-hover-effect" role="group">
            <a href="{{ $item['url'] ?: '#' }}" class="product-card__image mb-6" target="_blank" rel="nofollow noopener">
              @if(!empty($item['picture']))
                <img src="{{ $item['picture'] }}" alt="{{ e($item['name'] ?: 'Товар') }}" loading="lazy">
              @else
                <div class="product-card__placeholder">Нет изображения</div>
              @endif
            </a>
            <div class="product-card__body">
              <h3 class="product-card__title line-clamp-2">
                <a href="{{ $item['url'] ?: '#' }}" target="_blank" rel="nofollow noopener">
                  {{ $item['name'] ?: 'Без названия' }}
                </a>
              </h3>
              <div class="">
                @if($item['price'] !== '')
                  <strong class="price font-semibold">{{ number_format((float)$item['price'], 0, ',', ' ') }}</strong>
                  <span class="text-sm text-gray-500">₽/шт</span>
                @endif
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  @endif
</section>

<style>
/* Стили локально, чтобы не трогать глобальные */
.feed-gallery__header{ display:flex; align-items:start; justify-content:space-between; gap:12px; margin-bottom:12px; }
.feed-gallery__controls{ display:flex; gap:8px; }
.fg-btn{ width:36px; height:36px; background:var(--background-color); border-radius: var(--border-inside); font-size:20px; line-height:1; cursor:pointer; }
.fg-btn:disabled{ opacity:.4; cursor:not-allowed; }
.fg-viewport{ overflow-x:hidden; scroll-snap-type:x mandatory; -webkit-overflow-scrolling:touch; }
.fg-track{ display:flex; gap:20px; padding-bottom:4px; }
.product-card{ scroll-snap-align:start; flex:0 0 calc(25% - 15px); overflow:hidden; background:#fff; display:flex; flex-direction:column; transition: box-shadow .2s; }
.product-card__image{ display:block; aspect-ratio:3/3; overflow:hidden; border-radius: var(--border-inside); filter: brightness(0.96)}
.product-card__image img{ width:100%; height:100%; object-fit:cover; display:block; margin-bottom: 10px}
.product-card__placeholder{ width:100%; height:100%; display:grid; place-items:center; color:#aaa; font-size:14px; }
.product-card__body{ display:flex; flex-direction:column; gap:10px; }
.product-card__title{ font-size:16px; line-height:1.3; margin:0; }
.product-card__title a{ text-decoration:none; }

/* Адаптив: 3 / 2 / 1 карточка(и) в кадре */
@media (max-width:1200px){ .product-card{ flex-basis: calc(33.333% - 11px);} }
@media (max-width:768px){  .product-card{ flex-basis: calc(50% - 8px);} }
@media (max-width:480px){  .product-card{ flex-basis: 47%; } }
</style>

<script>
// Небольшой самодостаточный скрипт управления скроллом слайдера
(() => {
  const root = document.getElementById(@json($sliderId));
  if (!root) return;
  const vp = root.querySelector('.fg-viewport');
  const btnPrev = root.querySelector('.fg-prev');
  const btnNext = root.querySelector('.fg-next');
  if (!vp || !btnPrev || !btnNext) return;

  const updateButtons = () => {
    const maxScroll = vp.scrollWidth - vp.clientWidth - 2; // запас
    btnPrev.disabled = vp.scrollLeft <= 2;
    btnNext.disabled = vp.scrollLeft >= maxScroll;
  };

  const step = () => vp.clientWidth; // листаем ширину вьюпорта
  btnPrev.addEventListener('click', () => vp.scrollBy({ left: -step(), behavior: 'smooth' }));
  btnNext.addEventListener('click', () => vp.scrollBy({ left:  step(), behavior: 'smooth' }));
  vp.addEventListener('scroll', updateButtons, { passive: true });
  window.addEventListener('resize', updateButtons);
  updateButtons();
})();
</script>

