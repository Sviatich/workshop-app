document.addEventListener('DOMContentLoaded', () => {
  // Locate existing CDEK option and its content block
  const cdekRadio = document.querySelector('input.delivery-choice[name="delivery_method_choice"][value="cdek"]');
  const cdekLabel = cdekRadio?.closest('label');
  const grid = cdekLabel?.parentElement;
  const cdekContainer = cdekLabel?.querySelector('#cdek_block');
  if (!cdekRadio || !cdekLabel || !cdekContainer || !grid) return;

  // Build courier label (second option)
  const courierLabel = document.createElement('label');
  courierLabel.className = 'delivery-option cursor-pointer border rounded p-4 flex gap-3 transition hover:shadow-md';
  courierLabel.innerHTML = `
    <input type="radio" name="delivery_method_choice" value="cdek_courier" class="sr-only peer delivery-choice">
    <span class="bullet"><span class="dot"></span></span>
    <div class="flex-1 space-y-2">
      <div class="flex items-center gap-2"><span class="font-medium">Курьер СДЭК</span></div>
      <p class="text-sm text-gray-600">Введите адрес — рассчитаем стоимость до двери.</p>
    </div>`;

  // Ensure the content block sits under the grid (not inside the first label)
  cdekContainer.remove();
  grid.appendChild(courierLabel);

  // Replace widget block with native PVZ + Courier UI
  const block = document.createElement('div');
  block.id = 'cdek_block';
  block.className = 'mt-2 hidden space-y-3';
  block.innerHTML = `
    <div id="cdek_pvz_mode" class="space-y-2">
      <div>
        <label class="block text-sm font-medium mb-1" for="cdek_city_input">Город</label>
        <div class="relative">
          <input type="text" id="cdek_city_input" class="border rounded w-full p-2" placeholder="Начните вводить город...">
          <div id="cdek_city_dropdown" class="absolute left-0 right-0 z-30 mt-1 bg-white border rounded shadow max-h-60 overflow-auto hidden"></div>
        </div>
      </div>
      <div id="cdek_pvz_map" style="height:320px" class="rounded border"></div>
      <div id="cdek_pvz_selected" class="text-sm text-gray-700"></div>
    </div>

    <div id="cdek_courier_mode" class="space-y-2 hidden">
      <div>
        <label class="block text-sm font-medium mb-1" for="cdek_courier_address">Адрес доставки</label>
        <div class="relative">
          <input type="text" id="cdek_courier_address" class="border rounded w-full p-2" placeholder="Город, улица, дом">
          <div id="cdek_addr_dropdown" class="absolute left-0 right-0 z-30 mt-1 bg-white border rounded shadow max-h-60 overflow-auto hidden"></div>
        </div>
      </div>
      <div id="cdek_courier_selected" class="text-sm text-gray-700"></div>
    </div>

    <div id="delivery_summary" class="text-sm text-gray-700"></div>`;
  grid.appendChild(block);

  const el = (id) => document.getElementById(id);
  const setVal = (id, val) => { const n = el(id); if (n) n.value = val ?? ''; };

  function updateGrandTotal() {
    const items = parseFloat((el('cart_total')?.textContent || '0').replace(',', '.')) || 0;
    const delivery = parseFloat((el('delivery_row_value')?.textContent || '0').replace(',', '.')) || 0;
    const g = (items + delivery).toFixed(2);
    const gEl = el('grand_total'); if (gEl) gEl.textContent = g;
  }
  function setDeliveryPrice(p) {
    const price = Number(p) || 0;
    const dEl = el('delivery_row_value'); if (dEl) dEl.textContent = price.toFixed(2);
    const hidden = el('delivery_price_input'); if (hidden) hidden.value = price.toFixed(2);
    updateGrandTotal();
  }
  function paintSummary(mode, tariff, addressText) {
    const summary = el('delivery_summary'); if (!summary) return;
    const way = mode === 'office' ? 'Доставка до ПВЗ' : 'Курьерская доставка';
    const price = Number(tariff?.delivery_sum) || 0;
    const pmin = tariff?.period_min ?? '';
    const pmax = tariff?.period_max ?? '';
    summary.textContent = `${way}${addressText ? ', ' + addressText : ''}: ${price.toFixed(2)} ₽, срок ${pmin}-${pmax} дн.`;
  }

  // Build parcels from cart
  function calcParcels() {
    const MIN_SIDE_MM = 100, MIN_HEIGHT_MM = 10, MAX_SIDE_MM = 1500, MIN_WEIGHT_G = 100, MAX_PARCEL_WEIGHT_G = 25000;
    let cart = [];
    try { cart = JSON.parse(localStorage.getItem('cart') || '[]') } catch(_){ }
    const units = [];
    for (const item of cart) {
      const tirage = Math.max(1, Number(item.tirage) || 1);
      let L = Number(item.parcel_length_mm), W = Number(item.parcel_width_mm), H = Number(item.parcel_unit_height_mm);
      if (!Number.isFinite(L) || L <= 0) L = MIN_SIDE_MM;
      if (!Number.isFinite(W) || W <= 0) W = MIN_SIDE_MM;
      if (!Number.isFinite(H) || H <= 0) H = 1.5;
      L = Math.min(MAX_SIDE_MM, Math.max(MIN_SIDE_MM, Math.round(L)));
      W = Math.min(MAX_SIDE_MM, Math.max(MIN_SIDE_MM, Math.round(W)));
      const totalItemWeightKg = Math.max(0, Number(item.weight) || 0);
      const unitWeightG = Math.max(MIN_WEIGHT_G, Math.round((totalItemWeightKg / tirage) * 1000));
      for (let i=0;i<tirage;i++) units.push({L,W,h:H,g:unitWeightG});
    }
    const parcels=[]; let current=null;
    for (const u of units) {
      if (!current) current = { length: u.L, width: u.W, height: 0, weight: 0 };
      const nextW = current.weight + u.g, nextH = current.height + u.h;
      if (nextW > MAX_PARCEL_WEIGHT_G || nextH > MAX_SIDE_MM) {
        if (current.weight > 0) parcels.push({ length: Math.max(MIN_SIDE_MM, Math.round(current.length)), width: Math.max(MIN_SIDE_MM, Math.round(current.width)), height: Math.max(MIN_HEIGHT_MM, Math.round(current.height)), weight: current.weight });
        current = { length: u.L, width: u.W, height: 0, weight: 0 };
      }
      current.length = Math.max(current.length, u.L);
      current.width  = Math.max(current.width,  u.W);
      current.height += u.h; current.weight += u.g;
    }
    if (current && current.weight > 0) parcels.push({ length: Math.max(MIN_SIDE_MM, Math.round(current.length)), width: Math.max(MIN_SIDE_MM, Math.round(current.width)), height: Math.max(MIN_HEIGHT_MM, Math.round(current.height)), weight: current.weight });
    return (parcels.length ? parcels : [{ length: 100, width: 100, height: 10, weight: 100 }])
      .map(p => ({ length: Math.max(1, Math.ceil(p.length/10)), width: Math.max(1, Math.ceil(p.width/10)), height: Math.max(1, Math.ceil(p.height/10)), weight: p.weight }));
  }

  // Yandex Maps v3
  const yaKey = document.querySelector('meta[name="yandex-maps-api-key"]')?.content?.trim();
  let yaLoading=null;
  function loadYMaps(){
    if(window.ymaps3?.ready) return Promise.resolve();
    if(yaLoading) return yaLoading;
    if(!yaKey) return Promise.reject(new Error('YANDEX_MAPS_API_KEY missing'));
    const s=document.createElement('script');
    s.src=`https://api-maps.yandex.ru/v3/?apikey=${encodeURIComponent(yaKey)}&lang=ru_RU`;
    s.async=true;
    yaLoading=new Promise((res,rej)=>{ s.onload=()=>res(); s.onerror=()=>rej(new Error('Yandex Maps load error')); });
    document.head.appendChild(s);
    return yaLoading;
  }
  async function renderPvzMap(center, points){
    const node = el('cdek_pvz_map'); if(!node) return;
    try{
      await loadYMaps(); await window.ymaps3.ready;
      const {YMap,YMapDefaultSchemeLayer,YMapDefaultFeaturesLayer,YMapMarker}=window.ymaps3;
      node.innerHTML='';
      const map=new YMap(node,{location:{center,zoom:12}});
      map.addChild(new YMapDefaultSchemeLayer());
      map.addChild(new YMapDefaultFeaturesLayer());
      (points||[]).forEach(p=>{
        if(p?.latitude==null||p?.longitude==null) return;
        const marker=document.createElement('div');
        marker.style.cssText='width:16px;height:16px;border-radius:8px;background:#0ea5e9;border:2px solid #fff;box-shadow:0 0 2px rgba(0,0,0,.3);cursor:pointer;';
        marker.title = `${p.name||''}\n${p.address||''}`;
        marker.addEventListener('click',()=>onPvzSelected(p));
        map.addChild(new YMapMarker({coordinates:[p.longitude,p.latitude]},marker));
      });
    } catch(e){ console.warn('Map init error',e); }
  }

  // API helpers
  async function apiGet(url){ const res = await fetch(url,{headers:{'Accept':'application/json'}}); if(!res.ok) throw new Error('HTTP '+res.status); return res.json(); }
  async function apiPost(url,body){ const res=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},body:JSON.stringify(body)}); if(!res.ok) throw new Error('HTTP '+res.status); return res.json(); }

  // Dadata suggestions for courier address
  const dadataToken = document.querySelector('meta[name="dadata-token"]')?.content?.trim();
  async function suggestAddress(q){
    if(!dadataToken) return [];
    try{
      const res=await fetch('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',{
        method:'POST',
        headers:{'Content-Type':'application/json','Accept':'application/json','Authorization':'Token '+dadataToken},
        body:JSON.stringify({query:q,count:7})
      });
      if(!res.ok) return [];
      const j=await res.json();
      return Array.isArray(j?.suggestions)?j.suggestions:[];
    }catch(_){ return []; }
  }

  // PVZ search dropdown
  const cityInput = el('cdek_city_input');
  const cityDD = el('cdek_city_dropdown');
  let cityTimer=null; let currentCity=null; let pvzList=[];
  function cityHide(){ if(cityDD){ cityDD.classList.add('hidden'); cityDD.innerHTML=''; } }
  function cityShow(){ if(cityDD && cityDD.children.length) cityDD.classList.remove('hidden'); }
  async function onCityInput(){
    const q = cityInput.value.trim();
    if(!q||q.length<2){ cityHide(); return; }
    clearTimeout(cityTimer);
    cityTimer=setTimeout(async()=>{
      try{
        const list=await apiGet('/api/sdek/cities?q='+encodeURIComponent(q));
        cityDD.innerHTML='';
        (list||[]).forEach(it=>{
          const b=document.createElement('button');
          b.type='button'; b.className='w-full text-left px-3 py-2 hover:bg-zinc-50 focus:bg-zinc-50';
          b.textContent=`${it.city||''}${it.region?' ('+it.region+')':''}`;
          b.addEventListener('click', async()=>{
            currentCity=it; cityInput.value=it.city||''; cityHide();
            pvzList=await apiGet('/api/sdek/pvz?city_code='+encodeURIComponent(it.code));
            const center=(it.longitude!=null&&it.latitude!=null)?[it.longitude,it.latitude]:[37.618423,55.751244];
            await renderPvzMap(center,pvzList);
          });
          cityDD.appendChild(b);
        });
        cityShow();
      }catch(_){ cityHide(); }
    },200);
  }
  if(cityInput){
    cityInput.addEventListener('input', onCityInput);
    cityInput.addEventListener('focus', onCityInput);
    document.addEventListener('click', (e)=>{ if(!cityDD.contains(e.target) && e.target!==cityInput) cityHide(); });
  }

  async function onPvzSelected(pvz){
    const selected = el('cdek_pvz_selected');
    if(selected) selected.textContent = `Выбран ПВЗ: ${pvz.name||''}, ${pvz.address||''}`;
    setVal('cdek_mode','office');
    setVal('cdek_pvz_code', pvz.code||'');
    setVal('cdek_pvz_address', pvz.address||'');
    setVal('cdek_recipient_address','');
    const methodCode = document.getElementById('delivery_method_code');
    if(methodCode) methodCode.value='cdek';
    const addrInput = el('delivery_address'); if(addrInput) addrInput.value = `СДЭК ПВЗ: ${pvz.address||''}`;
    try{
      const tariffRes=await apiPost('/api/sdek/calc/pvz',{ city_code: currentCity?.code, pvz_code: pvz.code, packages: calcParcels() });
      const t=tariffRes?.tariff||null;
      setDeliveryPrice(t?.delivery_sum||0);
      paintSummary('office', t, pvz.address||'');
      setVal('cdek_tariff_code', t?.tariff_code||'');
      setVal('cdek_tariff_name', t?.tariff_name||'');
      setVal('cdek_delivery_sum', t?.delivery_sum??'');
      setVal('cdek_period_min', t?.period_min??'');
      setVal('cdek_period_max', t?.period_max??'');
    }catch(e){ console.warn('PVZ calc error', e); setDeliveryPrice(0); }
  }

  // Courier suggestions and choose -> calc
  const addrInput = el('cdek_courier_address');
  const addrDD = el('cdek_addr_dropdown');
  function addrHide(){ if(addrDD){ addrDD.classList.add('hidden'); addrDD.innerHTML=''; } }
  function addrShow(){ if(addrDD && addrDD.children.length) addrDD.classList.remove('hidden'); }
  let addrTimer=null;
  async function onAddrInput(){
    const q = addrInput.value.trim();
    if(!q||q.length<3){ addrHide(); return; }
    clearTimeout(addrTimer);
    addrTimer=setTimeout(async()=>{
      const list = await suggestAddress(q);
      addrDD.innerHTML='';
      (list||[]).forEach(s=>{
        const b=document.createElement('button');
        b.type='button'; b.className='w-full text-left px-3 py-2 hover:bg-zinc-50 focus:bg-zinc-50';
        b.textContent = s.value || '';
        b.addEventListener('click', async()=>{
          addrInput.value = s.value || '';
          addrHide();
          const cs = el('cdek_courier_selected'); if(cs) cs.textContent = 'Адрес: ' + (s.value || '');
          setVal('cdek_mode','door');
          setVal('cdek_recipient_address', s.value || '');
          setVal('cdek_pvz_code',''); setVal('cdek_pvz_address','');
          const methodCode = document.getElementById('delivery_method_code'); if(methodCode) methodCode.value='cdek_courier';
          const da = el('delivery_address'); if(da) da.value = s.value || '';
          try{
            const fias = s.data?.fias_id || s.data?.fias_guid || '';
            const tariffRes = await apiPost('/api/sdek/calc/courier', { address: s.value || '', fias_guid: fias, packages: calcParcels() });
            const t = tariffRes?.tariff || null;
            setDeliveryPrice(t?.delivery_sum || 0);
            paintSummary('door', t, s.value || '');
            setVal('cdek_tariff_code', t?.tariff_code || '');
            setVal('cdek_tariff_name', t?.tariff_name || '');
            setVal('cdek_delivery_sum', t?.delivery_sum ?? '');
            setVal('cdek_period_min', t?.period_min ?? '');
            setVal('cdek_period_max', t?.period_max ?? '');
          }catch(e){ console.warn('Courier calc error', e); setDeliveryPrice(0);} 
        });
        addrDD.appendChild(b);
      });
      addrShow();
    },200);
  }
  if(addrInput){
    addrInput.addEventListener('input', onAddrInput);
    addrInput.addEventListener('focus', onAddrInput);
    document.addEventListener('click', (e)=>{ if(!addrDD.contains(e.target) && e.target!==addrInput) addrHide(); });
  }

  function setDeliveryMethodSelect(code){
    const sel = document.getElementById('delivery_method_id');
    if (!sel) return;
    const opts = Array.from(sel.options || []);
    const found = opts.find(o => (o.dataset && o.dataset.code) === code);
    if (found) sel.value = found.value;
  }
  function onChoiceChange(){
    const v = document.querySelector('input.delivery-choice[name="delivery_method_choice"]:checked')?.value;
    const pvzMode = document.getElementById('cdek_pvz_mode');
    const curMode = document.getElementById('cdek_courier_mode');
    const deliveryAddress = document.getElementById('delivery_address');
    const block = document.getElementById('cdek_block');
    if(v==='cdek'){
      block?.classList.remove('hidden'); pvzMode?.classList.remove('hidden'); curMode?.classList.add('hidden');
      setDeliveryMethodSelect('cdek');
      setVal('delivery_method_code', 'cdek');
      deliveryAddress?.removeAttribute('required');
    } else if(v==='cdek_courier'){
      block?.classList.remove('hidden'); pvzMode?.classList.add('hidden'); curMode?.classList.remove('hidden');
      setDeliveryMethodSelect('cdek_courier');
      setVal('delivery_method_code', 'cdek_courier');
      deliveryAddress?.setAttribute('required','required');
    } else {
      block?.classList.add('hidden');
    }
  }
  document.querySelectorAll('input.delivery-choice[name="delivery_method_choice"]').forEach(ch => ch.addEventListener('change', onChoiceChange));
  onChoiceChange();
});
