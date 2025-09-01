document.addEventListener('DOMContentLoaded', () => {
  // === UI helpers ===
  const el = (id) => document.getElementById(id);
  const show = (node, visible) => node && node.classList.toggle('hidden', !visible);

  // === Служебные функции для доставки/итога (используют готовую разметку) ===
  const setDeliveryMethodByCode = (code) => {
    const sel = el('delivery_method_id');
    if (!sel) return;
    const opt = Array.from(sel.options).find(o => (o.dataset && o.dataset.code) === code);
    if (opt) sel.value = opt.value;
  };

  const updateGrandTotal = () => {
    const items = parseFloat((el('cart_total')?.textContent || '0').replace(',', '.')) || 0;
    const delivery = parseFloat((el('delivery_row_value')?.textContent || '0').replace(',', '.')) || 0;
    const grand = (items + delivery).toFixed(2);
    const gEl = el('grand_total');
    if (gEl) gEl.textContent = grand;
  };

  const setDeliveryPrice = (price) => {
    const p = Number(price) || 0;
    const dEl = el('delivery_row_value');
    if (dEl) dEl.textContent = p.toFixed(2);
    const hidden = el('delivery_price_input');
    if (hidden) hidden.value = p.toFixed(2);
    updateGrandTotal();
  };

  const setDeliveryCode = (code) => {
    const hidden = el('delivery_method_code');
    if (hidden) hidden.value = code;
    setDeliveryMethodByCode(code);
  };

  // === Блоки выбора доставки ===
  const choices = document.querySelectorAll('input.delivery-choice[name="delivery_method_choice"]');
  const pickupBlock = el('pickup_block');
  const pekBlock = el('pek_block');
  const cdekBlock = el('cdek_block');
  const deliveryAddress = el('delivery_address');

  const setAddressText = (text) => {
    if (!deliveryAddress) return;
    deliveryAddress.value = text || '';
  };

  const setAddressRequired = (req) => {
    if (!deliveryAddress) return;
    if (req) deliveryAddress.setAttribute('required', 'required');
    else deliveryAddress.removeAttribute('required');
  };

  const syncByChoice = (code) => {
    if (code === 'pickup') {
      show(pickupBlock, true);  show(pekBlock, false); show(cdekBlock, false);
      setDeliveryPrice(0);
      setDeliveryCode('pickup');
      setAddressText('Самовывоз (адрес уточняется на странице контактов)');
      setAddressRequired(false);
    } else if (code === 'pek') {
      show(pickupBlock, false); show(pekBlock, true);  show(cdekBlock, false);
      setDeliveryPrice(0);
      setDeliveryCode('pek');
      setAddressText('ПЭК: укажите адрес или ПВЗ перевозчика (при необходимости)');
      setAddressRequired(false);
    } else if (code === 'cdek') {
      show(pickupBlock, false); show(pekBlock, false); show(cdekBlock, false);
      // единый код для СДЭК независимо от режима (ПВЗ/курьер)
      setDeliveryCode('cdek');
      setAddressText('');
      setAddressRequired(true);
    } else if (code === 'cdek_courier') {
      show(pickupBlock, false); show(pekBlock, false); show(cdekBlock, false);
      setDeliveryPrice(0);
      setDeliveryCode('cdek_courier');
      setAddressText('');
      setAddressRequired(true);
    } else if (code === 'best') {
      // Новый способ: «Подобрать оптимальную доставку»
      show(pickupBlock, false); show(pekBlock, false); show(cdekBlock, false);
      setDeliveryPrice(0);
      setDeliveryCode('best');
      setAddressText('');
      setAddressRequired(false);
    }
  };

  choices.forEach(ch => {
    ch.addEventListener('change', () => {
      const v = document.querySelector('input.delivery-choice[name="delivery_method_choice"]:checked')?.value;
      if (v) syncByChoice(v);
    });
  });

  // === Yandex Maps init (auto-load API v3) ===
  const yaKey = document.querySelector('meta[name="yandex-maps-api-key"]')?.content?.trim();
  let yaLoading = null;

  const loadYMaps = () => {
    if (window.ymaps3?.ready) return Promise.resolve();
    if (yaLoading) return yaLoading;
    if (!yaKey) {
      console.warn('YANDEX_MAPS_API_KEY отсутствует, карты не будут загружены');
      return Promise.reject(new Error('YANDEX_MAPS_API_KEY missing'));
    }
    const s = document.createElement('script');
    s.src = `https://api-maps.yandex.ru/v3/?apikey=${encodeURIComponent(yaKey)}&lang=ru_RU`;
    s.async = true;
    yaLoading = new Promise((resolve, reject) => {
      s.onload = () => resolve();
      s.onerror = () => reject(new Error('Yandex Maps load error'));
    });
    document.head.appendChild(s);
    return yaLoading;
  };

  const createYMap = async (containerId, center, markers) => {
    const node = el(containerId);
    if (!node) return;
    try {
      await loadYMaps();
      await window.ymaps3.ready;
      const { YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapMarker } = window.ymaps3;
      const map = new YMap(node, { location: { center, zoom: 12 } });
      map.addChild(new YMapDefaultSchemeLayer());
      map.addChild(new YMapDefaultFeaturesLayer());
      (markers || []).forEach(m => {
        const markerEl = document.createElement('div');
        markerEl.className = 'custom-marker';
        markerEl.title = m.title || '';
        map.addChild(new YMapMarker({ coordinates: m.coords }, markerEl));
      });
    } catch (e) {
      console.warn('Map init error', e);
    }
  };

  // базовые координаты (lon, lat)
  createYMap('pickup_map', [38.374602, 55.989067], [
    { coords: [38.374602, 55.989067], title: 'Пункт выдачи' }
  ]);
  createYMap('pek_map', [38.423324, 55.837053], [
    { coords: [38.428706, 55.837359], title: 'ПЭК склад/ПВЗ' },
    { coords: [37.824799, 56.018574], title: 'ПЭК ПВЗ' },
  ]);

  // === Init defaults ===
  // выбор по умолчанию из отмеченной радио-кнопки (по умолчанию pickup)
  const checked = document.querySelector('input.delivery-choice[name="delivery_method_choice"]:checked');
  syncByChoice(checked?.value || 'pickup');

  setDeliveryPrice(0);
  updateGrandTotal();

  // пересчёт итога при обновлениях корзины
  window.addEventListener('cart:updated', updateGrandTotal);
});

