// /js/modal.js
(() => {
  if (window.UIModal) return; // avoid double-init if Vite already loaded it
  let activeBackdrop = null;
  let lastFocused = null;

  const FOCUSABLE = [
    'a[href]', 'button:not([disabled])', 'input:not([disabled])',
    'select:not([disabled])', 'textarea:not([disabled])',
    '[tabindex]:not([tabindex="-1"])'
  ].join(',');

  function $(sel, ctx=document) { return ctx.querySelector(sel); }
  function cloneTpl(id) { const t = document.getElementById(id); return t ? t.content.cloneNode(true) : null; }

  function setAria(modalEl, titleText) {
    const titleEl = $('[data-field="title"]', modalEl);
    const header = $('[data-section="header"]', modalEl);
    if (titleText && titleEl) {
      header.hidden = false;
      titleEl.textContent = titleText;
      modalEl.setAttribute('aria-labelledby', 'ui-modal-title');
      modalEl.removeAttribute('aria-label');
    } else {
      header.hidden = true;
      modalEl.removeAttribute('aria-labelledby');
      if (titleText) modalEl.setAttribute('aria-label', titleText);
    }
  }

  function sanitizeHTML(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function fillSection(modalEl, dataset) {
    modalEl.querySelectorAll('[data-section]').forEach(s => s.hidden = true);

    const type = (dataset.modalType || '').toLowerCase();
    const section = modalEl.querySelector(`[data-section="${type}"]`);
    if (!section) return;

    setAria(modalEl, dataset.title || '');

    if (type === 'text') {
      const el = section.querySelector('[data-field="text"]');
      if (el) {
        const raw = dataset.text || '';
        el.innerHTML = sanitizeHTML(raw);
      }
    }

    if (type === 'photo') {
      const img = section.querySelector('[data-field="imgSrc"]');
      const caption = section.querySelector('[data-field="caption"]');
      if (img) {
        const src = dataset.imgSrc || '';
        const alt = dataset.imgAlt || '';
        img.setAttribute('src', src);
        img.setAttribute('alt', alt);
      }
      if (caption) caption.textContent = dataset.caption || '';
    }

    if (type === 'video') {
      const iframe = section.querySelector('[data-field="videoSrc"]');
      const text = section.querySelector('[data-field="videoText"]');
      if (iframe) iframe.setAttribute('src', dataset.videoSrc || '');
      if (text) text.innerHTML = sanitizeHTML(dataset.videoText || '');
    }

    if (type === 'html') {
      const htmlBox = section.querySelector('[data-field-html="html"]');
      if (htmlBox) {
        if (dataset.htmlSelector) {
          const srcEl = document.querySelector(dataset.htmlSelector);
          if (srcEl) htmlBox.appendChild(srcEl.cloneNode(true));
          else htmlBox.textContent = `Элемент ${dataset.htmlSelector} не найден`;
        } else if (dataset.html) {
          htmlBox.innerHTML = dataset.html;
        } else {
          htmlBox.textContent = 'Пусто';
        }
      }
    }

    section.hidden = false;
  }

  function trapFocus(e, modalEl) {
    const focusables = Array.from(modalEl.querySelectorAll(FOCUSABLE));
    if (!focusables.length) return;
    const first = focusables[0];
    const last = focusables[focusables.length - 1];
    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus({ preventScroll: true });
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus({ preventScroll: true });
    }
  }

  function mountModal(contentFragment, dataset) {
    const shell = cloneTpl('ui-modal');
    if (!shell) return null;

    const backdrop = shell.querySelector('[data-modal-backdrop]');
    const modalEl = shell.querySelector('[role="dialog"]');
    const closeBtn = shell.querySelector('[data-modal-close]');

    modalEl.querySelectorAll('[data-section]').forEach(s => s.hidden = true);

    if (contentFragment) {
      const htmlSection = modalEl.querySelector('[data-section="html"]');
      const htmlBox = htmlSection.querySelector('[data-field-html="html"]');
      htmlBox.appendChild(contentFragment);
      htmlSection.hidden = false;
      setAria(modalEl, dataset?.title || '');
    } else {
      fillSection(modalEl, dataset || {});
    }

    backdrop.dataset.state = 'opening';
    requestAnimationFrame(() => backdrop.dataset.state = 'open');

    const onClose = () => closeModal(backdrop);
    closeBtn.addEventListener('click', onClose);

    backdrop.addEventListener('mousedown', (e) => {
      if (e.target === backdrop) backdrop.dataset.pointerDownOnBackdrop = '1';
    });
    backdrop.addEventListener('mouseup', (e) => {
      if (e.target === backdrop && backdrop.dataset.pointerDownOnBackdrop === '1') onClose();
      delete backdrop.dataset.pointerDownOnBackdrop;
    });

    const onKey = (e) => {
      if (e.key === 'Escape') onClose();
      if (e.key === 'Tab') trapFocus(e, modalEl);
    };
    document.addEventListener('keydown', onKey);

    backdrop.addEventListener('modal:cleanup', () => {
      document.removeEventListener('keydown', onKey);
      modalEl.querySelectorAll('iframe').forEach(f => {
        const src = f.getAttribute('src');
        f.setAttribute('src', src || '');
      });
    });

    document.body.appendChild(backdrop);
    document.body.classList.add('modal-open');

    modalEl.focus({ preventScroll: true });
    const focusables = modalEl.querySelectorAll(FOCUSABLE);
    if (focusables.length) focusables[0].focus({ preventScroll: true });

    activeBackdrop = backdrop;
    return backdrop;
  }

  function closeModal(backdrop) {
    if (!backdrop) return;
    backdrop.dataset.state = 'closing';

    const cleanup = () => {
      backdrop.dispatchEvent(new CustomEvent('modal:cleanup'));
      backdrop.remove();
      document.body.classList.remove('modal-open');
      activeBackdrop = null;
      if (lastFocused && typeof lastFocused.focus === 'function') {
        lastFocused.focus({ preventScroll: true });
      }
    };

    const t = setTimeout(cleanup, 160);
    backdrop.addEventListener('transitionend', () => { clearTimeout(t); cleanup(); }, { once: true });
  }

  window.UIModal = {
    openFromDataset(datasetLike) {
      lastFocused = document.activeElement;
      mountModal(null, datasetLike);
    },
    open(options) {
      const ds = {
        modalType: options.type,
        title: options.title,
        text: options.text,
        imgSrc: options.imgSrc,
        imgAlt: options.imgAlt,
        caption: options.caption,
        videoSrc: options.videoSrc,
        videoText: options.videoText,
        html: options.html,
        htmlSelector: options.htmlSelector
      };
      this.openFromDataset(ds);
    },
    openHTML(html, { title } = {}) {
      lastFocused = document.activeElement;
      const frag = document.createRange().createContextualFragment(html);
      mountModal(frag, { title, modalType: 'html' });
    },
    close() { closeModal(activeBackdrop); }
  };

  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-modal-open]');
    if (!trigger) return;
    e.preventDefault();
    lastFocused = document.activeElement;
    const ds = trigger.dataset;
    window.UIModal.openFromDataset(ds);
  });
})();
