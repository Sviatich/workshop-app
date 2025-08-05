document.addEventListener("DOMContentLoaded", () => {
    const fields = ["construction", "length", "width", "height", "color", "tirage"];
    let debounceTimer;

    const nearestContainer = document.createElement("div");
    nearestContainer.id = "nearest_sizes";
    nearestContainer.className = "mt-4 p-3 border rounded bg-white";
    document.querySelector("#result").after(nearestContainer);

    async function recalc() {
        const data = {};
        let allFilled = true;

        fields.forEach(id => {
            let value = document.getElementById(id).value;

            if (value === "" || value === null) {
                allFilled = false;
            }

            if (id !== "construction" && id !== "color") {
                value = Number(value);
            }

            data[id] = value;
        });

        if (!allFilled) {
            clearResult();
            nearestContainer.innerHTML = "";
            return;
        }

        try {
            const res = await fetch("/api/calculate", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify(data),
            });

            if (!res.ok) {
                clearResult();
                nearestContainer.innerHTML = "";
                return;
            }

            const result = await res.json();

            if (result.error) {
                clearResult();
                nearestContainer.innerHTML = "";
                return;
            }

            // Заполняем результаты
            document.getElementById("price_per_unit").textContent = result.price_per_unit;
            document.getElementById("total_price").textContent = result.total_price;
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;

            // Если размер нестандартный
            if (!result.exact_match) {
                let html = `<p class="text-red-600 font-semibold mb-2">
                    Выбран нестандартный размер. К стоимости добавлено 5000 ₽.
                </p>`;

                // Если есть ближайшие размеры — добавляем список
                if (result.nearest_sizes && result.nearest_sizes.length > 0) {
                    html += `<h3 class="font-bold mb-2">Ближайшие размеры:</h3><ul class="space-y-1">`;

                    result.nearest_sizes.forEach(size => {
                        html += `<li class="flex items-center justify-between border-b pb-1">
                            <span>${size.length} × ${size.width} × ${size.height} мм</span>
                            <button class="px-2 py-1 bg-blue-500 text-white rounded text-sm"
                                data-length="${size.length}"
                                data-width="${size.width}"
                                data-height="${size.height}">
                                Подставить
                            </button>
                        </li>`;
                    });

                    html += `</ul>`;
                }

                nearestContainer.innerHTML = html;

                // Обработчики кнопок (если есть)
                nearestContainer.querySelectorAll("button").forEach(btn => {
                    btn.addEventListener("click", () => {
                        document.getElementById("length").value = btn.dataset.length;
                        document.getElementById("width").value = btn.dataset.width;
                        document.getElementById("height").value = btn.dataset.height;
                        recalc();
                    });
                });

            } else {
                nearestContainer.innerHTML = "";
            }

        } catch (err) {
            console.error("Ошибка расчёта:", err);
            clearResult();
            nearestContainer.innerHTML = "";
        }
    }

    function clearResult() {
        document.getElementById("price_per_unit").textContent = "—";
        document.getElementById("total_price").textContent = "—";
        document.getElementById("weight").textContent = "—";
        document.getElementById("volume").textContent = "—";
    }

    fields.forEach(id => {
        document.getElementById(id).addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(recalc, 300);
        });
    });

    recalc();
});
