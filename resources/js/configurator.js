document.addEventListener("DOMContentLoaded", () => {
    const fields = ["construction", "length", "width", "height", "color", "tirage"];
    let debounceTimer;

    // Visually hide weight and volume in results (still calculated)
    try {
        // document.getElementById('weight')?.closest('tr')?.classList.add('hidden');
        document.getElementById('volume')?.closest('tr')?.classList.add('hidden');
    } catch (_) {}

    const nearestContainer = document.createElement("div");
    nearestContainer.id = "nearest_sizes";
    nearestContainer.className = "bg-white";
    // Safely place the container after an anchor if present, otherwise append near results
    (function placeNearestContainer() {
        const anchor = document.querySelector("#nearest_sizes_block")
            || document.querySelector("#result")
            || document.querySelector("#configurator");
        if (anchor && typeof anchor.after === 'function') {
            anchor.after(nearestContainer);
        } else if (anchor && anchor.parentNode) {
            anchor.parentNode.appendChild(nearestContainer);
        } else {
            document.body.appendChild(nearestContainer);
        }
    })();

    function showCalcError(message) {
        const text = message || "Не удалось выполнить расчёт. Пожалуйста, измените размеры и попробуйте снова.";
        nearestContainer.innerHTML = `
            <p class="configurator-warning mb-3">${text}</p>
        `;
        try { toast.warning(text, { timeout: 6000 }); } catch (_) {}
    }

    const logoCheckbox = document.getElementById("has_logo");
    const printCheckbox = document.getElementById("has_fullprint");
    const logoInput = document.getElementById("logo_file");
    const logoStatus = document.getElementById("logo_status");
    const logoPreview = document.getElementById("logo_preview");
    const printInput = document.getElementById("print_file");
    const printStatus = document.getElementById("print_status");
    const printPreview = document.getElementById("print_preview");

    let lastCalcResult = null;
    let isCalculating = false;

    // Action button state (prevent adding while recalculating or invalid)
    const addToCartBtn = document.getElementById("add_to_cart");
    function inputsFilled() {
        return fields.every((id) => {
            const el = document.getElementById(id);
            if (!el) return false;
            const v = el.value;
            return !(v === "" || v === null);
        });
    }
    function setAddToCartEnabled(enabled) {
        if (!addToCartBtn) return;
        addToCartBtn.disabled = !enabled;
        addToCartBtn.setAttribute('aria-disabled', String(!enabled));
    }
    function updateAddToCartState() {
        const canEnable = inputsFilled() && !isCalculating;
        setAddToCartEnabled(canEnable);
    }

    // Loading shimmer toggling for result fields
    const resultFieldIds = ["price_per_unit", "total_price", "weight", "volume"];
    function setResultLoading(isLoading) {
        isCalculating = !!isLoading;
        updateAddToCartState();
        resultFieldIds.forEach((id) => {
            const el = document.getElementById(id);
            if (!el) return;
            if (isLoading) {
                const w = el.offsetWidth;
                el.style.display = 'inline-block';
                if (w) el.style.width = w + 'px';
                el.style.minWidth = '3ch';
                el.classList.add('shimmer');
                el.setAttribute('aria-busy', 'true');
            } else {
                el.classList.remove('shimmer');
                el.removeAttribute('aria-busy');
                el.style.minWidth = '';
                el.style.width = '';
                el.style.display = '';
            }
        });
    }

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
            isCalculating = false;
            updateAddToCartState();
            return;
        }

        setResultLoading(true);

        // Если включен полноцветный макет — обнуляем цену, показываем подсказку, но НЕ прерываем
        if (data.has_fullprint) {
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
                let msg = "";
                try { const j = await res.json(); msg = j?.error || j?.message || ""; } catch (_) {}
                showCalcError(msg);
                setResultLoading(false);
                setResultLoading(false);
                return;
            }

            const result = await res.json();
            lastCalcResult = result;

            document.getElementById("price_per_unit").textContent = "0";
            document.getElementById("total_price").textContent = "0";
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;
            setResultLoading(false);

            nearestContainer.innerHTML = `
                <p class="configurator-warning mb-3">
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
                let msg = "";
                try {
                    const j = await res.json();
                    if (j?.errors && typeof j.errors === 'object') {
                        // Collect first validation error message
                        const firstKey = Object.keys(j.errors)[0];
                        if (firstKey) msg = j.errors[firstKey]?.[0] || "";
                    }
                    msg = msg || j?.error || j?.message || "";
                } catch (_) {}
                showCalcError(msg || "Параметры не приняты сервером. Измените размеры и попробуйте снова.");
                return;
            }

            const result = await res.json();
            lastCalcResult = result;

            if (result.error) {
                clearResult();
                showCalcError(result.error);
                setResultLoading(false);
                return;
            }

            document.getElementById("price_per_unit").textContent = result.price_per_unit;
            document.getElementById("total_price").textContent = result.total_price;
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;

            if (!result.exact_match) {
                let html = `<p class="configurator-warning mb-3">
                    ⓘ Выбран нестандартный размер. В стоимость включена услуга изготовления штампа. Выберите размер из наличия чтоб не переплачивать.
                </p>`;

                if (result.nearest_sizes?.length > 0) {
                    html += `<h3 class="block mb-1 font-semibold">Размеры в наличии:</h3><ul class="space-y-1">`;
                    result.nearest_sizes.forEach(size => {
                        html += `<li class="flex items-center justify-between border-b pb-1">
                            <span>${size.length} × ${size.width} × ${size.height} мм</span>
                            <button class="px-2 py-1 bg-blue-500 text-white rounded btn-hover-effect cursor-pointer text-sm"
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

            setResultLoading(false);
        } catch (err) {
            console.error("Ошибка расчёта:", err);
            clearResult();
            nearestContainer.innerHTML = "";
            setResultLoading(false);
        }
    }

    function clearResult() {
        document.getElementById("price_per_unit").textContent = "—";
        document.getElementById("total_price").textContent = "—";
        document.getElementById("weight").textContent = "—";
        document.getElementById("volume").textContent = "—";
    }

    function resetFileInput(inputEl, statusEl, previewEl) {
        if (!inputEl) return;
        inputEl.value = "";
        if (inputEl.dataset) {
            delete inputEl.dataset.filePath;
            delete inputEl.dataset.filename;
        }
        if (statusEl) statusEl.innerHTML = "";
        if (previewEl) {
            previewEl.src = "";
            previewEl.classList.add("hidden");
        }
    }

    function setSelectToEmptyOrFirst(selectEl) {
        if (!selectEl) return;
        const emptyOpt = Array.from(selectEl.options).find(o => o.value === "");
        if (emptyOpt) {
            selectEl.value = "";
        } else {
            selectEl.selectedIndex = 0;
        }
        selectEl.dispatchEvent(new Event("change", { bubbles: true }));
    }

    function resetFormAfterAdd() {
        ["length", "width", "height", "tirage"].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.value = "";
                el.dispatchEvent(new Event("input", { bubbles: true }));
                el.dispatchEvent(new Event("change", { bubbles: true }));
            }
        });

        setSelectToEmptyOrFirst(document.getElementById("construction"));
        setSelectToEmptyOrFirst(document.getElementById("color"));

        if (logoCheckbox) {
            logoCheckbox.checked = false;
            document.getElementById("logo_options")?.classList.add("hidden");
        }
        if (printCheckbox) {
            printCheckbox.checked = false;
            document.getElementById("fullprint_options")?.classList.add("hidden");
        }

        resetFileInput(logoInput, logoStatus, logoPreview);
        resetFileInput(printInput, printStatus, printPreview);

        clearResult();
        nearestContainer.innerHTML = "";

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(recalc, 0);
    }

    // Слушатели
    [...fields.map(id => document.getElementById(id)), logoCheckbox, printCheckbox].forEach(input => {
        input?.addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(recalc, 300);
            isCalculating = true;
            updateAddToCartState();
        });
        input?.addEventListener("change", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(recalc, 300);
            isCalculating = true;
            updateAddToCartState();
        });
    });

    logoCheckbox.addEventListener("change", () => {
        const visible = logoCheckbox.checked;
        document.getElementById("logo_options").classList.toggle("hidden", !visible);

        if (!visible) {
            resetFileInput(logoInput, logoStatus, logoPreview);
        } else if (logoInput?.dataset?.filePath && logoPreview) {
            logoPreview.src = logoInput.dataset.filePath;
            logoPreview.classList.remove("hidden");
        }
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

            printStatus.innerHTML = `<span class="primary-text-color">Загружен файл: ${data.filename}</span>`;
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
                logoPreview.classList.remove("hidden");
            } else if (logoPreview) {
                logoPreview.src = "";
                logoPreview.classList.add("hidden");
            }

            logoStatus.innerHTML = `<span class="primary-text-color">Загружен файл: ${data.filename}</span>`;
        } catch (err) {
            console.error("Ошибка загрузки логотипа:", err);
            logoStatus.innerHTML = `<span class="text-red-600">Ошибка при загрузке</span>`;
        }
    });

    // Добавление в корзину
    document.getElementById("add_to_cart").addEventListener("click", () => {
        if (isCalculating) {
            try { toast.warning("Идёт расчёт. Пожалуйста, дождитесь завершения.", { timeout: 4000 }); } catch (_) {}
            return;
        }
        const config = {};
        let allFilled = true;

        fields.forEach(id => {
            let value = document.getElementById(id).value;
            if (value === "" || value === null) allFilled = false;
            if (id !== "construction" && id !== "color") value = Number(value);
            config[id] = value;
        });

        if (!allFilled) {
            toast.warning("Заполните все поля перед добавлением в корзину.", { timeout: 5000 });
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
        const selectedConstruction = constructionSelect.options[constructionSelect.selectedIndex];
        config.construction_name = selectedConstruction.text;
        // Persist the same image used in configurator cards
        config.construction_img = selectedConstruction.getAttribute('data-img') || '';

        const colorSelect = document.getElementById("color");
        const selectedColor = colorSelect.options[colorSelect.selectedIndex];
        config.color_name = selectedColor.text;
        // Persist color swatch image
        config.color_img = selectedColor.getAttribute('data-img') || '';

        config.price_per_unit = config.fullprint.enabled ? 0 : Number(document.getElementById("price_per_unit").textContent);
        config.total_price = config.fullprint.enabled ? 0 : Number(document.getElementById("total_price").textContent);
        config.weight = Number(document.getElementById("weight").textContent);
        config.volume = Number(document.getElementById("volume").textContent);

        // Persist flat-pack parcel geometry for shipping (from backend calculators)
        if (lastCalcResult) {
            if (typeof lastCalcResult.parcel_length_mm !== 'undefined') {
                config.parcel_length_mm = Number(lastCalcResult.parcel_length_mm);
            }
            if (typeof lastCalcResult.parcel_width_mm !== 'undefined') {
                config.parcel_width_mm = Number(lastCalcResult.parcel_width_mm);
            }
            if (typeof lastCalcResult.parcel_unit_height_mm !== 'undefined') {
                config.parcel_unit_height_mm = Number(lastCalcResult.parcel_unit_height_mm);
            }
        }

        let cart = JSON.parse(localStorage.getItem("cart") || "[]");
        cart.push(config);
        localStorage.setItem("cart", JSON.stringify(cart));

        toast.success("Товар добавлен в корзину!");

        resetFormAfterAdd();
        CartUI.update();
        updateAddToCartState();
    });

    updateAddToCartState();
    recalc();
});
