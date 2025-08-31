document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById('construction');
    const cardsWrap = document.getElementById('construction_cards');
    if (!select || !cardsWrap) return;

    // Спрячем селект визуально, но оставим в DOM
    select.classList.add('sr-only');

    // Карточка по option'у
    const makeCard = (opt) => {
        const value = opt.value;
        const label = opt.textContent.trim();
        const img = opt.dataset.img || '';
        const anim = opt.dataset.anim || '';

        const card = document.createElement('button');
        card.type = 'button';
        card.className = 'construction-card';
        card.dataset.value = value;
        card.innerHTML = `
            <div class="pic">
                <img class="static" src="${img}" alt="${label}">
                ${anim ? `<video class="anim" alt="" autoplay loop muted playsinline>
                    <source src="${anim}" type="video/webm">
                </video>` : ''}
            </div>
            <div class="caption">${label}</div>
        `;
        return card;
    };

    // Неактивная карточка «заглушка»
    const makeComingSoonCard = () => {
        const stub = document.createElement('button');
        stub.type = 'button';
        stub.className = 'construction-card is-disabled coming-soon';
        stub.disabled = true;
        stub.setAttribute('aria-disabled', 'true');
        stub.setAttribute('tabindex', '-1');
        stub.innerHTML = `
            <div class="caption">Больше <br>конструкций <br>скоро</div>
        `;
        return stub;
    };

    // Рендерим карточки из options
    const options = Array.from(select.options);
    options.forEach(opt => cardsWrap.appendChild(makeCard(opt)));

    // Добавляем заглушку в конец
    cardsWrap.appendChild(makeComingSoonCard());

    // Активное состояние
    const setActive = (value) => {
        cardsWrap.querySelectorAll('.construction-card').forEach(c => {
            // заглушка никогда не активна
            if (c.classList.contains('is-disabled')) {
                c.classList.remove('active');
                return;
            }
            c.classList.toggle('active', c.dataset.value === value);
        });
    };

    // Инициализация active по текущему значению селекта
    setActive(select.value);

    // Клик по карточке → меняем select.value + шлём change
    cardsWrap.addEventListener('click', (e) => {
        const card = e.target.closest('.construction-card');
        if (!card || card.classList.contains('is-disabled') || card.disabled) return;

        const value = card.dataset.value;
        if (select.value !== value) {
            select.value = value;
            select.dispatchEvent(new Event('input', { bubbles: true }));
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }
        setActive(value);
    });

    // Если кто-то поменял select программно — подсветим карточку
    select.addEventListener('change', () => setActive(select.value));
});


const colorSelect = document.getElementById('color');
const colorCardsWrap = document.getElementById('color_cards');
if (colorSelect && colorCardsWrap) {
    // Прячем селект
    colorSelect.classList.add('sr-only');

    // Рендерим карточки
    const makeColorCard = (opt) => {
        const value = opt.value;
        const label = opt.textContent.trim();
        const img = opt.dataset.img || '';

        const card = document.createElement('button');
        card.type = 'button';
        card.className = 'color-card';
        card.dataset.value = value;
        card.innerHTML = `
            <div class="pic">
                <img src="${img}" alt="${label}">
            </div>
            <div class="caption">${label}</div>
        `;
        return card;
    };

    const options = Array.from(colorSelect.options);
    options.forEach(opt => colorCardsWrap.appendChild(makeColorCard(opt)));

    const setActiveColor = (value) => {
        colorCardsWrap.querySelectorAll('.color-card').forEach(c => {
            c.classList.toggle('active', c.dataset.value === value);
        });
    };

    setActiveColor(colorSelect.value);

    // Клик по карточке → меняем select.value + события
    colorCardsWrap.addEventListener('click', (e) => {
        const card = e.target.closest('.color-card');
        if (!card) return;
        const value = card.dataset.value;
        if (colorSelect.value !== value) {
            colorSelect.value = value;
            colorSelect.dispatchEvent(new Event('input', { bubbles: true }));
            colorSelect.dispatchEvent(new Event('change', { bubbles: true }));
        }
        setActiveColor(value);
    });

    // Если select изменился извне — обновляем выделение
    colorSelect.addEventListener('change', () => setActiveColor(colorSelect.value));
}
