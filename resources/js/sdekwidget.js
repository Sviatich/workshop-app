document.addEventListener('DOMContentLoaded', () => {
  // Твои посылки: размеры в СМ, вес в ГРАММАХ
  // (ниже мок; подставь свои вычисленные данные)
  const parcels = [{ length: 40, width: 30, height: 20, weight: 2500 }];

  const widget = new window.CDEKWidget({
    from: { city: 'Черноголовка' },            // город отправки
    servicePath: '/service.php',         // ТВОЙ service.php в public
    apiKey: '2270b668-e556-46a1-b36c-7465185a997b',       // ключ Яндекс.Карт
    lang: 'rus',
    currency: 'RUB',
    popup: true,                         // модалка
    // покажем только базовые «Посылка» тарифы
    tariffs: { office: [136,138], door: [137,139] },
    defaultLocation: 'Новосибирск',

    onReady() {
      widget.resetParcels();
      widget.addParcel(parcels);         // прокидываем габариты/вес
    },

    // Когда пользователь подтвердил выбор
    onChoose(mode, tariff, address) {
      // mode: 'office' (ПВЗ) | 'door' (курьер)
      // tariff: { tariff_code, tariff_name, delivery_sum, period_min, period_max, ... }
      // address: для ПВЗ — объект с code/name/address/...; для курьера — форматированный адрес

      // Пример: обновим «Итого» на странице и положим в hidden-поля формы
      const summary = document.getElementById('delivery_summary');
      if (summary) {
        summary.textContent =
          `${mode === 'office' ? 'До ПВЗ' : 'Курьером'} • ${tariff.delivery_sum} ₽ • ${tariff.period_min}–${tariff.period_max} дн.`;
      }

      // Сохраняем для бэкенда (пример со скрытыми полями)
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
      } else {
        set('cdek_recipient_address', address.address);
      }

      widget.close();
    }
  });

  document.getElementById('open-cdek').addEventListener('click', () => widget.open());
});
