document.addEventListener("DOMContentLoaded", () => {
  const cartItemsContainer = document.getElementById("cart_items");
  const cartSummary = document.getElementById("cart_summary");
  const emptyCart = document.getElementById("empty_cart");
  const cartTotalElem = document.getElementById("cart_total");
  const cartWeightTotalElem = document.getElementById("cart_weight_total");
  const cartVolumeTotalElem = document.getElementById("cart_volume_total");

  const payerTypeSelect = document.getElementById("payer_type");
  const innField = document.getElementById("inn_field");

  let cart = JSON.parse(localStorage.getItem("cart") || "[]");

  // Показ/скрытие ИНН по типу плательщика
  const toggleInn = () => {
    if (!payerTypeSelect || !innField) return;
    innField.classList.toggle("hidden", payerTypeSelect.value !== "company");
  };
  if (payerTypeSelect) {
    payerTypeSelect.addEventListener("change", toggleInn);
    toggleInn(); // первичная инициализация
  }

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
          <svg width="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M14.625 7.00008L14.5217 6.78908C13.9873 5.69263 12.8947 5 11.6995 5C10.5044 5 9.4118 5.69263 8.8774 6.78908L8.77502 7.00008H14.625Z" stroke="#333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M10.6117 11.8095C10.3225 11.513 9.84769 11.507 9.55111 11.7961C9.25453 12.0853 9.24852 12.5601 9.53769 12.8567L10.6117 11.8095ZM11.163 14.5237C11.4522 14.8203 11.927 14.8263 12.2236 14.5371C12.5202 14.248 12.5262 13.7731 12.237 13.4765L11.163 14.5237ZM9.53769 15.1435C9.24852 15.4401 9.25453 15.915 9.55111 16.2041C9.84769 16.4933 10.3225 16.4873 10.6117 16.1907L9.53769 15.1435ZM12.237 14.5237C12.5262 14.2271 12.5202 13.7523 12.2236 13.4631C11.927 13.174 11.4522 13.18 11.163 13.4765L12.237 14.5237ZM13.8623 12.8567C14.1515 12.5601 14.1455 12.0853 13.8489 11.7961C13.5523 11.507 13.0775 11.513 12.7883 11.8095L13.8623 12.8567ZM11.163 13.4765C10.8738 13.7731 10.8799 14.248 11.1764 14.5371C11.473 14.8263 11.9478 14.8203 12.237 14.5237L11.163 13.4765ZM12.7883 16.1907C13.0775 16.4873 13.5523 16.4933 13.8489 16.2041C14.1455 15.915 14.1515 15.4401 13.8623 15.1435L12.7883 16.1907ZM12.237 13.4765C11.9478 13.18 11.473 13.174 11.1764 13.4631C10.8799 13.7523 10.8738 14.2271 11.163 14.5237L12.237 13.4765ZM16.575 7.75012C16.9892 7.75012 17.325 7.41434 17.325 7.00012C17.325 6.58591 16.9892 6.25012 16.575 6.25012V7.75012ZM14.625 6.25012C14.2108 6.25012 13.875 6.58591 13.875 7.00012C13.875 7.41434 14.2108 7.75012 14.625 7.75012V6.25012ZM6.82501 6.25012C6.4108 6.25012 6.07501 6.58591 6.07501 7.00012C6.07501 7.41434 6.4108 7.75012 6.82501 7.75012V6.25012ZM8.77501 7.75012C9.18923 7.75012 9.52501 7.41434 9.52501 7.00012C9.52501 6.58591 9.18923 6.25012 8.77501 6.25012V7.75012ZM7.53894 18.2679L7.00194 18.7915L7.00194 18.7915L7.53894 18.2679ZM6.82501 16.5001H7.57501H6.82501ZM9.53769 12.8567L11.163 14.5237L12.237 13.4765L10.6117 11.8095L9.53769 12.8567ZM10.6117 16.1907L12.237 14.5237L11.163 13.4765L9.53769 15.1435L10.6117 16.1907ZM12.7883 11.8095L11.163 13.4765L12.237 14.5237L13.8623 12.8567L12.7883 11.8095ZM13.8623 15.1435L12.237 13.4765L11.163 14.5237L12.7883 16.1907L13.8623 15.1435ZM16.575 6.25012H14.625V7.75012H16.575V6.25012ZM6.82501 7.75012H8.77501V6.25012H6.82501V7.75012ZM7.63719 9.75012H15.7628V8.25012H7.63719V9.75012ZM15.7628 9.75012C15.7739 9.75012 15.7864 9.75363 15.8001 9.76768C15.8142 9.78206 15.825 9.80384 15.825 9.83312H17.325C17.325 8.97687 16.6434 8.25012 15.7628 8.25012V9.75012ZM15.825 9.83312V16.5001H17.325V9.83312H15.825ZM15.825 16.5001C15.825 17.4846 15.0517 18.2501 14.1375 18.2501V19.7501C15.9157 19.7501 17.325 18.277 17.325 16.5001H15.825ZM14.1375 18.2501H9.26251V19.7501H14.1375V18.2501ZM9.26251 18.2501C8.82117 18.2501 8.39395 18.0705 8.07594 17.7443L7.00194 18.7915C7.59816 19.403 8.41092 19.7501 9.26251 19.7501V18.2501ZM8.07594 17.7443C7.7573 17.4175 7.57501 16.9703 7.57501 16.5001H6.07501C6.07501 17.356 6.40634 18.1806 7.00194 18.7915L8.07594 17.7443ZM7.57501 16.5001V9.83312H6.07501V16.5001H7.57501ZM7.57501 9.83312C7.57501 9.80384 7.58587 9.78206 7.59989 9.76768C7.61359 9.75363 7.62614 9.75012 7.63719 9.75012V8.25012C6.75664 8.25012 6.07501 8.97687 6.07501 9.83312H7.57501Z" fill="#333"></path></g></svg>
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
      formData.append("payer_type", document.getElementById("payer_type")?.value || 'individual');
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
