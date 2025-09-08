document.addEventListener('DOMContentLoaded', () => {
  const tirage = document.querySelector('#tirage');
  const hasLogo = document.querySelector('#has_logo');
  const hasFullprint = document.querySelector('#has_fullprint');
  const logoOptions = document.querySelector('#logo_options');
  const fullprintOptions = document.querySelector('#fullprint_options');

  const show = el => el && el.classList.remove('hidden');
  const hide = el => el && el.classList.add('hidden');

  // ==== Создаём оверлей для полноформатной печати ====
  const fullprintBlock = hasFullprint.closest('.switch-block').parentElement;
  fullprintBlock.style.position = 'relative';

  const overlay = document.createElement('div');
  overlay.id = 'fullprint_overlay';
  overlay.className = `
    hidden absolute inset-0 flex items-center justify-center
    cursor-not-allowed z-10
  `;

  const overlayText = document.createElement('div');
  overlayText.className = 'overlay_text text-center text-sm font-semibold text-yellow-800 px-2 flex gap-2';
  overlayText.innerHTML = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 12px;"><g><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10V7C5.5 5.27609 6.18482 3.62279 7.40381 2.40381C8.62279 1.18482 10.2761 0.5 12 0.5C13.7239 0.5 15.3772 1.18482 16.5962 2.40381C17.8152 3.62279 18.5 5.27609 18.5 7V10H19C20.6569 10 22 11.3431 22 13V20C22 21.6569 20.6569 23 19 23H5C3.34315 23 2 21.6569 2 20V13C2 11.3431 3.34315 10 5 10H5.5ZM9.52513 4.52513C10.1815 3.86875 11.0717 3.5 12 3.5C12.9283 3.5 13.8185 3.86875 14.4749 4.52513C15.1313 5.1815 15.5 6.07174 15.5 7V10H8.5V7C8.5 6.07174 8.86875 5.1815 9.52513 4.52513Z" fill="#ffffff"></path></g></svg> доступно от 350 шт';

  overlay.appendChild(overlayText);
  fullprintBlock.appendChild(overlay);

  const clearLogoFields = () => {
    document.querySelector('#logo_file').value = '';
    document.querySelector('#logo_status').textContent = '';
    const preview = document.querySelector('#logo_preview');
    preview.src = '';
    hide(preview);
    document.querySelector('#logo_size').selectedIndex = 0;
  };

  const clearFullprintFields = () => {
    document.querySelector('#print_file').value = '';
    document.querySelector('#print_status').textContent = '';
    const preview = document.querySelector('#print_preview');
    preview.src = '';
    hide(preview);
    document.querySelector('#print_description').value = '';
  };

  const updateFullprintAvailability = () => {
    const value = parseInt(tirage.value, 10);
    const allow = value >= 350;

    hasFullprint.disabled = !allow;
    if (!allow) {
      overlay.classList.remove('hidden');
      if (hasFullprint.checked) {
        hasFullprint.checked = false;
        clearFullprintFields();
        hide(fullprintOptions);
      }
    } else {
      overlay.classList.add('hidden');
    }
  };

  const onLogoToggle = () => {
    if (hasLogo.checked) {
      if (hasFullprint.checked) {
        hasFullprint.checked = false;
        clearFullprintFields();
        hide(fullprintOptions);
      }
      show(logoOptions);
    } else {
      hide(logoOptions);
      clearLogoFields();
    }
  };

  const onFullprintToggle = () => {
    if (hasFullprint.checked) {
      if (hasLogo.checked) {
        hasLogo.checked = false;
        clearLogoFields();
        hide(logoOptions);
      }
      show(fullprintOptions);
    } else {
      hide(fullprintOptions);
      clearFullprintFields();
    }
  };

  tirage.addEventListener('change', updateFullprintAvailability);
  hasLogo.addEventListener('change', onLogoToggle);
  hasFullprint.addEventListener('change', onFullprintToggle);

  updateFullprintAvailability();
  if (hasLogo.checked) show(logoOptions);
  if (hasFullprint.checked) show(fullprintOptions);
});
