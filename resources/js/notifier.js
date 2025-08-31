(() => {
  const HOST_ID = 'toast-host';
  function ensureHost() {
    let host = document.getElementById(HOST_ID);
    if (!host) {
      host = document.createElement('div');
      host.id = HOST_ID;
      host.className = 'toast-host';
      document.body.appendChild(host);
    }
    return host;
  }

  const ICONS = {
    success: '✔️',
    error: '⛔',
    info: 'ℹ️',
    warning: '⚠️',
  };

  function createToast(type, message, options = {}) {
    const {
      title = ({
        success: 'Готово',
        error: 'Ошибка',
        info: 'Сообщение',
        warning: 'Предупреждение'
      })[type],
      timeout = 3500,      // мс до автозакрытия
      closeOnClick = true, // клик по тосту закроет
    } = options;

    const host = ensureHost();
    const el = document.createElement('div');
    el.className = `toast toast--${type}`;
    el.setAttribute('role', 'status');
    el.setAttribute('aria-live', type === 'error' ? 'assertive' : 'polite');

    el.innerHTML = `
      <div class="toast__icon" aria-hidden="true">${ICONS[type] || '•'}</div>
      <div class="toast__content">
        <div class="toast__title">${title}</div>
        <div class="toast__msg">${message}</div>
      </div>
      <button class="toast__close" aria-label="Закрыть уведомление">✖</button>
      <div class="toast__progress"><i></i></div>
    `;

    // Закрытие
    const remove = () => {
      if (!el.isConnected) return;
      el.style.animation = 'toast-out .18s ease-in forwards';
      setTimeout(() => el.remove(), 180);
    };

    // Автозакрытие с прогрессом
    let remaining = timeout;
    let startedAt = Date.now();
    let rafId;

    const bar = el.querySelector('.toast__progress > i');
    function tick() {
      const elapsed = Date.now() - startedAt;
      const pct = Math.max(0, 1 - elapsed / remaining);
      bar.style.transform = `translateX(-${(1 - pct) * 100}%)`;
      if (elapsed >= remaining) {
        cancelAnimationFrame(rafId);
        remove();
      } else {
        rafId = requestAnimationFrame(tick);
      }
    }

    // Пауза при ховере/фокусе
    function pause() {
      el.dataset.paused = 'true';
      const elapsed = Date.now() - startedAt;
      remaining = Math.max(0, remaining - elapsed);
      cancelAnimationFrame(rafId);
    }
    function resume() {
      el.dataset.paused = 'false';
      startedAt = Date.now();
      rafId = requestAnimationFrame(tick);
    }

    el.addEventListener('mouseenter', pause);
    el.addEventListener('mouseleave', resume);
    el.addEventListener('focusin', pause);
    el.addEventListener('focusout', resume);

    // Клик по крестику/по тосту
    el.querySelector('.toast__close').addEventListener('click', remove);
    if (closeOnClick) {
      el.addEventListener('click', (e) => {
        // позволим кликнуть по ссылке внутри сообщения
        const a = e.target.closest('a');
        if (!a) remove();
      });
    }

    host.appendChild(el);
    rafId = requestAnimationFrame(tick);
    return { close: remove, el };
  }

  window.toast = {
    success: (msg, opts) => createToast('success', msg, opts),
    error:   (msg, opts) => createToast('error', msg, opts),
    info:    (msg, opts) => createToast('info', msg, opts),
    warning: (msg, opts) => createToast('warning', msg, opts),
  };
})();
