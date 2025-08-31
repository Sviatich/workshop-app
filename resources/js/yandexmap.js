document.addEventListener('DOMContentLoaded', () => {
  const mapEl = document.getElementById('map');
  if (!mapEl) return; // нет карты — ничего не делаем

  const keyMeta = document.querySelector('meta[name="yandex-maps-api-key"]');
  const apiKey = keyMeta?.content?.trim();
  if (!apiKey) {
    console.warn('YANDEX_MAPS_API_KEY не задан. Карта не будет инициализирована.');
    return;
  }

  const loadYMaps = () => new Promise((resolve, reject) => {
    if (window.ymaps3?.ready) return resolve();
    const s = document.createElement('script');
    s.src = `https://api-maps.yandex.ru/v3/?apikey=${encodeURIComponent(apiKey)}&lang=ru_RU`;
    s.async = true;
    s.onload = () => resolve();
    s.onerror = () => reject(new Error('Не удалось загрузить Яндекс.Карты'));
    document.head.appendChild(s);
  });

  (async () => {
    try {
      await loadYMaps();
      await window.ymaps3.ready;
      const { YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapMarker } = window.ymaps3;

      const coords = [38.374602, 55.989067];

      const map = new YMap(mapEl, {
        location: { center: coords, zoom: 15 }
      });

      map.addChild(new YMapDefaultSchemeLayer());
      map.addChild(new YMapDefaultFeaturesLayer());

      const markerEl = document.createElement('div');
      markerEl.className = 'custom-marker';
      markerEl.title = 'Производство упаковки';

      map.addChild(new YMapMarker({ coordinates: coords }, markerEl));
    } catch (e) {
      console.error(e);
    }
  })();
});

