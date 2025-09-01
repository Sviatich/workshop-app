import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
  const el = (id) => document.getElementById(id);
  const show = (node, visible) => node && node.classList.toggle('hidden', !visible);
  const bySel = (sel) => document.querySelector(sel);

  const cdekBlock = el('cdek_block');
  if (!cdekBlock) return;
  const oldBtn = el('open-cdek');
  if (oldBtn) oldBtn.style.display = 'none';

  const summaryEl = el('delivery_summary');
  const deliveryAddress = el('delivery_address');
  const methodCode = el('delivery_method_code');
  const methodId = el('delivery_method_id');
  const priceEl = el('delivery_row_value');
  const priceHidden = el('delivery_price_input');
  const yaKey = document.querySelector('meta[name="yandex-maps-api-key"]')?.content?.trim();
  const dadataToken = document.querySelector('meta[name="dadata-token"]')?.content?.trim();

  const lsGet = (k, d=null)=>{ try { return JSON.parse(localStorage.getItem(k) ?? 'null') ?? d } catch { return d } };
  const lsSet = (k,v)=>{ try { localStorage.setItem(k, JSON.stringify(v)) } catch {} };

  const setDeliveryCode = (code) => {
    if (methodCode) methodCode.value = code;
    if (methodId && code) {
      const opt = Array.from(methodId.options).find(o => (o.dataset?.code) === code);
      if (opt) methodId.value = opt.value;
    }
  };

  const setDeliveryPrice = (val) => {
    const p = Number(val) || 0;
    if (priceEl) priceEl.textContent = p.toFixed(2);
    if (priceHidden) priceHidden.value = p.toFixed(2);
    try { window.dispatchEvent(new CustomEvent('cart:updated')); } catch {}
  };

  // Build parcels from cart in localStorage (same logic as widget)
  function calcParcels() {
    let cart = [];
    try { cart = JSON.parse(localStorage.getItem('cart') || '[]') } catch {}
    const MIN_SIDE_MM = 100; // 10cm
    const MIN_HEIGHT_MM = 10; // 1cm
    const MAX_SIDE_MM = 1500; // 150cm
    const MAX_PARCEL_WEIGHT_G = 25000; // 25kg
    const MIN_WEIGHT_G = 100; // 0.1kg per unit

    const units = [];
    for (const item of cart) {
      const tirage = Math.max(1, Number(item.tirage) || 1);
      let L = Number(item.parcel_length_mm);
      let W = Number(item.parcel_width_mm);
      let unitH = Number(item.parcel_unit_height_mm);
      if (!Number.isFinite(L) || L <= 0) L = MIN_SIDE_MM;
      if (!Number.isFinite(W) || W <= 0) W = MIN_SIDE_MM;
      if (!Number.isFinite(unitH) || unitH <= 0) unitH = 1.5;
      L = Math.min(MAX_SIDE_MM, Math.max(MIN_SIDE_MM, Math.round(L)));
      W = Math.min(MAX_SIDE_MM, Math.max(MIN_SIDE_MM, Math.round(W)));
      const totalItemWeightKg = Math.max(0, Number(item.weight) || 0);
      const unitWeightG = Math.max(MIN_WEIGHT_G, Math.round((totalItemWeightKg / tirage) * 1000));
      for (let i = 0; i < tirage; i++) {
        units.push({ L, W, h: unitH, g: unitWeightG });
      }
    }

    const parcels = [];
    let current = null;
    for (const u of units) {
      if (!current) current = { length: u.L, width: u.W, height: 0, weight: 0 };
      const nextW = current.weight + u.g;
      const nextH = current.height + u.h;
      if (nextW > MAX_PARCEL_WEIGHT_G || nextH > MAX_SIDE_MM) {
        if (current.weight > 0) {
          current.length = Math.max(MIN_SIDE_MM, Math.round(current.length));
          current.width  = Math.max(MIN_SIDE_MM, Math.round(current.width));
          current.height = Math.max(MIN_HEIGHT_MM, Math.round(current.height));
          parcels.push(current);
        }
        current = { length: u.L, width: u.W, height: 0, weight: 0 };
      }
      current.length = Math.max(current.length, u.L);
      current.width  = Math.max(current.width, u.W);
      current.height = current.height + u.h;
      current.weight = current.weight + u.g;
    }
    if (current && current.weight > 0) {
      current.length = Math.max(MIN_SIDE_MM, Math.round(current.length));
      current.width  = Math.max(MIN_SIDE_MM, Math.round(current.width));
      current.height = Math.max(MIN_HEIGHT_MM, Math.round(current.height));
      parcels.push(current);
    }
    return parcels.map(p => ({
      length: Math.max(1, Math.ceil(p.length / 10)),
      width:  Math.max(1, Math.ceil(p.width  / 10)),
      height: Math.max(1, Math.ceil(p.height / 10)),
      weight: Math.max(1, Math.round(p.weight)),
    }));
  }

  const officeWrap = el('cdek_office_wrap');
  const doorWrap = el('cdek_door_wrap');
  const typeRadios = document.querySelectorAll('input[name="cdek_type"]');
  const cityInput = el('cdek_city_query');
  const citySuggest = el('cdek_city_suggest');
  const officeSelect = el('cdek_office_select');
  const calcOfficeBtn = el('cdek_calc_office');
  const calcDoorBtn = el('cdek_calc_door');
  const mapOfficeEl = el('cdek_map');
  const mapDoorEl = el('cdek_map_door');
  const addrInput = el('cdek_address');
  const addrSuggest = el('cdek_addr_suggest');
  const postalHidden = document.getElementById('cdek_postal_code');

  // Yandex Maps v3 loader
  let ymapsReady = null;
  const loadYMaps = () => {
    if (window.ymaps3?.ready) return Promise.resolve();
    if (ymapsReady) return ymapsReady;
    if (!yaKey) return Promise.reject(new Error('YANDEX_MAPS_API_KEY missing'));
    ymapsReady = new Promise((resolve, reject) => {
      const s = document.createElement('script');
      s.src = `https://api-maps.yandex.ru/v3/?apikey=${encodeURIComponent(yaKey)}&lang=ru_RU`;
      s.async = true; s.onload = resolve; s.onerror = () => reject(new Error('Yandex Maps load error'));
      document.head.appendChild(s);
    });
    return ymapsReady;
  };

  // Maps state
  let officeMap = null; let officeMarkers = [];
  let doorMap = null; let doorMarker = null; let doorMapClickBound = false;

  const initOfficeMap = async () => {
    if (!mapOfficeEl) return;
    try { await loadYMaps(); await window.ymaps3.ready; } catch { return; }
    if (officeMap) return;
    const { YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer } = window.ymaps3;
    officeMap = new YMap(mapOfficeEl, { location: { center: [37.617635, 55.755814], zoom: 9 } });
    officeMap.addChild(new YMapDefaultSchemeLayer());
    officeMap.addChild(new YMapDefaultFeaturesLayer());
  };
  const createMarkerEl = (title='') => { const e=document.createElement('div'); e.className='custom-marker'; e.title=title; return e; };
  const setOfficeMarkers = async (offices=[]) => {
    if (!mapOfficeEl) return;
    try { await initOfficeMap(); } catch {}
    const { YMapMarker } = window.ymaps3;
    // Clear old markers
    officeMarkers.forEach(m => { try { officeMap.removeChild(m) } catch {} });
    officeMarkers = [];
    // Bounds
    let minLon=180, minLat=90, maxLon=-180, maxLat=-90;
    (offices || []).forEach(o => {
      if (o.lon==null || o.lat==null) return;
      minLon = Math.min(minLon, o.lon); maxLon = Math.max(maxLon, o.lon);
      minLat = Math.min(minLat, o.lat); maxLat = Math.max(maxLat, o.lat);
      const markerEl = createMarkerEl(o.name || 'ПВЗ');
      markerEl.style.cursor = 'pointer';
      markerEl.addEventListener('click', () => {
        // select option in dropdown
        if (officeSelect) {
          officeSelect.value = o.code || '';
          officeSelect.dispatchEvent(new Event('change', { bubbles: true }));
        }
        // brief hint in summary
        if (summaryEl) summaryEl.textContent = `ПВЗ: ${o.address || ''}`;
      });
      const marker = new YMapMarker({ coordinates: [o.lon, o.lat] }, markerEl);
      officeMarkers.push(marker); officeMap.addChild(marker);
    });
    if (officeMarkers.length>0 && minLon <= maxLon && minLat <= maxLat) {
      try { officeMap.update({ location: { bounds: [[minLon, minLat], [maxLon, maxLat]] } }); } catch {}
    }
  };

  const setDoorMarker = async (lon, lat) => {
    if (!mapDoorEl || lon==null || lat==null) return;
    try { await loadYMaps(); await window.ymaps3.ready; } catch { return; }
    const { YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapMarker, YMapListener } = window.ymaps3;
    if (!doorMap) {
      doorMap = new YMap(mapDoorEl, { location: { center: [lon, lat], zoom: 13 } });
      doorMap.addChild(new YMapDefaultSchemeLayer());
      doorMap.addChild(new YMapDefaultFeaturesLayer());
      if (!doorMapClickBound && YMapListener) {
        doorMapClickBound = true;
        const listener = new YMapListener({
          onClick: async (e) => {
            try {
              const coords = e.coordinates || e.worldCoordinates || e.position || [];
              const clon = Number(coords[0]); const clat = Number(coords[1]);
              if (!Number.isFinite(clon) || !Number.isFinite(clat)) return;
              await setDoorMarker(clon, clat);
              if (dadataToken) {
                const { data } = await axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address',
                  { lat: clat, lon: clon, count: 1 }, { headers: { 'Authorization': `Token ${dadataToken}`, 'Content-Type': 'application/json' } });
                const sug = data?.suggestions?.[0];
                if (sug) {
                  if (addrInput) addrInput.value = sug.value || sug.unrestricted_value || '';
                  if (postalHidden) postalHidden.value = sug.data?.postal_code || '';
                }
              }
            } catch {}
          }
        });
        try { doorMap.addChild(listener); } catch {}
      }
    } else {
      try { doorMap.update({ location: { center: [lon, lat], zoom: 13 } }); } catch {}
    }
    if (doorMarker) { try { doorMap.removeChild(doorMarker) } catch {} doorMarker = null; }
    const markerEl = createMarkerEl('Адрес доставки');
    doorMarker = new window.ymaps3.YMapMarker({ coordinates: [lon, lat] }, markerEl);
    doorMap.addChild(doorMarker);
  };

  // Toggle office/door UI
  const syncType = () => {
    const type = bySel('input[name="cdek_type"]:checked')?.value || 'office';
    show(officeWrap, type === 'office');
    show(doorWrap, type === 'door');
    // ensure door map is initialized for click-to-select
    if (type === 'door' && !doorMap) {
      setDoorMarker(37.617635, 55.755814); // Moscow center as default
    }
  };
  typeRadios.forEach(r => r.addEventListener('change', syncType));
  syncType();

  function debounce(fn, t=300){ let h; return (...a)=>{ clearTimeout(h); h=setTimeout(()=>fn(...a), t) } }

  // City typeahead
  const onCityInput = debounce(async () => {
    const q = (cityInput?.value || '').trim();
    if (!q || !citySuggest) { if (citySuggest) citySuggest.classList.add('hidden'); return; }
    try {
      const { data } = await axios.get('/api/cdek/cities', { params: { query: q } });
      citySuggest.innerHTML = '';
      (data || []).forEach(c => {
        const li = document.createElement('li');
        li.className = 'p-2 hover:bg-gray-100 cursor-pointer';
        li.textContent = c.full_name || c.city || '';
        li.dataset.code = c.code;
        li.addEventListener('click', async () => {
          cityInput.value = li.textContent;
          cityInput.dataset.code = String(c.code);
          citySuggest.classList.add('hidden');
          // load offices for city
          await loadOffices(c.code);
        });
        citySuggest.appendChild(li);
      });
      citySuggest.classList.toggle('hidden', !(Array.isArray(data) && data.length > 0));
    } catch (e) {
      citySuggest.classList.add('hidden');
    }
  }, 400);
  if (cityInput) cityInput.addEventListener('input', onCityInput);

  async function loadOffices(cityCode){
    try {
      const { data } = await axios.get('/api/cdek/offices', { params: { city_code: cityCode } });
      officeSelect.innerHTML = '<option value="">Выберите ПВЗ</option>';
      (data || []).forEach(o => {
        const opt = document.createElement('option');
        opt.value = o.code;
        opt.textContent = `${o.name || 'ПВЗ'} — ${o.address || ''}`;
        opt.dataset.address = o.address || '';
        opt.dataset.postal = o.postal_code || '';
        officeSelect.appendChild(opt);
      });
      // Draw on map
      await setOfficeMarkers(Array.isArray(data) ? data : []);
    } catch {}
  }

  // Calculate for PVZ
  if (calcOfficeBtn) calcOfficeBtn.addEventListener('click', async () => {
    const toCode = Number(cityInput?.dataset?.code || 0);
    const pvz = officeSelect?.value || '';
    if (!toCode || !pvz) {
      summaryEl.textContent = 'Выберите город и ПВЗ';
      return;
    }
    const packages = calcParcels();
    try {
      const { data } = await axios.post('/api/cdek/calculate/office', { to_code: toCode, office_code: pvz, packages });
      const best = data?.best || null;
      if (!best) { summaryEl.textContent = 'Нет подходящих тарифов'; return; }
      const addr = officeSelect.selectedOptions[0]?.dataset?.address || '';
      const price = Number(best.delivery_sum) || 0;

      // Fill hidden fields
      const setVal = (id, v) => { const n = el(id); if (n) n.value = String(v ?? ''); };
      setVal('cdek_mode', 'office');
      setVal('cdek_tariff_code', best.tariff_code);
      setVal('cdek_tariff_name', best.tariff_name || '');
      setVal('cdek_delivery_sum', price.toFixed(2));
      setVal('cdek_period_min', best.period_min ?? '');
      setVal('cdek_period_max', best.period_max ?? '');
      setVal('cdek_pvz_code', pvz);
      setVal('cdek_pvz_address', addr);
      setVal('cdek_recipient_address', '');

      if (deliveryAddress) deliveryAddress.value = addr;
      setDeliveryPrice(price);
      setDeliveryCode('cdek');
      summaryEl.textContent = `ПВЗ: ${addr}. Тариф: ${best.tariff_name}. Срок: ${best.period_min}-${best.period_max} дн. Стоимость: ${price.toFixed(2)} ₽`;
      lsSet('cdek:last', { mode: 'office', toCode, pvz });
    } catch (e) {
      summaryEl.textContent = 'Ошибка расчета СДЭК (ПВЗ)';
    }
  });

  // Calculate for courier
  if (calcDoorBtn) calcDoorBtn.addEventListener('click', async () => {
    const addr = (addrInput?.value || '').trim();
    const pc = (postalHidden?.value || '').trim();
    if (!addr) { summaryEl.textContent = 'Укажите адрес доставки'; return; }
    const packages = calcParcels();
    try {
      const { data } = await axios.post('/api/cdek/calculate/door', { to_address: addr, postal_code: pc || undefined, packages });
      const best = data?.best || null;
      if (!best) { summaryEl.textContent = 'Нет подходящих тарифов'; return; }
      const price = Number(best.delivery_sum) || 0;

      const setVal = (id, v) => { const n = el(id); if (n) n.value = String(v ?? ''); };
      setVal('cdek_mode', 'door');
      setVal('cdek_tariff_code', best.tariff_code);
      setVal('cdek_tariff_name', best.tariff_name || '');
      setVal('cdek_delivery_sum', price.toFixed(2));
      setVal('cdek_period_min', best.period_min ?? '');
      setVal('cdek_period_max', best.period_max ?? '');
      setVal('cdek_pvz_code', '');
      setVal('cdek_pvz_address', '');
      setVal('cdek_recipient_address', addr);
      setVal('cdek_postal_code', pc || '');

      if (deliveryAddress) deliveryAddress.value = addr;
      setDeliveryPrice(price);
      setDeliveryCode('cdek');
      summaryEl.textContent = `Курьер: ${addr}. Тариф: ${best.tariff_name}. Срок: ${best.period_min}-${best.period_max} дн. Стоимость: ${price.toFixed(2)} ₽`;
      lsSet('cdek:last', { mode: 'door', addr, pc });
    } catch (e) {
      summaryEl.textContent = 'Ошибка расчета СДЭК (курьер)';
    }
  });

  // Dadata address suggestions for courier
  function clearSuggest(el){ if (!el) return; el.innerHTML=''; el.classList.add('hidden'); }
  const onAddrInput = debounce(async ()=>{
    const q = (addrInput?.value || '').trim();
    if (!q || !addrSuggest || !dadataToken) { clearSuggest(addrSuggest); return; }
    try {
      const { data } = await axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
        { query: q, count: 8, language: 'ru' }, { headers: { 'Authorization': `Token ${dadataToken}`, 'Content-Type': 'application/json' } });
      const arr = data?.suggestions || [];
      addrSuggest.innerHTML = '';
      arr.forEach(sug => {
        const li = document.createElement('li');
        li.className = 'p-2 hover:bg-gray-100 cursor-pointer';
        li.textContent = sug.value || sug.unrestricted_value || '';
        li.addEventListener('click', () => {
          if (addrInput) addrInput.value = sug.value || sug.unrestricted_value || '';
          if (postalHidden) postalHidden.value = sug.data?.postal_code || '';
          clearSuggest(addrSuggest);
          const lon = Number(sug.data?.geo_lon); const lat = Number(sug.data?.geo_lat);
          if (Number.isFinite(lon) && Number.isFinite(lat)) setDoorMarker(lon, lat);
        });
        addrSuggest.appendChild(li);
      });
      addrSuggest.classList.toggle('hidden', arr.length === 0);
    } catch { clearSuggest(addrSuggest); }
  }, 400);
  if (addrInput) addrInput.addEventListener('input', onAddrInput);

  // Geolocate button (optional via context menu on label)
  if (mapDoorEl && dadataToken) {
    // Right-click on courier map tries to detect current position and set address
    mapDoorEl.addEventListener('contextmenu', async (e) => {
      e.preventDefault();
      if (!navigator.geolocation) return;
      navigator.geolocation.getCurrentPosition(async (pos) => {
        try {
          const lat = pos.coords.latitude; const lon = pos.coords.longitude;
          await setDoorMarker(lon, lat);
          const { data } = await axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address',
            { lat, lon, count: 1 }, { headers: { 'Authorization': `Token ${dadataToken}`, 'Content-Type': 'application/json' } });
          const sug = data?.suggestions?.[0];
          if (sug) {
            if (addrInput) addrInput.value = sug.value || sug.unrestricted_value || '';
            if (postalHidden) postalHidden.value = sug.data?.postal_code || '';
          }
        } catch {}
      });
    });
  }

  // Initialize maps at once
  initOfficeMap();
  // initialize courier map with default center for click selection
  setDoorMarker(37.617635, 55.755814);
});
