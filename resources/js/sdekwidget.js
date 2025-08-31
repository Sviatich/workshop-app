document.addEventListener('DOMContentLoaded', () => {
  const keyMeta = document.querySelector('meta[name="yandex-maps-api-key"]');
  const yaKey = keyMeta?.content?.trim();
  const ensureWidget = () => new Promise((resolve, reject) => {
    if (window.CDEKWidget) return resolve();
    const s = document.createElement('script');
    s.src = 'https://cdn.jsdelivr.net/npm/@cdek-it/widget@3';
    s.async = true; s.onload = () => resolve(); s.onerror = () => reject(new Error('CDEK widget load error'));
    document.head.appendChild(s);
  });

  const calcParcels = () => {
    const wKg = parseFloat((document.getElementById('cart_weight_total')?.textContent || '0').replace(',', '.')) || 0;
    const volM3 = parseFloat((document.getElementById('cart_volume_total')?.textContent || '0').replace(',', '.')) || 0;
    const weightGr = Math.max(1, Math.round(wKg * 1000));
    const sideMm = Math.max(10, Math.round(Math.cbrt(Math.max(0.000001, volM3)) * 1000));
    return [{ length: sideMm, width: sideMm, height: sideMm, weight: weightGr }];
  };

  const init = async () => {
    const openBtn = document.getElementById('open-cdek');
    if (!openBtn) return;
    try {
      await ensureWidget();
      const widget = new window.CDEKWidget({
        from: { city: 'Москва' },
        servicePath: '/service.php',
        // Ключ Яндекс.Карт для геокодинга и карты внутри виджета
        apiKey: yaKey || undefined,
        lang: 'rus',
        currency: 'RUB',
        popup: true,
        tariffs: { office: [136,138], door: [137,139] },
        // Начальная локация для виджета (требуется библиотекой)
        defaultLocation: 'Черноголовка',
        onReady() {
          widget.resetParcels();
          widget.addParcel(calcParcels());
        },
        onChoose(mode, tariff, address) {
          const summary = document.getElementById('delivery_summary');
          if (summary) {
            summary.textContent = `${mode === 'office' ? 'В ПВЗ' : 'Курьером'} за ${tariff.delivery_sum} ₽ за ${tariff.period_min}–${tariff.period_max} дн.`;
          }

          const set = (id, val) => { const el = document.getElementById(id); if (el) el.value = val ?? ''; };
          set('cdek_mode', mode);
          set('cdek_tariff_code', tariff.tariff_code);
          set('cdek_tariff_name', tariff.tariff_name || '');
          set('cdek_delivery_sum', tariff.delivery_sum);
          set('cdek_period_min', tariff.period_min);
          set('cdek_period_max', tariff.period_max);

          if (mode === 'office') {
            set('cdek_pvz_code', address.code);
            set('cdek_pvz_address', address.address);
            const dm = document.getElementById('delivery_method_code'); if (dm) dm.value = 'cdek_pvz';
          } else {
            set('cdek_recipient_address', address.address);
            const dm = document.getElementById('delivery_method_code'); if (dm) dm.value = 'cdek_courier';
          }

          // Пробрасываем адрес в общее поле оформления
          const addrInput = document.getElementById('delivery_address');
          if (addrInput) addrInput.value = address?.address || '';

          const delPriceEl = document.getElementById('delivery_row_value');
          const delHidden = document.getElementById('delivery_price_input');
          const val = Number(tariff.delivery_sum) || 0;
          if (delPriceEl) delPriceEl.textContent = val.toFixed(2);
          if (delHidden) delHidden.value = val.toFixed(2);
          try { window.dispatchEvent(new CustomEvent('cart:updated')); } catch (_) {}

          const code = (document.getElementById('delivery_method_code')?.value) || '';
          const sel = document.getElementById('delivery_method_id');
          if (sel) {
            const opt = Array.from(sel.options).find(o => (o.dataset && o.dataset.code) === code);
            if (opt) sel.value = opt.value;
          }

          widget.close();
        }
      });

      openBtn.addEventListener('click', () => {
        try { widget.resetParcels(); widget.addParcel(calcParcels()); } catch(_) {}
        widget.open();
      });

    } catch (e) {
      console.error(e);
    }
  };

  init();
});
