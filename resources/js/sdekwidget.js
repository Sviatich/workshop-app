// cdekwidjet.js
document.addEventListener('DOMContentLoaded', () => {
  // Debug: set to false or comment out to disable logs
  const DEBUG_SDEK = true;
  const dbg = (...args) => { if (DEBUG_SDEK) { try { console.log('[SDEK]', ...args); } catch (_) {} } };
  const openBtn = document.getElementById('open-cdek');
  if (!openBtn) return;

  const keyMeta = document.querySelector('meta[name="yandex-maps-api-key"]');
  const yaKey = keyMeta?.content?.trim();

  const FROM_CITY = 'Черноголовка';
  // Use numeric CDEK city code for sender to avoid encoding issues
  // 17 corresponds to Pushkino, Moscow region
  const FROM_CODE = 171;
  // Default destination city for the widget UI (Moskva)
  const DEFAULT_LOCATION = 'Москва';
  // Reasonable bounds for CDEK calculator
  const MIN_SIDE_MM = 100; // 10 cm min side for length/width (mm)
  const MIN_HEIGHT_MM = 10; // 1 cm min height (mm)
  const MAX_SIDE_MM = 1500; // 150 cm max side
  const MIN_WEIGHT_G = 100; // 0.1 kg min weight
  const LS_KEY = 'cdek:lastChoice';

  const ensureWidgetLib = () =>
    new Promise((resolve, reject) => {
      if (window.CDEKWidget) return resolve();
      const s = document.createElement('script');
      s.src = 'https://cdn.jsdelivr.net/npm/@cdek-it/widget@3';
      s.async = true;
      s.onload = () => resolve();
      s.onerror = () => reject(new Error('CDEK widget load error'));
      document.head.appendChild(s);
    });

  function calcParcels() {
    // Build parcels based on flat-pack geometry from backend calculators.
    // We stack units by thickness until we hit weight/height limits.
    let cart = [];
    try { cart = JSON.parse(localStorage.getItem('cart') || '[]') } catch (_) {}

    const MAX_PARCEL_WEIGHT_G = 25000; // 25 kg per parcel (safe for most tariffs)

    // Flatten per-unit entities with per-unit weight and flat-pack dims
    const units = [];
    const debugItems = [];
    for (const item of cart) {
      const tirage = Math.max(1, Number(item.tirage) || 1);

      // Prefer precomputed blank dims from backend calculators
      let L = Number(item.parcel_length_mm);
      let W = Number(item.parcel_width_mm);
      let unitH = Number(item.parcel_unit_height_mm);

      // Fallbacks if not present: use conservative defaults
      if (!Number.isFinite(L) || L <= 0) L = MIN_SIDE_MM;
      if (!Number.isFinite(W) || W <= 0) W = MIN_SIDE_MM;
      if (!Number.isFinite(unitH) || unitH <= 0) unitH = 1.5; // mm per unit

      L = Math.min(MAX_SIDE_MM, Math.max(MIN_SIDE_MM, Math.round(L)));
      W = Math.min(MAX_SIDE_MM, Math.max(MIN_SIDE_MM, Math.round(W)));

      // Weight per unit in kg -> g. Ensure sane min weight per unit.
      const totalItemWeightKg = Math.max(0, Number(item.weight) || 0);
      const unitWeightG = Math.max(MIN_WEIGHT_G, Math.round((totalItemWeightKg / tirage) * 1000));

      // Collect compact debug info per cart item (not per unit)
      debugItems.push({
        construction: item.construction || item.construction_name || 'unknown',
        tirage,
        blank_mm: `${L}x${W}`,
        unit_thickness_mm: unitH,
        total_thickness_mm: Math.round(unitH * tirage),
        weight_total_g: Math.round(totalItemWeightKg * 1000),
        weight_per_unit_g: unitWeightG,
      });

      for (let i = 0; i < tirage; i++) {
        units.push({ L, W, h: unitH, g: unitWeightG });
      }
    }

    // Greedy pack by weight/height. Keep footprint as max of included units.
    const parcels = [];
    let current = null;
    for (const u of units) {
      if (!current) {
        current = { length: u.L, width: u.W, height: 0, weight: 0 };
      }

      const nextWeight = current.weight + u.g;
      const nextHeight = current.height + u.h;

      // If adding this unit exceeds limits, close current and start a new parcel
      if (nextWeight > MAX_PARCEL_WEIGHT_G || nextHeight > MAX_SIDE_MM) {
        if (current.weight > 0) {
          // Clamp final mm geometry
          current.length = Math.max(MIN_SIDE_MM, Math.round(current.length));
          current.width  = Math.max(MIN_SIDE_MM, Math.round(current.width));
          current.height = Math.max(MIN_HEIGHT_MM, Math.round(current.height));
          parcels.push(current);
        }
        current = { length: u.L, width: u.W, height: 0, weight: 0 };
      }

      current.length = Math.max(current.length, u.L);
      current.width  = Math.max(current.width,  u.W);
      current.height = current.height + u.h; // stack by thickness
      current.weight = current.weight + u.g;
    }
    if (current && current.weight > 0) {
      current.length = Math.max(MIN_SIDE_MM, Math.round(current.length));
      current.width  = Math.max(MIN_SIDE_MM, Math.round(current.width));
      current.height = Math.max(MIN_HEIGHT_MM, Math.round(current.height));
      parcels.push(current);
    }

    // Convert mm -> cm for CDEK API, keep weight in grams
    const cmParcels = parcels.map(p => ({
      length: Math.max(1, Math.ceil(p.length / 10)),
      width:  Math.max(1, Math.ceil(p.width  / 10)),
      height: Math.max(1, Math.ceil(p.height / 10)),
      weight: Math.max(MIN_WEIGHT_G, Math.round(p.weight)),
    }));

    // Debug output: what we send to CDEK
    if (DEBUG_SDEK) {
      try {
        console.groupCollapsed('[SDEK] calcParcels summary');
        console.table(debugItems);
        dbg('Parcels mm:', parcels);
        dbg('Parcels cm (final):', cmParcels);
        console.groupEnd();
      } catch (_) {}
    }

    // Fallback: if cart empty or packing failed, return a minimal parcel 10x10x1 cm, 0.1 kg
    if (!cmParcels.length) {
      return [{ length: 10, width: 10, height: 1, weight: MIN_WEIGHT_G }];
    }
    return cmParcels;
  }

  const setVal = (id, val) => {
    const el = document.getElementById(id);
    if (el) el.value = val ?? '';
  };

  function paintSummary(mode, tariff, address) {
    const summary = document.getElementById('delivery_summary');
    if (!summary) return;
    const way = mode === 'office' ? 'В ПВЗ' : 'Курьером';
    const price = Number(tariff?.delivery_sum) || 0;
    const pmin = tariff?.period_min ?? '';
    const pmax = tariff?.period_max ?? '';
    summary.textContent = `${way} от ${price.toFixed(2)} ₽, срок ${pmin}–${pmax} дн.`;
  }

  function storeChoice(payload) {
    try { localStorage.setItem(LS_KEY, JSON.stringify(payload)); } catch (_) {}
  }
  function loadChoice() {
    try {
      const raw = localStorage.getItem(LS_KEY);
      return raw ? JSON.parse(raw) : null;
    } catch (_) { return null; }
  }

  let widget = null;
  let opening = false;

  async function openWidget() {
    if (opening) return;
    opening = true;
    openBtn.disabled = true;

    try {
      await ensureWidgetLib();

      if (!widget) {
        widget = new window.CDEKWidget({
          from: { code: FROM_CODE },
          servicePath: '/service.php',
          apiKey: yaKey || undefined,
          lang: 'rus',
          currency: 'RUB',
          popup: true,

          // Allow a broad set of tariffs so widget can match API response
          tariffs: {
            // Office (ПВЗ/постамат) directions
            office: [
              // Посылка
              138, // дверь-склад
              136, // склад-склад
              // Магистральный экспресс
              123, // дверь-склад
              62,  // склад-склад
              // Экспресс
              483, // склад-склад
              // Постамат
              606, // постамат-склад
            ],
            // Door (курьер)
            door: [
              // Посылка
              139, // дверь-дверь
              137, // склад-дверь
              // Магистральный экспресс
              121, // дверь-дверь
              122, // склад-дверь
              // Экспресс
              480, // дверь-дверь
              482, // склад-дверь
              // Постамат (дверь -> постамат)
              605, // постамат-дверь (в некоторых маршрутах трактуется как курьер)
            ],
          },

          defaultLocation: DEFAULT_LOCATION,

          onReady() {
            try {
              widget.resetParcels();
              widget.addParcel(calcParcels());
              const saved = loadChoice();
              if (saved?.tariff && saved?.mode && saved?.address) {
                paintSummary(saved.mode, saved.tariff, saved.address);
              }
            } catch (e) {
              console.warn('Parcel init failed:', e);
            }
          },

          onChoose(mode, tariff, address) {
            try {
              paintSummary(mode, tariff, address);

              setVal('cdek_mode', mode);
              setVal('cdek_tariff_code', tariff?.tariff_code);
              setVal('cdek_tariff_name', tariff?.tariff_name || '');
              setVal('cdek_delivery_sum', tariff?.delivery_sum ?? '');
              setVal('cdek_period_min', tariff?.period_min ?? '');
              setVal('cdek_period_max', tariff?.period_max ?? '');

              if (mode === 'office') {
                setVal('cdek_pvz_code', address?.code || '');
                setVal('cdek_pvz_address', address?.address || '');
                setVal('cdek_recipient_address', '');
              } else {
                setVal('cdek_pvz_code', '');
                setVal('cdek_pvz_address', '');
                setVal('cdek_recipient_address', address?.address || '');
              }

              const addrInput = document.getElementById('delivery_address');
              if (addrInput) addrInput.value = address?.address || '';

              const dm = document.getElementById('delivery_method_code');
              if (dm) dm.value = 'cdek';
              const sel = document.getElementById('delivery_method_id');
              if (sel && dm?.value) {
                const opt = Array.from(sel.options).find(o => (o.dataset?.code) === dm.value);
                if (opt) sel.value = opt.value;
              }

              const price = Number(tariff?.delivery_sum) || 0;
              const delPriceEl = document.getElementById('delivery_row_value');
              const delHidden  = document.getElementById('delivery_price_input');
              if (delPriceEl) delPriceEl.textContent = price.toFixed(2);
              if (delHidden)  delHidden.value = price.toFixed(2);

              try { window.dispatchEvent(new CustomEvent('cart:updated')); } catch (_) {}

              storeChoice({ mode, tariff, address });
            } finally {
              try { widget.close(); } catch (_) {}
            }
          },

          onError(err) {
            console.error('CDEK widget error:', err);
          }
        });
      } else {
        try {
          widget.resetParcels();
          widget.addParcel(calcParcels());
        } catch (e) {
          console.warn('Parcel reinit failed:', e);
        }
      }

      widget.open();
    } catch (e) {
      console.error(e);
      try {
        window.dispatchEvent(new CustomEvent('notify', {
          detail: { type: 'error', text: 'Не удалось открыть виджет СДЭК' }
        }));
      } catch (_) {}
    } finally {
      opening = false;
      openBtn.disabled = false;
    }
  }

  openBtn.addEventListener('click', openWidget);
});
