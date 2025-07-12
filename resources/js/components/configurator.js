// resources/js/configurator.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('configurator-form');
    const result = document.getElementById('result');
    const quantitySelect = document.querySelector('select[name="quantity"]');
    const designBlock = document.getElementById('design-options');
    const printTypeRadios = document.querySelectorAll('input[name="print_type"]');
    const printSizeBlock = document.getElementById('print-size-block');
    const checkoutBtn = document.getElementById('checkout-button');

    let debounceTimeout = null;

    function autoCalculate() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            fetch('/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(json => {
                    result.innerHTML = `
                        <p>Цена за коробку: ${json.price_per_box} ₽</p>
                        <p>Общая стоимость: ${json.total_price} ₽</p>
                        <p>Вес: ${json.weight} кг</p>
                        <p>Объём: ${json.volume} м³</p>
                    `;
                    window.lastCalculation = { ...data, ...json };
                })
                .catch(() => {
                    result.innerHTML = '<p>Ошибка расчёта. Проверьте введённые данные.</p>';
                });
        }, 400);
    }

    // Подключаем автоматический пересчёт ко всем полям формы
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', autoCalculate);
        input.addEventListener('change', autoCalculate);
    });

    // Тираж > 25 — показываем блок дизайна
    if (quantitySelect && designBlock) {
        quantitySelect.addEventListener('change', () => {
            const qty = parseInt(quantitySelect.value);
            designBlock.style.display = qty > 25 ? 'block' : 'none';
        });
    }

    // Показ размеров печати при нужных вариантах
    if (printTypeRadios && printSizeBlock) {
        printTypeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                printSizeBlock.style.display =
                    (radio.value === 'print' || radio.value === 'sticker') ? 'block' : 'none';
            });
        });
    }

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await fetch('/checkout/store-data', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData
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
    }
});
