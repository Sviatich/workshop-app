(() => {
  if (window.__contactFormInitDone) return;
  window.__contactFormInitDone = true;
  // Open modal with contact form when clicking the button
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-contact-form-open]');
    if (!btn) return;
    e.preventDefault();

    const tplSel = btn.getAttribute('data-template-id');
    const title = btn.getAttribute('data-title') || '';
    const tpl = tplSel ? document.querySelector(tplSel) : null;
    if (!tpl) return console.warn('Contact form template not found:', tplSel);

    const html = tpl.innerHTML;
    if (window.UIModal) {
      window.UIModal.openHTML(html, { title });
    }
  });

  // AJAX submit handler for forms marked with data-contact-form
  async function handleSubmit(e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (!form.matches('[data-contact-form]')) return;
    e.preventDefault();

    const statusEl = form.querySelector('[data-contact-form-status]');
    const submitBtn = form.querySelector('button[type="submit"]');

    const fd = new FormData(form);

    try {
      submitBtn && (submitBtn.disabled = true);
      statusEl && (statusEl.textContent = 'Отправляем...');

      const res = await fetch(form.action, {
        method: 'POST',
        body: fd,
        credentials: 'same-origin',
        headers: { 'Accept': 'application/json' }
      });

      if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        const msg = data?.message || 'Не удалось отправить. Попробуйте позже.';
        statusEl && (statusEl.textContent = msg);
        window.toast?.error?.(msg);
        return;
      }

      const data = await res.json().catch(() => ({}));
      const okMsg = data?.message || 'Сообщение отправлено';
      form.reset();
      statusEl && (statusEl.textContent = okMsg);
      window.toast?.success?.(okMsg);
      setTimeout(() => {
        statusEl && (statusEl.textContent = '');
        window.UIModal?.close?.();
      }, 700);
    } catch (err) {
      console.error(err);
      statusEl && (statusEl.textContent = 'Сбой сети');
      window.toast?.error?.('Сбой сети');
    } finally {
      submitBtn && (submitBtn.disabled = false);
    }
  }

  document.addEventListener('submit', handleSubmit);
})();
