(() => {
    const toggle = document.querySelector('.sa-menu-toggle');
    const backdrop = document.querySelector('.sa-backdrop');
    const sidebar = document.querySelector('.sa-sidebar');
    const desktop = matchMedia('(min-width: 1000px)');
    sidebar.inert = !desktop.matches;
    const setMenu = (open) => {
        document.body.classList.toggle('sa-menu-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Menüyü kapat' : 'Menüyü aç');
        backdrop.hidden = !open;
        sidebar.inert = !open && !desktop.matches;
        if (open) sidebar.querySelector('a').focus();
    };
    toggle.addEventListener('click', () => setMenu(!document.body.classList.contains('sa-menu-open')));
    backdrop.addEventListener('click', () => { setMenu(false); toggle.focus(); });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (document.body.classList.contains('sa-menu-open')) { setMenu(false); toggle.focus(); }
            document.querySelectorAll('.sa-account[open]').forEach(el => el.open = false);
        }
        if (event.key === 'Tab' && document.body.classList.contains('sa-menu-open')) {
            const links = [...sidebar.querySelectorAll('a[href]')];
            if (event.shiftKey && document.activeElement === links[0]) { event.preventDefault(); links.at(-1).focus(); }
            else if (!event.shiftKey && document.activeElement === links.at(-1)) { event.preventDefault(); links[0].focus(); }
        }
    });
    desktop.addEventListener('change', () => setMenu(false));
    document.addEventListener('click', event => {
        document.querySelectorAll('.sa-account[open]').forEach(el => { if (!el.contains(event.target)) el.open = false; });
    });
    document.getElementById('panel-business').addEventListener('change', event => {
        if (event.target.value) location.assign(event.target.value);
    });

    document.querySelectorAll('[data-list-filter]').forEach(list => {
        const search = list.querySelector('[data-search]');
        const status = list.querySelector('[data-status-filter]');
        const rows = [...list.querySelectorAll('[data-filter-row]')];
        const update = () => {
            const term = search.value.trim().toLocaleLowerCase('tr');
            let count = 0;
            rows.forEach(row => {
                const matches = row.textContent.toLocaleLowerCase('tr').includes(term) && (!status.value || row.dataset.status === status.value);
                row.hidden = !matches;
                if (matches) count++;
            });
            list.querySelector('[data-result-count]').textContent = String(count);
            list.querySelector('[data-no-results]').hidden = count !== 0;
        };
        search.addEventListener('input', update);
        status.addEventListener('change', update);
        list.querySelector('[data-reset-filter]').addEventListener('click', () => { search.value = ''; status.value = ''; update(); search.focus(); });
        update();
    });

    document.querySelectorAll('.modal.show').forEach(modal => {
        modal.classList.remove('show');
        modal.style.display = '';
        modal.setAttribute('aria-hidden', 'true');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        bootstrap.Modal.getOrCreateInstance(modal).show();
    });
})();
