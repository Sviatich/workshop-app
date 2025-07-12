document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('configurator-form');
    const result = document.getElementById('result');
    const quantitySelect = document.querySelector('select[name="quantity"]');
    const designBlock = document.getElementById('design-options');
    const printTypeRadios = document.querySelectorAll('input[name="print_type"]');
    const printSizeBlock = document.getElementById('print-size-block');
    const checkoutBtn = document.getElementById('checkout-button');

    checkoutBtn.style.display = 'none';

    let debounceTimeout = null;

    function updateResultPlaceholder() {
        result.innerHTML = `
            <p>Цена за коробку: —</p>
            <p>Общая стоимость: —</p>
            <p>Вес: —</p>
            <p>Объём: —</p>
        `;
    }

    function autoCalculate() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            const requiredFields = ['length', 'width', 'height', 'quantity', 'box_type_id'];
            const hasEmptyFields = requiredFields.some(field => !data[field] || isNaN(data[field]));

            if (hasEmptyFields) {
                updateResultPlaceholder();
                checkoutBtn.style.display = 'none';
                return;
            }

            fetch('/calculate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) throw new Error('Ошибка запроса');
                    return response.json();
                })
                .then(json => {
                    result.innerHTML = `
                        <p>Цена за коробку: ${json.price_per_box} ₽</p>
                        <p>Общая стоимость: ${json.total_price} ₽</p>
                        <p>Вес: ${json.weight} кг</p>
                        <p>Объём: ${json.volume} м³</p>
                    `;
                    checkoutBtn.style.display = 'inline-block';
                    window.lastCalculation = { ...data, ...json };
                })
                .catch(() => {
                    result.innerHTML = `
                        <p>Цена за коробку: расчёт...</p>
                        <p>Общая стоимость: расчёт...</p>
                        <p>Вес: расчёт...</p>
                        <p>Объём: расчёт...</p>
                    `;
                    checkoutBtn.style.display = 'none';
                });
        }, 400);
    }

    updateResultPlaceholder();

    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', autoCalculate);
        input.addEventListener('change', autoCalculate);
    });

    if (quantitySelect && designBlock) {
        quantitySelect.addEventListener('change', () => {
            const qty = parseInt(quantitySelect.value);
            designBlock.style.display = qty > 25 ? 'block' : 'none';
        });
    }

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
