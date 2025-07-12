document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('configurator-form');
    const calculateBtn = document.getElementById('calculate-button');
    const checkoutBtn = document.getElementById('checkout-button');
    const result = document.getElementById('result');
    const quantitySelect = document.querySelector('select[name="quantity"]');
    const designBlock = document.getElementById('design-options');
    const printTypeRadios = document.querySelectorAll('input[name="print_type"]');
    const printSizeBlock = document.getElementById('print-size-block');

    // Если это не страница конфигуратора — ничего не делаем
    if (!form || !calculateBtn || !checkoutBtn || !result) return;

    // При изменении тиража показываем/скрываем блок оформления
    if (quantitySelect && designBlock) {
        quantitySelect.addEventListener('change', () => {
            const qty = parseInt(quantitySelect.value);
            designBlock.style.display = qty > 25 ? 'block' : 'none';
        });
    }

    // При изменении типа печати показываем/скрываем размеры печати
    if (printTypeRadios.length > 0 && printSizeBlock) {
        printTypeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                printSizeBlock.style.display =
                    (radio.value === 'print' || radio.value === 'sticker') ? 'block' : 'none';
            });
        });
    }

    // Кнопка "Рассчитать"
    calculateBtn.addEventListener('click', async () => {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error('Ошибка расчёта');
            }

            const json = await response.json();

            result.innerHTML = `
                <p>Цена за коробку: ${json.price_per_box} ₽</p>
                <p>Общая стоимость: ${json.total_price} ₽</p>
                <p>Вес: ${json.weight} кг</p>
                <p>Объём: ${json.volume} м³</p>
            `;

            // Сохраняем всё в глобальную переменную
            window.lastCalculation = {
                ...data,
                ...json
            };
        } catch (error) {
            alert('Ошибка при расчёте. Проверьте введённые данные.');
            console.error(error);
        }
    });

    // Кнопка "Оформить заказ"
    checkoutBtn.addEventListener('click', async (e) => {
        e.preventDefault();
    
        if (!window.lastCalculation) {
            alert('Сначала рассчитайте заказ');
            return;
        }
    
        try {
            // Убираем файл из передаваемых данных
            const { design_file, ...cleanData } = window.lastCalculation;
    
            const response = await fetch('/checkout/store-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(cleanData)
            });
    
            if (response.ok) {
                window.location.href = '/checkout';
            } else {
                alert('Ошибка при подготовке оформления заказа.');
                console.error(await response.text());
            }
        } catch (error) {
            alert('Сетевая ошибка при оформлении заказа.');
            console.error(error);
        }
    });
});
