// cdekwidjet.js
document.addEventListener('DOMContentLoaded', () => {
  const openBtn = document.getElementById('open-cdek');
  if (!openBtn) return;

  const keyMeta = document.querySelector('meta[name="yandex-maps-api-key"]');
  const yaKey = keyMeta?.content?.trim();

  const FROM_CITY = 'Черноголовка';
  const MIN_SIDE_MM = 10;
  const MIN_WEIGHT_G = 1;
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
    const weightText = (document.getElementById('cart_weight_total')?.textContent || '0').replace(',', '.');
    const volumeText = (document.getElementById('cart_volume_total')?.textContent || '0').replace(',', '.');

    const wKg = Math.max(0, parseFloat(weightText)) || 0;
    const volM3 = Math.max(0, parseFloat(volumeText)) || 0;

    const weightGr = Math.max(MIN_WEIGHT_G, Math.round(wKg * 1000));
    const sideMm = Math.max(MIN_SIDE_MM, Math.round(Math.cbrt(Math.max(1e-6, volM3)) * 1000));

    return [{ length: sideMm, width: sideMm, height: sideMm, weight: weightGr }];
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
          from: { city: FROM_CITY },
          servicePath: '/service.php',
          apiKey: yaKey || undefined,
          lang: 'rus',
          currency: 'RUB',
          popup: true,

          tariffs: {
            office: [136, 138],
            door:   [137, 139],
          },

          defaultLocation: FROM_CITY,

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