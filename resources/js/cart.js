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

  let cart = JSON.parse(localStorage.getItem("cart") || "[]");

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
    if (!innField) return;
    innField.classList.toggle("hidden", getPayerType() !== "company");
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

  function fmt(n, digits = 2) {
    const num = Number(n);
    if (Number.isNaN(num)) return "0";
    return num.toFixed(digits);
  }

  function renderCart() {
    if (!cartItemsContainer || !cartSummary || !emptyCart || !cartTotalElem || !cartWeightTotalElem || !cartVolumeTotalElem) return;

    cartItemsContainer.innerHTML = "";

    if (cart.length === 0) {
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

      setSubmitting(true);
      const formData = new FormData();
      // === CHANGED: берём значение payer_type через универсальный хелпер ===
      formData.append("payer_type", getPayerType());

      formData.append("full_name", document.getElementById("full_name")?.value || '');
      formData.append("email", document.getElementById("email")?.value || '');
      formData.append("phone", document.getElementById("phone")?.value || '');
      formData.append("inn", document.getElementById("inn")?.value || '');
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
});
