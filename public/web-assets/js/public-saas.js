(function () {
    'use strict';

    var header = document.querySelector('[data-site-header]');
    var toggle = document.querySelector('[data-menu-toggle]');
    var navigation = document.querySelector('[data-site-navigation]');

    function updateHeader() {
        if (header) header.classList.toggle('is-scrolled', window.scrollY > 12);
    }

    if (toggle && navigation) {
        toggle.addEventListener('click', function () {
            var open = navigation.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', String(open));
            toggle.querySelector('i').className = open ? 'far fa-times' : 'far fa-bars';
        });
        navigation.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navigation.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.querySelector('i').className = 'far fa-bars';
            });
        });
    }

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
})();
