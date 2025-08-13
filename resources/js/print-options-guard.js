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
  overlayText.className = 'overlay_text text-center text-sm font-semibold text-yellow-800 px-2';
  overlayText.textContent = 'ⓘ доступно от 300 шт';

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
    const allow = value >= 300;

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
