document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("configForm");

    const fields = ["construction", "length", "width", "height", "color", "tirage"];

    async function recalc() {
        const data = {};
        fields.forEach(id => {
            data[id] = document.getElementById(id).value;
        });

        try {
            const res = await fetch("/api/calculate", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify(data),
            });

            const result = await res.json();

            if (result.error) {
                document.getElementById("price_per_unit").textContent = "—";
                document.getElementById("total_price").textContent = "—";
                document.getElementById("weight").textContent = "—";
                document.getElementById("volume").textContent = "—";
                alert(result.error);
                return;
            }

            document.getElementById("price_per_unit").textContent = result.price_per_unit;
            document.getElementById("total_price").textContent = result.total_price;
            document.getElementById("weight").textContent = result.weight;
            document.getElementById("volume").textContent = result.volume;
        } catch (err) {
            console.error("Ошибка расчёта:", err);
        }
    }

    // Пересчёт при изменении любого поля
    fields.forEach(id => {
        document.getElementById(id).addEventListener("input", recalc);
    });

    // Первый расчёт при загрузке страницы
    recalc();
});
