(function () {
    const tablist = document.querySelector('[role="tablist"]');
    const tabs = tablist ? Array.from(tablist.querySelectorAll('[role="tab"]')) : [];
    const panels = ['panel-pickup', 'panel-carriers'].map(id => document.getElementById(id));

    function activate(id, setHash = true) {
        tabs.forEach(t => {
            const selected = (t.getAttribute('aria-controls') === id);
            t.setAttribute('aria-selected', selected);
            t.tabIndex = selected ? 0 : -1;
            t.classList.toggle('bg-white', selected);
            t.classList.toggle('shadow-sm', selected);
        });
        panels.forEach(p => p && (p.hidden = (p.id !== id)));
        if (setHash) location.hash = id.replace('panel-', '');
    }

    const initial = location.hash ? `panel-${location.hash.replace('#', '')}` : 'panel-pickup';
    if (document.getElementById(initial)) activate(initial, false); else activate('panel-pickup', false);

    tabs.forEach((t, i) => {
        t.addEventListener('click', () => activate(t.getAttribute('aria-controls')));
        t.addEventListener('keydown', (e) => {
            const k = e.key;
            let idx = i;
            if (k === 'ArrowRight') idx = (i + 1) % tabs.length;
            else if (k === 'ArrowLeft') idx = (i - 1 + tabs.length) % tabs.length;
            else if (k === 'Home') idx = 0;
            else if (k === 'End') idx = tabs.length - 1;
            else return;
            e.preventDefault();
            tabs[idx].focus();
            activate(tabs[idx].getAttribute('aria-controls'));
        });
    });

    document.querySelectorAll('[data-accordion-target]').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-accordion-target');
            activate(id);
            btn.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    window.addEventListener('hashchange', () => {
        const id = `panel-${location.hash.replace('#', '')}`;
        if (document.getElementById(id)) activate(id, false);
    });
})();