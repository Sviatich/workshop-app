document.addEventListener("DOMContentLoaded", () => {
  const cartItemsContainer = document.getElementById("cart_items");
  const cartSummary = document.getElementById("cart_summary");
  const emptyCart = document.getElementById("empty_cart");
  const cartTotalElem = document.getElementById("cart_total");
  const cartWeightTotalElem = document.getElementById("cart_weight_total");
  const cartVolumeTotalElem = document.getElementById("cart_volume_total");

  // Может существовать старый <select id="payer_type"> или новые <input type="radio" name="payer_type">
  const payerTypeSelect = document.getElementById("payer_type"); // может быть null
  const payerTypeRadios = Array.from(document.querySelectorAll('input[name="payer_type"]')); // может быть []

  const innField = document.getElementById("inn_field");
  const fullNameInput = document.getElementById("full_name");

  // Inject company name field (before INN) if missing
  function ensureCompanyField() {
    let node = document.getElementById('company_field');
    if (node) return node;
    node = document.createElement('div');
    node.id = 'company_field';
    node.className = 'hidden';
    node.innerHTML = `
      <label class="block font-semibold mb-1 cart-labels" for="company_name">Название компании</label>
      <input placeholder="ООО «Пример» или ИП Иванов" type="text" name="company_name" id="company_name" class="border rounded w-full p-2">
    `;
    if (innField && innField.parentNode) {
      innField.parentNode.insertBefore(node, innField);
    }
    return node;
  }

  // Inject mini payment info card above full name
  function ensurePaymentInfo() {
    if (document.getElementById('payment_info')) return;
    const wrap = document.createElement('div');
    wrap.id = 'payment_info';
    wrap.className = 'flex items-center gap-3 p-3 border rounded bg-white text-sm';
    wrap.innerHTML = `
      <div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded">
        <span id="payment_info_icon"></span>
      </div>
      <div id="payment_info_text" class="text-gray-700">Оплата картой после согласования</div>
    `;
    const target = fullNameInput?.parentElement;
    if (target && target.parentNode) {
      target.parentNode.insertBefore(wrap, target);
    }
  }

  function setPaymentInfo(type) {
    const textEl = document.getElementById('payment_info_text');
    const iconHolder = document.getElementById('payment_info_icon');
    if (!textEl || !iconHolder) return;
    const cardIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v1H3V7Zm0 4h18v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6Zm3 5h4v2H6v-2Z" fill="#222"/></svg>';
    const billIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M7 3a2 2 0 0 0-2 2v14l3-2 3 2 3-2 3 2V5a2 2 0 0 0-2-2H7Zm2 5h6v2H9V8Zm0 4h6v2H9v-2Z" fill="#222"/></svg>';
    if (type === 'company') {
      textEl.textContent = 'Оплата по счету после согласования';
      iconHolder.innerHTML = billIcon;
    } else {
      textEl.textContent = 'Оплата картой после согласования';
      iconHolder.innerHTML = cardIcon;
    }
  }

  // Ensure dynamic UI parts exist before we use them
  ensureCompanyField();
  ensurePaymentInfo();

  let cart = JSON.parse(localStorage.getItem("cart") || "[]");

  // === Validation helpers ===
  const hasLetter = (s) => /[A-Za-zА-Яа-яЁё]/.test(s || '');
  const isValidFullName = (s) => {
    if (!s) return false;
    const parts = String(s).trim().split(/\s+/).filter(Boolean);
    const letterParts = parts.filter(hasLetter);
    return letterParts.length >= 2;
  };
  const isValidEmail = (s) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(s || '').trim());
  const isValidPhone = (s) => {
    const digits = String(s || '').replace(/\D/g, '');
    return digits.length >= 10;
  };
  const isValidINN = (s) => {
    const digits = String(s || '').replace(/\D/g, '');
    return digits.length === 10 || digits.length === 12;
  };
  function setFieldError(input, message) {
    if (!input) return;
    let err = input.parentElement?.querySelector('.field-error');
    if (message) {
      if (!err) {
        err = document.createElement('p');
        err.className = 'field-error text-red-600 text-sm mt-1';
        input.parentElement.appendChild(err);
      }
      err.textContent = message;
      input.classList.add('border-red-500');
      input.setAttribute('aria-invalid', 'true');
    } else {
      if (err) err.remove();
      input.classList.remove('border-red-500');
      input.removeAttribute('aria-invalid');
    }
  }
  function clearErrors() {
    document.querySelectorAll('.field-error').forEach(n => n.remove());
    document.querySelectorAll('#order_form input, #order_form textarea').forEach(el => {
      el.classList.remove('border-red-500');
      el.removeAttribute('aria-invalid');
    });
  }

  // === NEW: универсальный способ получить текущий тип плательщика ===
  function getPayerType() {
    // Радио имеют приоритет, если они на странице
    if (payerTypeRadios.length) {
      const checked = payerTypeRadios.find(r => r.checked);
      return checked ? checked.value : "individual";
    }
    // Фолбэк на селект
    if (payerTypeSelect) return payerTypeSelect.value || "individual";
    return "individual";
  }

  // === NEW: единая реакция на смену типа плательщика ===
  function onPayerTypeChange() {
    toggleInn();
    // Если где-то завязаны другие блоки (реквизиты юрлица и т.п.) — тут удобно их тоже переключать
    // window.dispatchEvent(new CustomEvent('payer_type:changed', { detail: { value: getPayerType() } }));
  }

  // Показ/скрытие ИНН по типу плательщика
  function toggleInn() {
    const t = getPayerType();
    if (innField) innField.classList.toggle("hidden", t !== "company");
    const companyField = document.getElementById('company_field');
    if (companyField) companyField.classList.toggle("hidden", t !== "company");
    setPaymentInfo(t);
    if (t !== 'company') {
      const innEl = document.getElementById('inn');
      if (innEl) try { setFieldError(innEl, ''); } catch (_) {}
    }
  }

  // Подписки на изменения: либо на селект, либо на радио
  if (payerTypeSelect) {
    payerTypeSelect.addEventListener("change", onPayerTypeChange);
  }
  if (payerTypeRadios.length) {
    payerTypeRadios.forEach(r => r.addEventListener("change", onPayerTypeChange));
  }
  // первичная инициализация
  toggleInn();
  setPaymentInfo(getPayerType());

  function fmt(n, digits = 2) {
    const num = Number(n);
    if (Number.isNaN(num)) return "0";
    return num.toFixed(digits);
  }

  function renderCart() {
    if (!cartItemsContainer || !cartSummary || !emptyCart || !cartTotalElem || !cartWeightTotalElem || !cartVolumeTotalElem) return;

    cartItemsContainer.innerHTML = "";

    if (cart.length === 0) {
      renderEmptyState();
      const layout = document.querySelector('#order_form')?.closest('.grid');
      if (layout) layout.classList.add('hidden');
      cartSummary.classList.add("hidden");
      emptyCart.classList.remove("hidden");
      return;
    }

    let total = 0;
    let totalWeight = 0;
    let totalVolume = 0;

    cart.forEach((item, index) => {
      const itemTotal = Number(item.total_price) || 0;
      const itemWeight = Number(item.weight) || 0;
      const itemVolume = Number(item.volume) || 0;

      total += itemTotal;
      totalWeight += itemWeight;
      totalVolume += itemVolume;

      const div = document.createElement("div");
      div.className = "p-4 border rounded bg-white relative";

      let html = `
        <p class="font-semibold mb-1">
          ${item.construction_name || item.construction} — ${item.length} × ${item.width} × ${item.height} мм
        </p>
        <p>Цвет: ${item.color_name || item.color}</p>
        <p>Тираж: ${item.tirage}</p>

        <div class="grid gap-2 md:grid-cols-3 mt-2">
          <p>Цена за штуку: ${fmt(item.price_per_unit)} ₽</p>
          <p>Итого: ${fmt(itemTotal)} ₽</p>
          <p></p>
        </div>

        ${item.fullprint?.enabled && itemTotal === 0 ? `
          <p class="text-orange-600 font-semibold mt-1">
            Цена будет рассчитана менеджером индивидуально после оформления заказа.
          </p>` : ""}

        <div class="grid gap-2 md:grid-cols-3 mt-2">
          <p><strong>Вес позиции:</strong> ${fmt(itemWeight, 3)} кг</p>
          <p><strong>Объём позиции:</strong> ${fmt(itemVolume, 3)} м³</p>
          <p></p>
        </div>
      `;

      // Логотип
      if (item.logo?.enabled) {
        html += `
          <p class="mt-2"><strong>Логотип:</strong> да${item.logo.size ? ` (размер: ${item.logo.size})` : ''}</p>
        `;
        if (item.logo.filename) {
          html += `<p class="text-sm text-gray-600">Файл: ${item.logo.filename}</p>`;
        }
        if (item.logo.file_path && item.logo.file_path.match(/\.(jpg|jpeg|png|gif|webp|svg)$/i)) {
          html += `<img src="${item.logo.file_path}" alt="Логотип" class="mt-2 max-w-[200px] rounded border">`;
        }
      }

      // Полноформатная печать
      if (item.fullprint?.enabled) {
        html += `<p class="mt-2"><strong>Полноформатная печать:</strong> да</p>`;
        if (item.fullprint.description) {
          html += `<p class="text-sm text-gray-600">Комментарий: ${item.fullprint.description}</p>`;
        }
        if (item.fullprint.filename) {
          html += `<p class="text-sm text-gray-600">Файл: ${item.fullprint.filename}</p>`;
        }
        if (item.fullprint.file_path && item.fullprint.file_path.match(/\.(jpg|jpeg|png|gif|webp|svg)$/i)) {
          html += `<img src="${item.fullprint.file_path}" alt="Макет печати" class="mt-2 max-w-[200px] rounded border">`;
        }
      }

      html += `
        <button class="cursor-pointer remove_item btn-hover-effect" data-index="${index}">
          <svg width="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M19.207 6.207a1 1 0 0 0-1.414-1.414L12 10.586 6.207 4.793a1 1 0 0 0-1.414 1.414L10.586 12l-5.793 5.793a1 1 0 1 0 1.414 1.414L12 13.414l5.793 5.793a1 1 0 0 0 1.414-1.414L13.414 12l5.793-5.793z" fill="#333"></path></g></svg>
        </button>
      `;

      div.innerHTML = html;
      cartItemsContainer.appendChild(div);
    });

    cartTotalElem.textContent = fmt(total);
    cartWeightTotalElem.textContent = fmt(totalWeight, 3);
    cartVolumeTotalElem.textContent = fmt(totalVolume, 3);

    const layout = document.querySelector('#order_form')?.closest('.grid');
    if (layout) layout.classList.remove('hidden');
    cartSummary.classList.remove("hidden");
    emptyCart.classList.add("hidden");

    // Удаление товара
    document.querySelectorAll(".remove_item").forEach(btn => {
      btn.addEventListener("click", () => {
        const idx = Number(btn.dataset.index);
        cart.splice(idx, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        if (window.CartUI?.update) {
          try { window.CartUI.update(); } catch (_) {}
        }
      });
    });

    // Сигнал обновления корзины для модулей доставки
    try { window.dispatchEvent(new CustomEvent('cart:updated')); } catch (_) {}
  }

  renderCart();

  const orderForm = document.getElementById("order_form");
  const orderLoader = document.getElementById("order_loader");
  const submitBtn = orderForm?.querySelector('button[type="submit"]');

  function setSubmitting(isSubmitting) {
    if (orderLoader) orderLoader.classList.toggle('hidden', !isSubmitting);
    if (submitBtn) {
      submitBtn.disabled = isSubmitting;
      if (isSubmitting) {
        submitBtn.dataset.originalText = submitBtn.textContent;
        submitBtn.innerHTML = 'Оформляем… <span class="inline-block w-4 h-4 border-2 border-white/80 border-t-transparent animate-spin rounded-full ml-1 align-[-2px]"></span>';
        submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
      } else {
        submitBtn.innerHTML = submitBtn.dataset.originalText || 'Оформить заказ';
        submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
      }
    }
  }

  if (orderForm) {
    orderForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      if (cart.length === 0) {
        alert("Корзина пуста.");
        return;
      }

      // Client-side validation
      clearErrors();
      const fullNameEl = document.getElementById('full_name');
      const emailEl = document.getElementById('email');
      const phoneEl = document.getElementById('phone');
      const innEl = document.getElementById('inn');

      let valid = true;
      if (!isValidFullName(fullNameEl?.value)) {
        setFieldError(fullNameEl, 'Укажите имя и фамилию через пробел');
        valid = false;
      }
      if (!isValidEmail(emailEl?.value)) {
        setFieldError(emailEl, 'Введите корректный email');
        valid = false;
      }
      if (!isValidPhone(phoneEl?.value)) {
        setFieldError(phoneEl, 'Введите корректный телефон');
        valid = false;
      }
      if (getPayerType() === 'company') {
        if (!isValidINN(innEl?.value)) {
          setFieldError(innEl, 'ИНН должен содержать 10 или 12 цифр');
          valid = false;
        }
      }
      if (!valid) {
        const firstInvalid = orderForm.querySelector('[aria-invalid="true"]');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      setSubmitting(true);
      const formData = new FormData();
      // === CHANGED: берём значение payer_type через универсальный хелпер ===
      formData.append("payer_type", getPayerType());

      formData.append("full_name", document.getElementById("full_name")?.value || '');
      formData.append("email", document.getElementById("email")?.value || '');
      formData.append("phone", document.getElementById("phone")?.value || '');
      formData.append("inn", document.getElementById("inn")?.value || '');
      formData.append("company_name", document.getElementById("company_name")?.value || '');
      formData.append("delivery_address", document.getElementById("delivery_address")?.value || '');
      formData.append("delivery_method_id", Number(document.getElementById("delivery_method_id")?.value || 0));
      formData.append("delivery_method_code", document.getElementById("delivery_method_code")?.value || '');
      formData.append("delivery_price", document.getElementById("delivery_price_input")?.value || 0);
      formData.append("cart", JSON.stringify(cart));

      // Пример добавления файлов (если есть input'ы на странице)
      cart.forEach((item, index) => {
        if (item.logo?.file) {
          const input = document.querySelector(`#logo_file_${index}`);
          if (input?.files?.[0]) {
            formData.append(`logo_file_${index}`, input.files[0]);
          }
        }
        if (item.fullprint?.file) {
          const input = document.querySelector(`#print_file_${index}`);
          if (input?.files?.[0]) {
            formData.append(`print_file_${index}`, input.files[0]);
          }
        }
      });

      try {
        const res = await fetch("/api/order", {
          method: "POST",
          headers: { "Accept": "application/json" },
          body: formData,
        });
        const result = await res.json();
        setSubmitting(false);

        if (res.ok) {
          alert("Заказ успешно оформлен!");
          localStorage.removeItem("cart");
          window.location.href = `/order/${result.uuid}`;
        } else {
          alert(result.message || "Ошибка при оформлении заказа");
        }
      } catch (err) {
        console.error("Ошибка:", err);
        alert("Ошибка при оформлении заказа");
      }
    });
  }

  // Live field validation on input
  const fullNameEl = document.getElementById('full_name');
  const emailEl = document.getElementById('email');
  const phoneEl = document.getElementById('phone');
  const innEl = document.getElementById('inn');

  fullNameEl?.addEventListener('input', () => setFieldError(fullNameEl, isValidFullName(fullNameEl.value) ? '' : null));
  emailEl?.addEventListener('input', () => setFieldError(emailEl, isValidEmail(emailEl.value) ? '' : null));
  phoneEl?.addEventListener('input', () => setFieldError(phoneEl, isValidPhone(phoneEl.value) ? '' : null));
  function renderEmptyState() {
    if (!emptyCart) return;
    emptyCart.innerHTML = `
      <div class="text-center py-16">
        <div class="mx-auto w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"><path d="M7 4H5a1 1 0 0 0 0 2h1.22l1.6 8.02A3 3 0 0 0 10.77 17h5.46a3 3 0 0 0 2.95-2.38l1.1-5.5A1 1 0 0 0 19.3 8H7.87l-.35-2H19a1 1 0 1 0 0-2H7Zm3.77 11a1 1 0 0 1-.98-.8L9.3 10h9.25l-.88 4.4a1 1 0 0 1-.98.8h-5.46Z" fill="#4B5563"/></svg>
        </div>
        <p class="mt-4 text-lg text-gray-700">В корзине пусто</p>
        <a href="/#configurator" class="add-to-cart-button btn-hover-effect mt-6 inline-block">Калькулятор упаковки</a>
      </div>
    `;
  }
  innEl?.addEventListener('input', () => {
    if (getPayerType() !== 'company') { setFieldError(innEl, ''); return; }
    setFieldError(innEl, isValidINN(innEl.value) ? '' : null);
  });
});
