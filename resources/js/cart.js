document.addEventListener("DOMContentLoaded", () => {
    const cartItemsContainer = document.getElementById("cart_items");
    const cartSummary = document.getElementById("cart_summary");
    const emptyCart = document.getElementById("empty_cart");
    const cartTotalElem = document.getElementById("cart_total");
    const payerTypeSelect = document.getElementById("payer_type");
    const innField = document.getElementById("inn_field");

    let cart = JSON.parse(localStorage.getItem("cart") || "[]");

    payerTypeSelect.addEventListener("change", () => {
        innField.classList.toggle("hidden", payerTypeSelect.value !== "company");
    });

    function renderCart() {
        cartItemsContainer.innerHTML = "";

        if (cart.length === 0) {
            cartSummary.classList.add("hidden");
            emptyCart.classList.remove("hidden");
            return;
        }

        let total = 0;

        cart.forEach((item, index) => {
            total += item.total_price;

            const div = document.createElement("div");
            div.className = "p-4 border rounded bg-white";

            let html = `
            <p><strong>${item.construction_name}</strong> — ${item.length} × ${item.width} × ${item.height} мм</p>
            <p>Цвет: ${item.color_name}</p>
            <p>Тираж: ${item.tirage}</p>
            <p>Цена за штуку: ${item.price_per_unit} ₽</p>
            <p>Общая цена: ${item.total_price} ₽</p>
            ${item.fullprint?.enabled && item.total_price === 0 ? `
                <p class="text-orange-600 font-semibold mt-1">
                    Цена будет рассчитана менеджером индивидуально после оформления заказа.
                </p>` : ""}
        `;

            if (item.logo?.enabled) {
                html += `
                <p class="mt-2"><strong>Логотип:</strong> да (размер: ${item.logo.size || "не указан"})</p>
            `;
                if (item.logo.filename) {
                    html += `<p class="text-sm text-gray-600">Файл: ${item.logo.filename}</p>`;
                }
                if (item.logo.file_path && item.logo.file_path.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
                    html += `<img src="${item.logo.file_path}" alt="Логотип" class="mt-2 max-w-[200px] rounded border">`;
                }
            }

            if (item.fullprint?.enabled) {
                html += `<p class="mt-2"><strong>Полноформатная печать:</strong> да</p>`;
                if (item.fullprint.description) {
                    html += `<p class="text-sm text-gray-600">Комментарий: ${item.fullprint.description}</p>`;
                }
                if (item.fullprint.filename) {
                    html += `<p class="text-sm text-gray-600">Файл: ${item.fullprint.filename}</p>`;
                }
            }

            html += `
            <button class="mt-4 px-3 py-1 bg-red-500 text-white rounded remove_item" data-index="${index}">
                Удалить
            </button>
        `;

            div.innerHTML = html;
            cartItemsContainer.appendChild(div);
        });

        cartTotalElem.textContent = total.toFixed(2);
        cartSummary.classList.remove("hidden");
        emptyCart.classList.add("hidden");

        document.querySelectorAll(".remove_item").forEach(btn => {
            btn.addEventListener("click", () => {
                const idx = btn.dataset.index;
                cart.splice(idx, 1);
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCart();
                CartUI.update();
            });
        });
    }


    renderCart();

    document.getElementById("order_form").addEventListener("submit", async (e) => {
        e.preventDefault();

        if (cart.length === 0) {
            alert("Корзина пуста.");
            return;
        }

        const formData = new FormData();
        formData.append("payer_type", document.getElementById("payer_type").value);
        formData.append("full_name", document.getElementById("full_name").value);
        formData.append("email", document.getElementById("email").value);
        formData.append("phone", document.getElementById("phone").value);
        formData.append("inn", document.getElementById("inn").value);
        formData.append("delivery_address", document.getElementById("delivery_address").value);
        formData.append("delivery_method_id", Number(document.getElementById("delivery_method_id").value));
        formData.append("cart", JSON.stringify(cart));

        cart.forEach((item, index) => {
            if (item.logo?.file) {
                const input = document.querySelector(`#logo_file_${index}`);
                if (input?.files[0]) {
                    formData.append(`logo_file_${index}`, input.files[0]);
                }
            }

            if (item.fullprint?.file) {
                const input = document.querySelector(`#print_file_${index}`);
                if (input?.files[0]) {
                    formData.append(`print_file_${index}`, input.files[0]);
                }
            }
        });

        try {
            const res = await fetch("/api/order", {
                method: "POST",
                body: formData,
            });

            const result = await res.json();

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
});
