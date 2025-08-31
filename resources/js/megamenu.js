(function () {
  // ——— DOM
  const megaBtn        = document.getElementById('mega-btn');
  const megaLayer      = document.getElementById('mega-catalog');
  const mobileToggle   = document.getElementById('mobile-menu-toggle');

  const contactsBtn    = document.getElementById('contacts-btn');
  const contactsPanel  = document.getElementById('contacts-panel');

  const cartBadges     = document.querySelectorAll('[data-cart-count]');
  const cartStatus     = document.getElementById('cart-status');

  // ——— Consts
  const MQ_DESKTOP = '(min-width: 880px)';
  const MQ_MOBILE  = '(max-width: 879.98px)';
  const HOVER_CLOSE_DELAY = 220; // ms
  const CART_KEYS = ['cart', 'cartItems', 'bw_cart']; // под свой ключ

  // ——— Utils
  const isDesktop = () => window.matchMedia(MQ_DESKTOP).matches;
  const isMobile  = () => window.matchMedia(MQ_MOBILE).matches;

  function lockScroll(lock) {
    if (isDesktop()) return; // блок скролла только на мобилке
    document.documentElement.style.overflow = lock ? 'hidden' : '';
  }

  // ——— Cart
  function getCartCount() {
    let count = 0;
    for (const k of CART_KEYS) {
      try {
        const raw = localStorage.getItem(k);
        if (!raw) continue;
        const data = JSON.parse(raw);
        if (Array.isArray(data)) count = Math.max(count, data.length);
        else if (data && Array.isArray(data.items)) count = Math.max(count, data.items.length);
      } catch (_) {}
    }
    return count;
  }
  function renderCartCount() {
    const n = getCartCount();
    cartBadges.forEach(b => b.textContent = n);
    if (cartStatus) cartStatus.textContent = n > 0 ? `В корзине позиций: ${n}` : 'Корзина пуста';
  }

  // ——— Mega menu state
  function openMega(open) {
    const expanded = !!open;
    if (!megaLayer || !megaBtn) return;
    megaLayer.hidden = !expanded;
    megaBtn.setAttribute('aria-expanded', String(expanded));
    if (mobileToggle) mobileToggle.setAttribute('aria-expanded', String(expanded));
    lockScroll(expanded);
  }

  // ——— Contacts dropdown state (desktop only)
  function openContacts(open) {
    if (!contactsBtn || !contactsPanel) return;
    const expanded = !!open;
    contactsPanel.hidden = !expanded;
    contactsBtn.setAttribute('aria-expanded', String(expanded));
  }
  function closeContacts(){ openContacts(false); }

  // ——— Init guards
  if (!megaBtn || !megaLayer) {
    console.warn('[header] Mega menu elements not found');
  }

  // ——— Events: cart
  renderCartCount();
  window.addEventListener('storage', renderCartCount);

  // ——— Events: mega menu toggles (click)
  if (megaBtn) {
    megaBtn.addEventListener('click', (e) => {
      e.preventDefault(); // не прыгать на #
      openMega(megaLayer.hidden);
    });
    megaBtn.addEventListener('keydown', (e) => {
      // Space/Enter: для <a> Enter уже кликает; Space поддержим вручную на десктопе
      if (isDesktop() && e.key === ' ') {
        e.preventDefault();
        openMega(megaLayer.hidden);
      }
    });
  }
  if (mobileToggle) {
    mobileToggle.addEventListener('click', () => openMega(megaLayer.hidden));
  }

  // ——— Hover/intent for desktop (no flicker between button & panel)
  let closeTimer = null;
  function scheduleMegaClose() {
    clearTimeout(closeTimer);
    closeTimer = setTimeout(() => { if (isDesktop()) openMega(false); }, HOVER_CLOSE_DELAY);
  }
  function cancelMegaClose() { clearTimeout(closeTimer); }

  if (megaBtn && megaLayer) {
    megaBtn.addEventListener('mouseenter', () => { if (isDesktop()) { cancelMegaClose(); openMega(true); }});
    megaBtn.addEventListener('mouseleave', () => { if (isDesktop()) scheduleMegaClose(); });
    megaBtn.addEventListener('focus',      () => { if (isDesktop()) { cancelMegaClose(); openMega(true); }});

    megaLayer.addEventListener('mouseenter', () => { if (isDesktop()) cancelMegaClose(); });
    megaLayer.addEventListener('mouseleave', () => { if (isDesktop()) scheduleMegaClose(); });
    megaLayer.addEventListener('focusout', (e) => {
      if (isDesktop()) {
        const next = e.relatedTarget;
        const within = next && (megaLayer.contains(next) || next === megaBtn);
        if (!within) scheduleMegaClose();
      }
    });
  }

  // ——— Close on outside click
  document.addEventListener('click', (e) => {
    const inMega = e.target.closest('#mega-catalog') || e.target.closest('#mega-btn') || e.target.closest('#mobile-menu-toggle');
    if (!inMega) openMega(false);

    const inContacts = e.target.closest('.has-contacts');
    if (!inContacts && isDesktop()) closeContacts();
  });

  // ——— ESC closes
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      openMega(false);
      closeContacts();
    }
  });

  // ——— Contacts behavior
  if (contactsBtn) {
    contactsBtn.addEventListener('click', (e) => {
      e.preventDefault(); // не прыгать на #
      if (isMobile()) {
        // На мобилке отдельной выпадашки нет — открываем мега-меню (в нём есть колонка "Контакты")
        openMega(true);
        return;
      }
      e.stopPropagation();
      openContacts(contactsPanel.hidden);
    });

    // Hover/intent (desktop) — отдельный таймер
    let contactsCloseTimer = null;
    function scheduleContactsClose() {
      clearTimeout(contactsCloseTimer);
      contactsCloseTimer = setTimeout(() => { if (isDesktop()) openContacts(false); }, HOVER_CLOSE_DELAY);
    }
    function cancelContactsClose() { clearTimeout(contactsCloseTimer); }

    contactsBtn.addEventListener('mouseenter', () => { if (isDesktop()) { cancelContactsClose(); openContacts(true); }});
    contactsBtn.addEventListener('mouseleave', () => { if (isDesktop()) scheduleContactsClose(); });
    contactsBtn.addEventListener('focus',      () => { if (isDesktop()) { cancelContactsClose(); openContacts(true); }});

    if (contactsPanel) {
      contactsPanel.addEventListener('mouseenter', () => { if (isDesktop()) cancelContactsClose(); });
      contactsPanel.addEventListener('mouseleave', () => { if (isDesktop()) scheduleContactsClose(); });
      contactsPanel.addEventListener('focusout', (e) => {
        if (isDesktop()) {
          const next = e.relatedTarget;
          const within = next && (contactsPanel.contains(next) || next === contactsBtn);
          if (!within) scheduleContactsClose();
        }
      });
    }

    // Поддержка Space на десктопе
    contactsBtn.addEventListener('keydown', (e) => {
      if (isDesktop() && e.key === ' ') {
        e.preventDefault();
        openContacts(contactsPanel.hidden);
      }
    });
  }

  // ——— Keep ARIA consistent on resize
  let resizeRAF = null;
  window.addEventListener('resize', () => {
    cancelAnimationFrame(resizeRAF);
    resizeRAF = requestAnimationFrame(() => {
      if (isMobile()) closeContacts(); // на мобилке выпадашка не нужна
      // мега-меню оставляем как есть
    });
  });

})();

