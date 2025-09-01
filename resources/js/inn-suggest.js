document.addEventListener('DOMContentLoaded', () => {
  const innInput = document.getElementById('inn');
  const payerTypeSelect = document.getElementById('payer_type');
  if (!innInput) return;

  const token = document.querySelector('meta[name="dadata-token"]')?.content?.trim();
  if (!token) return;

  const wrapper = innInput.parentElement;
  if (wrapper && !wrapper.classList.contains('relative')) {
    wrapper.classList.add('relative');
  }

  const dd = document.createElement('div');
  dd.id = 'inn_suggest_dropdown';
  dd.className = 'absolute left-0 right-0 z-30 mt-1 bg-white border rounded shadow max-h-60 overflow-auto hidden';
  if (wrapper) wrapper.appendChild(dd);

  let abortCtrl = null;
  let debTimeout = null;

  function hide() { dd.classList.add('hidden'); dd.innerHTML = ''; }
  function show() { if (dd.children.length) dd.classList.remove('hidden'); }

  async function loadSuggestions(q) {
    if (abortCtrl) abortCtrl.abort();
    abortCtrl = new AbortController();
    try {
      const res = await fetch('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Token ' + token,
        },
        body: JSON.stringify({ query: q, count: 7, status: [ 'ACTIVE' ] }),
        signal: abortCtrl.signal,
      });
      if (!res.ok) throw new Error('Dadata HTTP ' + res.status);
      const json = await res.json();
      return Array.isArray(json?.suggestions) ? json.suggestions : [];
    } catch (_) {
      return [];
    }
  }

  function render(items) {
    dd.innerHTML = '';
    if (!items.length) { hide(); return; }
    for (const it of items) {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'w-full text-left px-3 py-2 hover:bg-zinc-50 focus:bg-zinc-50';
      const name = it.value || it.data?.name?.short_with_opf || it.data?.name?.full_with_opf || '';
      const inn = it.data?.inn || '';
      const kpp = it.data?.kpp || '';
      const addr = it.data?.address?.value || '';
      b.dataset.inn = inn;
      b.innerHTML = `
        <div class="text-sm">
          <span class="font-medium">${name.replace(/</g,'&lt;')}</span>
          <span class="text-gray-500">ИНН ${inn}${kpp ? ', КПП '+kpp : ''}</span>
        </div>
        ${addr ? `<div class="text-xs text-gray-600 mt-0.5">${addr.replace(/</g,'&lt;')}</div>` : ''}
      `;
      b.addEventListener('click', () => {
        innInput.value = inn;
        hide();
        innInput.dispatchEvent(new Event('input'));
        innInput.blur();
      });
      dd.appendChild(b);
    }
    show();
  }

  async function onInput() {
    const q = innInput.value.trim();
    if (!q || q.length < 2) { hide(); return; }
    clearTimeout(debTimeout);
    debTimeout = setTimeout(async () => {
      const list = await loadSuggestions(q);
      render(list);
    }, 200);
  }

  document.addEventListener('click', (e) => {
    if (!dd.contains(e.target) && e.target !== innInput) hide();
  });
  if (payerTypeSelect) payerTypeSelect.addEventListener('change', hide);
  innInput.addEventListener('input', onInput);
  innInput.addEventListener('focus', onInput);
});

