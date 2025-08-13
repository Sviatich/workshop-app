document.addEventListener("DOMContentLoaded", () => {
    const fields = ["construction", "length", "width", "height", "color", "tirage"];
    let debounceTimer;

    const nearestContainer = document.createElement("div");
    nearestContainer.id = "nearest_sizes";
    nearestContainer.className = "bg-white";
    document.querySelector("#nearest_sizes_block").after(nearestContainer);

    const logoCheckbox = document.getElementById("has_logo");
    const printCheckbox = document.getElementById("has_fullprint");
    const logoInput = document.getElementById("logo_file");
    const logoStatus = document.getElementById("logo_status");
    const logoPreview = document.getElementById("logo_preview");
    const printInput = document.getElementById("print_file");
    const printStatus = document.getElementById("print_status");
    const printPreview = document.getElementById("print_preview");

    async function recalc() {
        const data = {};
        let allFilled = true;

        fields.forEach(id => {
            let value = document.getElementById(id).value;
            if (value === "" || value === null) allFilled = false;
            if (id !== "construction" && id !== "color") value = Number(value);
            data[id] = value;
        });

        data.has_logo = logoCheckbox.checked;
        data.has_fullprint = printCheckbox.checked;

        if (!allFilled) {
            clearResult();
            nearestContainer.innerHTML = "";
            return;
        }

        // 💡 Если включен полноцветный макет — обнуляем цену, показываем подсказку, но НЕ прерываем
        if (data.has_fullprint) {
            // Фиктивный результат с весом и объемом
            const res = await fetch("/api/calculate", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({ ...data, fake_pricing: true }),
            });

            if (!res.ok) {
                clearResult();
                nearestContainer.innerHTML = "";
                return;
            }

            const result = await res.json();

            document.getElementById("price_per_unit").textContent = "0";
            document.getElementById("total_price").textContent = "0";
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;

            nearestContainer.innerHTML = `
                <p class="configurator-warning">
                    ⓘ Расчёт стоимости с полноцветной печатью будет выполнен менеджером после завершения оформления заказа.
                </p>`;

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

            document.getElementById("price_per_unit").textContent = result.price_per_unit;
            document.getElementById("total_price").textContent = result.total_price;
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;

            if (!result.exact_match) {
                let html = `<p class="configurator-warning">
                    ⓘ Выбран нестандартный размер. В стоимость включена услуга изготовления штампа. Выберите размер из наличия чтоб не переплачивать.
                </p>`;

                if (result.nearest_sizes?.length > 0) {
                    html += `<h3 class="block mb-1 font-semibold">Размеры в наличии:</h3><ul class="space-y-1">`;
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

                nearestContainer.querySelectorAll("button").forEach(btn => {
                    btn.addEventListener("click", (e) => {
                        e.preventDefault();
                        e.stopPropagation();
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

    // Слушатели
    [...fields.map(id => document.getElementById(id)), logoCheckbox, printCheckbox].forEach(input => {
        input?.addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(recalc, 300);
        });
        input?.addEventListener("change", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(recalc, 300);
        });
    });

    logoCheckbox.addEventListener("change", () => {
        document.getElementById("logo_options").classList.toggle("hidden", !logoCheckbox.checked);
    });

    printCheckbox.addEventListener("change", () => {
        document.getElementById("fullprint_options").classList.toggle("hidden", !printCheckbox.checked);
    });

    // Загрузка макета
    printInput?.addEventListener("change", async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append("file", file);

        printStatus.innerHTML = `Загрузка... <span class="inline-block w-4 h-4 border-2 border-blue-500 border-t-transparent animate-spin rounded-full ml-1"></span>`;

        try {
            const res = await fetch("/api/upload", { method: "POST", body: formData });
            const data = await res.json();

            if (!data.success) {
                printStatus.innerHTML = `<span class="text-red-600">Ошибка загрузки: ${data.error ?? "неизвестная"}</span>`;
                return;
            }

            e.target.dataset.filePath = data.file_path;
            e.target.dataset.filename = data.filename;

            if (printPreview && file.type.startsWith("image/")) {
                printPreview.src = data.file_path;
                printPreview.classList.remove("hidden");
            }

            printStatus.innerHTML = `<span class="text-green-700">Загружен файл: <strong>${data.filename}</strong></span>`;
        } catch (err) {
            console.error("Ошибка загрузки макета:", err);
            printStatus.innerHTML = `<span class="text-red-600">Ошибка при загрузке</span>`;
        }
    });

    // Загрузка логотипа
    logoInput?.addEventListener("change", async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append("file", file);

        logoStatus.innerHTML = `Загрузка... <span class="inline-block w-4 h-4 border-2 border-blue-500 border-t-transparent animate-spin rounded-full ml-1"></span>`;

        try {
            const res = await fetch("/api/upload", { method: "POST", body: formData });
            const data = await res.json();

            if (!data.success) {
                logoStatus.innerHTML = `<span class="text-red-600">Ошибка загрузки: ${data.error ?? "неизвестная"}</span>`;
                return;
            }

            e.target.dataset.filePath = data.file_path;
            e.target.dataset.filename = data.filename;

            if (logoPreview && file.type.startsWith("image/")) {
                logoPreview.src = data.file_path;
            }

            logoStatus.innerHTML = `<span class="text-green-700">Загружен файл: <strong>${data.filename}</strong></span>`;
        } catch (err) {
            console.error("Ошибка загрузки логотипа:", err);
            logoStatus.innerHTML = `<span class="text-red-600">Ошибка при загрузке</span>`;
        }
    });

    // Добавление в корзину
    document.getElementById("add_to_cart").addEventListener("click", () => {
        const config = {};
        let allFilled = true;

        fields.forEach(id => {
            let value = document.getElementById(id).value;
            if (value === "" || value === null) allFilled = false;
            if (id !== "construction" && id !== "color") value = Number(value);
            config[id] = value;
        });

        if (!allFilled) {
            alert("Заполните все поля перед добавлением в корзину.");
            return;
        }

        // Сохраняем флаги
        config.logo = logoCheckbox.checked ? {
            enabled: true,
            size: document.getElementById("logo_size").value,
            file_path: logoInput?.dataset.filePath ?? "",
            filename: logoInput?.dataset.filename ?? "",
        } : { enabled: false };

        config.fullprint = printCheckbox.checked ? {
            enabled: true,
            description: document.getElementById("print_description").value,
            file_path: printInput?.dataset.filePath ?? "",
            filename: printInput?.dataset.filename ?? "",
        } : { enabled: false };

        const constructionSelect = document.getElementById("construction");
        config.construction_name = constructionSelect.options[constructionSelect.selectedIndex].text;
        const colorSelect = document.getElementById("color");
        config.color_name = colorSelect.options[colorSelect.selectedIndex].text;

        config.price_per_unit = config.fullprint.enabled ? 0 : Number(document.getElementById("price_per_unit").textContent);
        config.total_price = config.fullprint.enabled ? 0 : Number(document.getElementById("total_price").textContent);
        config.weight = Number(document.getElementById("weight").textContent);
        config.volume = Number(document.getElementById("volume").textContent);

        let cart = JSON.parse(localStorage.getItem("cart") || "[]");
        cart.push(config);
        localStorage.setItem("cart", JSON.stringify(cart));

        alert("Товар добавлен в корзину!");
    });

    recalc();
});
