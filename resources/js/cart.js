document.addEventListener("DOMContentLoaded", () => {
    const cartItemsContainer = document.getElementById("cart_items");
    const cartSummary = document.getElementById("cart_summary");
    const emptyCart = document.getElementById("empty_cart");
    const cartTotalElem = document.getElementById("cart_total");
    const payerTypeSelect = document.getElementById("payer_type");
    const innField = document.getElementById("inn_field");

    let cart = JSON.parse(localStorage.getItem("cart") || "[]");

    // Показать поле ИНН только для юр. лица
    payerTypeSelect.addEventListener("change", () => {
        if (payerTypeSelect.value === "company") {
            innField.classList.remove("hidden");
        } else {
            innField.classList.add("hidden");
        }
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

            div.innerHTML = `
                <p><strong>${item.construction_name}</strong> — ${item.length} × ${item.width} × ${item.height} мм</p>
                <p>Цвет: ${item.color_name}</p>
                <p>Тираж: ${item.tirage}</p>
                <p>Цена за штуку: ${item.price_per_unit} ₽</p>
                <p>Общая цена: ${item.total_price} ₽</p>
                <button class="mt-2 px-3 py-1 bg-red-500 text-white rounded remove_item" data-index="${index}">
                    Удалить
                </button>
            `;

            cartItemsContainer.appendChild(div);
        });

        cartTotalElem.textContent = total.toFixed(2);
        cartSummary.classList.remove("hidden");
        emptyCart.classList.add("hidden");

        // Удаление
        document.querySelectorAll(".remove_item").forEach(btn => {
            btn.addEventListener("click", () => {
                const idx = btn.dataset.index;
                cart.splice(idx, 1);
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCart();
            });
        });
    }

    renderCart();

    // Отправка заказа
    document.getElementById("order_form").addEventListener("submit", async (e) => {
        e.preventDefault();

        if (cart.length === 0) {
            alert("Корзина пуста.");
            return;
        }

        const formData = {
            payer_type: document.getElementById("payer_type").value,
            full_name: document.getElementById("full_name").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            inn: document.getElementById("inn").value,
            delivery_address: document.getElementById("delivery_address").value,
            delivery_method_id: Number(document.getElementById("delivery_method_id").value),
            cart: cart
        };

        try {
            const res = await fetch("/api/order", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify(formData),
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
