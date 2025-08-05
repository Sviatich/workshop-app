document.addEventListener("DOMContentLoaded", () => {
    const fields = ["construction", "length", "width", "height", "color", "tirage"];
    let debounceTimer;

    async function recalc() {
        const data = {};
        let allFilled = true;

        fields.forEach(id => {
            let value = document.getElementById(id).value;

            if (value === "" || value === null) {
                allFilled = false;
            }

            // Приведение числовых значений к числу
            if (id !== "construction" && id !== "color") {
                value = Number(value);
            }

            data[id] = value;
        });

        if (!allFilled) {
            clearResult();
            return; // не отправляем запрос, пока все поля не заполнены
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
                return;
            }

            const result = await res.json();

            if (result.error) {
                clearResult();
                return;
            }

            document.getElementById("price_per_unit").textContent = result.price_per_unit;
            document.getElementById("total_price").textContent = result.total_price;
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;
        } catch (err) {
            console.error("Ошибка расчёта:", err);
            clearResult();
        }
    }

    function clearResult() {
        document.getElementById("price_per_unit").textContent = "—";
        document.getElementById("total_price").textContent = "—";
        document.getElementById("weight").textContent = "—";
        document.getElementById("volume").textContent = "—";
    }

    // Пересчёт с задержкой
    fields.forEach(id => {
        document.getElementById(id).addEventListener("input", () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(recalc, 300);
        });
    });

    // Первый расчёт при загрузке
    recalc();
});
