@php
    // Параметры (можно переопределить перед @include)
    $feedUrl = $feedUrl ?? 'https://mp.market/bitrix/catalog_export/yandex_709235.php';
    $wantedCategory = $wantedCategory ?? 'Самосборные коробки';
    $limit = isset($limit) ? (int)$limit : 12;

    $items = cache()->remember('yml_self_assembled_' . md5($feedUrl.$wantedCategory) . "_$limit", now()->addHours(6), function () use ($feedUrl, $wantedCategory, $limit) {
        $offers = [];

        try {
            $ctx = stream_context_create([
                'http' => ['timeout' => 12, 'ignore_errors' => true],
                'ssl'  => ['verify_peer' => true, 'verify_peer_name' => true],
            ]);
            $body = @file_get_contents($feedUrl, false, $ctx);
            if (!$body) return [];

            libxml_use_internal_errors(true);
            $xml = @simplexml_load_string(trim($body));
            if ($xml === false) return [];

            // Карта категорий: id => name
            $categoryMap = [];
            if (isset($xml->shop->categories->category)) {
                foreach ($xml->shop->categories->category as $cat) {
                    $id = (string)($cat['id'] ?? '');
                    $name = trim((string)$cat);
                    if ($id && $name) $categoryMap[$id] = $name;
                }
            }

            // Ищем id категорий, чьё имя содержит искомую фразу
            $targetIds = [];
            foreach ($categoryMap as $id => $name) {
                if (mb_stripos($name, $wantedCategory) !== false) {
                    $targetIds[] = $id;
                }
            }
            if (!$targetIds) return [];

            if (isset($xml->shop->offers->offer)) {
                foreach ($xml->shop->offers->offer as $offer) {
                    $catId = (string)($offer->categoryId ?? '');
                    if (!in_array($catId, $targetIds, true)) continue;

                    // Картинки: берём первую
                    $picture = null;
                    if (isset($offer->picture)) {
                        foreach ($offer->picture as $pic) {
                            $src = trim((string)$pic);
                            if ($src) { $picture = $src; break; }
                        }
                    }

                    $offers[] = [
                        'id'         => (string)($offer['id'] ?? ''),
                        'name'       => trim((string)($offer->name ?? '')),
                        'url'        => trim((string)($offer->url ?? '')),
                        'price'      => (string)($offer->price ?? ''),
                        'currency'   => trim((string)($offer->currencyId ?? '')),
                        'vendor'     => trim((string)($offer->vendor ?? '')),
                        'vendorCode' => trim((string)($offer->vendorCode ?? '')),
                        'available'  => mb_strtolower((string)($offer['available'] ?? '')),
                        'category'   => $categoryMap[$catId] ?? '',
                        'picture'    => $picture,
                    ];

                    if (count($offers) >= $limit) break;
                }
            }

            return $offers;
        } catch (\Throwable $e) {
            return [];
        }
    });
@endphp

<section class="service-block" aria-labelledby="self-assembled-title">
  <div class="service-block__header">
    <h2 id="self-assembled-title">Самосборные коробки</h2>
    <p class="service-block__desc">Первые {{ $limit }} позиций из каталога (фид кэшируется на 6 часов).</p>
  </div>

  @if(empty($items))
    <p class="text-muted">Нет товаров для отображения.</p>
  @else
    <div class="cards-grid">
      @foreach($items as $item)
        <article class="product-card">
          <a href="{{ $item['url'] ?: '#' }}" class="product-card__image" target="_blank" rel="nofollow noopener">
            @if($item['picture'])
              <img src="{{ $item['picture'] }}" alt="{{ e($item['name'] ?: 'Товар') }}">
            @else
              <div class="product-card__placeholder">Нет изображения</div>
            @endif
          </a>

          <div class="product-card__body">
            <h3 class="product-card__title">
              <a href="{{ $item['url'] ?: '#' }}" target="_blank" rel="nofollow noopener">
                {{ $item['name'] ?: 'Товар без названия' }}
              </a>
            </h3>

            <div class="product-card__meta">
              @if($item['vendor'])<span class="product-card__vendor">{{ $item['vendor'] }}</span>@endif
              @if($item['vendorCode'])<span class="product-card__sku">Артикул: {{ $item['vendorCode'] }}</span>@endif
              @if($item['category'])<span class="product-card__cat">{{ $item['category'] }}</span>@endif
            </div>

            <div class="product-card__price">
              @if($item['price'] !== '')
                <strong class="price">{{ number_format((float)$item['price'], 0, ',', ' ') }}</strong>
                <span class="currency">{{ $item['currency'] }}</span>
              @else
                <span class="price-unset">Цена по запросу</span>
              @endif
            </div>

            @php
              $isAvailable = in_array($item['available'], ['true','1','да','yes'], true);
            @endphp
            <div class="product-card__footer">
              <span class="product-card__avail {{ $isAvailable ? 'is-yes':'is-no' }}">
                {{ $isAvailable ? 'В наличии' : 'Под заказ' }}
              </span>
              <a class="product-card__btn" href="{{ $item['url'] ?: '#' }}" target="_blank" rel="nofollow noopener">
                Открыть
              </a>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  @endif
</section>

<style>
/* Минималистичный стиль, можно перенести в app.css */
.service-block { padding: 24px 0; }
.service-block__header h2 { font-size: 26px; margin: 0 0 8px; }
.service-block__desc { color: #777; margin: 0 0 20px; }
.cards-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 16px; }
@media (max-width:1200px){ .cards-grid{ grid-template-columns: repeat(8,1fr);} }
@media (max-width:768px){ .cards-grid{ grid-template-columns: repeat(4,1fr);} }
@media (max-width:480px){ .cards-grid{ grid-template-columns: repeat(2,1fr);} }
.product-card { grid-column: span 3; border: 1px solid #e6e6e6; border-radius: 12px; overflow: hidden; background:#fff; display:flex; flex-direction:column; transition: box-shadow .2s; }
.product-card:hover { box-shadow: 0 6px 22px rgba(0,0,0,.08); }
.product-card__image{ display:block; aspect-ratio:4/3; background:#f7f7f7; overflow:hidden; }
.product-card__image img{ width:100%; height:100%; object-fit:cover; }
.product-card__placeholder{ width:100%; height:100%; display:grid; place-items:center; color:#aaa; font-size:14px; }
.product-card__body{ padding:12px 14px 14px; display:flex; flex-direction:column; gap:8px; }
.product-card__title{ font-size:16px; line-height:1.3; margin:0; }
.product-card__title a{ color:#111; text-decoration:none; }
.product-card__title a:hover{ text-decoration:underline; }
.product-card__meta{ display:flex; flex-wrap:wrap; gap:8px; color:#666; font-size:13px; }
.product-card__vendor::before, .product-card__sku::before, .product-card__cat::before{ content:'•'; margin:0 6px 0 2px; color:#ccc; }
.product-card__vendor::before{ content:''; margin:0; }
.product-card__price{ font-size:18px; }
.product-card__price .price{ font-weight:700; }
.product-card__price .currency{ margin-left:6px; font-size:14px; color:#666; }
.price-unset{ color:#999; }
.product-card__footer{ display:flex; align-items:center; justify-content:space-between; margin-top:8px; }
.product-card__avail{ font-size:13px; }
.product-card__avail.is-yes{ color:#2f9e44; }
.product-card__avail.is-no{ color:#c92a2a; }
.product-card__btn{ display:inline-block; padding:8px 12px; border-radius:10px; border:1px solid #111; text-decoration:none; color:#111; font-weight:600; font-size:14px; }
.product-card__btn:hover{ background:#111; color:#fff; }
</style>