// Функция обновления корзины, вызывается в других модулях проекта. 

(function () {
  const CART_KEYS = ['cart', 'cartItems', 'bw_cart']; // подстрой под свой ключ
  const badges = () => document.querySelectorAll('[data-cart-count]');
  const statusEl = () => document.getElementById('cart-status');
  let lastCount = -1;

  function readFromStorage() {
    let count = 0;
    for (const k of CART_KEYS) {
      try {
        const raw = localStorage.getItem(k);
        if (!raw) continue;
        const data = JSON.parse(raw);
        if (Array.isArray(data)) count = Math.max(count, data.length);
        else if (data && Array.isArray(data.items)) count = Math.max(count, data.items.length);
      } catch (_) {}
    }
    return count;
  }

  function coerceCount(arg) {
    if (typeof arg === 'number' && Number.isFinite(arg)) return Math.max(0, arg|0);
    if (Array.isArray(arg)) return arg.length;
    if (arg && Array.isArray(arg.items)) return arg.items.length;
    return readFromStorage();
  }

  function bump() {
    badges().forEach(b => {
      b.classList.remove('badge-bump');
      void b.offsetWidth; // перезапуск анимации
      b.classList.add('badge-bump');
    });
  }

  function render(n, { animate = true } = {}) {
    badges().forEach(b => b.textContent = n);
    const s = statusEl();
    if (s) s.textContent = n > 0 ? `В корзине позиций: ${n}` : 'Корзина пуста';
    if (animate) bump();
  }

  function update(arg, opts = {}) {
    const n = coerceCount(arg);
    if (!opts.force && n === lastCount) return n;
    lastCount = n;
    render(n, opts);
    return n;
  }

  // Авто-обновление при изменении LS из другой вкладки
  window.addEventListener('storage', () => update(undefined, { animate: false }));

  // Поддержка события (если удобнее бросать кастомное событие)
  window.addEventListener('cart:updated', (e) => update(e.detail?.count));

  // Экспорт в глобалку
  window.CartUI = {
    update,         
    readFromStorage,
  };

  // Первый рендер
  update();
})();