@php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Http;

    $limit = 12;
    $wantedCategoryId = '1431'; // Картонные коробки
    $carouselId = 'yfeed_' . uniqid();

    $offers = Cache::remember(
        "ym_feed_gallery_cat_{$wantedCategoryId}_limit_{$limit}",
        now()->addMinutes(30),
        function () use ($limit, $wantedCategoryId) {
            try {
                $resp = Http::timeout(8)->get('https://mp.market/bitrix/catalog_export/yandex_709235.php');
                if (!$resp->ok()) return [];

                $xml = @simplexml_load_string($resp->body());
                if (!$xml || empty($xml->shop->offers->offer)) return [];

                $items = [];
                foreach ($xml->shop->offers->offer as $offer) {
                    $catId = (string)($offer->categoryId ?? '');
                    if ($catId !== $wantedCategoryId) {
                        continue; // только нужная категория
                    }

                    $items[] = [
                        'id'          => (string)($offer['id'] ?? ''),
                        'available'   => (string)($offer['available'] ?? ''),
                        'name'        => (string)($offer->name ?? $offer->model ?? ''),
                        'price'       => (string)($offer->price ?? ''),
                        'currency'    => (string)($offer->currencyId ?? ''),
                        'url'         => (string)($offer->url ?? ''),
                        'picture'     => (string)($offer->picture[0] ?? ''),
                        'vendor'      => (string)($offer->vendor ?? ''),
                        'description' => trim(strip_tags((string)($offer->description ?? ''))),
                    ];

                    if (count($items) >= $limit) {
                        break; // берём первые 12
                    }
                }

                return $items;
            } catch (\Throwable $e) {
                return [];
            }
        }
    );
@endphp

@if(!empty($offers))
<section class="yfeed-wrapper">
    <div class="yfeed-header">
        <h2 class="yfeed-title">Картонные коробки</h2>
        <div class="yfeed-controls">
            <button class="yfeed-btn" type="button" data-dir="-1" aria-label="Предыдущие" data-for="{{ $carouselId }}">‹</button>
            <button class="yfeed-btn" type="button" data-dir="1" aria-label="Следующие" data-for="{{ $carouselId }}">›</button>
        </div>
</div>

    <div id="{{ $carouselId }}" class="yfeed-viewport">
        <div class="yfeed-track">
            @foreach($offers as $o)
                <a class="ycard" href="{{ $o['url'] }}" target="_blank" rel="nofollow noopener" title="{{ $o['name'] }}">
                    <div class="ycard-media">
                        @if(!empty($o['picture']))
                            <img loading="lazy" src="{{ $o['picture'] }}" alt="{{ $o['name'] }}">
                        @else
                            <div class="ycard-ph">Нет изображения</div>
                        @endif
                    </div>

                    <div class="ycard-body">
                        <div class="ycard-title">{{ $o['name'] ?: ('Товар #'.$o['id']) }}</div>

                        @if(!empty($o['vendor']))
                            <div class="ycard-vendor">{{ $o['vendor'] }}</div>
                        @endif

                        @if($o['price'] !== '')
                            <div class="ycard-price">
                                {{ number_format((float)$o['price'], 0, ',', ' ') }}
                                <span class="ycard-curr">{{ $o['currency'] }}</span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<style>
    .yfeed-wrapper { margin: 24px 0; }
    .yfeed-header {
        display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px;
    }
    .yfeed-title { font-size:1.25rem; font-weight:700; margin:0; }
    .yfeed-controls { display:flex; gap:8px; }
    .yfeed-btn {
        display:inline-flex; align-items:center; justify-content:center;
        width:36px; height:36px; border:1px solid #e5e7eb; border-radius:8px;
        background:#fff; cursor:pointer; font-size:20px; line-height:1;
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .yfeed-btn:hover { transform:translateY(-1px); box-shadow:0 2px 6px rgba(0,0,0,.06); }
    .yfeed-viewport { overflow:hidden; position:relative; }
    .yfeed-track {
        display:flex; gap:12px; scroll-behavior:smooth;
        overflow:auto; scrollbar-width:none; -ms-overflow-style:none;
        scroll-snap-type:x mandatory; padding-bottom:2px;
    }
    .yfeed-track::-webkit-scrollbar { display:none; }

    .ycard {
        flex:0 0 calc(25% - 9px); max-width:calc(25% - 9px);
        display:flex; flex-direction:column; text-decoration:none; color:inherit;
        border:1px solid #e5e7eb; border-radius:12px; background:#fff;
        transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
        scroll-snap-align:start;
    }
    .ycard:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,.08); border-color:#d1d5db; }

    .ycard-media {
        height:180px; display:flex; align-items:center; justify-content:center;
        padding:8px; border-bottom:1px solid #f3f4f6; background:#fff;
        border-top-left-radius:12px; border-top-right-radius:12px; overflow:hidden;
    }
    .ycard-media img { max-width:100%; max-height:100%; object-fit:contain; display:block; }
    .ycard-ph { font-size:.875rem; color:#6b7280; }

    .ycard-body { padding:10px 12px 12px; display:flex; flex-direction:column; gap:6px; }
    .ycard-title { font-weight:600; font-size:.95rem; line-height:1.25; max-height:2.5em; overflow:hidden; }
    .ycard-vendor { font-size:.8rem; color:#6b7280; }
    .ycard-price { font-size:1.05rem; font-weight:700; }
    .ycard-curr { font-weight:500; font-size:.9rem; color:#4b5563; margin-left:4px; }

    @media (max-width:1200px) {
        .ycard { flex-basis:calc(33.333% - 8px); max-width:calc(33.333% - 8px); }
    }
    @media (max-width:900px) {
        .ycard { flex-basis:calc(50% - 6px); max-width:calc(50% - 6px); }
        .ycard-media { height:160px; }
    }
    @media (max-width:560px) {
        .ycard { flex-basis:85%; max-width:85%; }
        .ycard-media { height:150px; }
    }
</style>

<script>
    (function(){
        const buttons = document.querySelectorAll('.yfeed-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const dir = Number(btn.dataset.dir || 1);
                const id = btn.dataset.for;
                const viewport = document.getElementById(id);
                if (!viewport) return;
                const track = viewport.querySelector('.yfeed-track');
                const card = track.querySelector('.ycard');
                const step = card ? (card.getBoundingClientRect().width + 12) : (viewport.clientWidth * 0.9);
                track.scrollBy({ left: dir * step, behavior: 'smooth' });
            });
        });
    })();
</script>
@else
<section class="yfeed-wrapper">
    <div class="yfeed-header">
        <h2 class="yfeed-title">Картонные коробки</h2>
    </div>
    <p class="text-gray-600">Не удалось загрузить товары из нужной категории.</p>
</section>
@endif
