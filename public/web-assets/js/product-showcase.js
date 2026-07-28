(function () {
    'use strict';

    document.querySelectorAll('[data-product-showcase]').forEach(function (showcase) {
        var tabs = Array.from(showcase.querySelectorAll('[role="tab"]'));
        var panels = Array.from(showcase.querySelectorAll('[role="tabpanel"]'));
        var counter = showcase.querySelector('[data-showcase-current]');
        var interval = Number(showcase.getAttribute('data-interval')) || 5600;
        var activeIndex = 0;
        var timer = null;
        var isPaused = false;
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function activate(index, moveFocus) {
            activeIndex = (index + tabs.length) % tabs.length;

            tabs.forEach(function (tab, tabIndex) {
                var isActive = tabIndex === activeIndex;
                tab.classList.toggle('is-active', isActive);
                tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                tab.setAttribute('tabindex', isActive ? '0' : '-1');
            });

            panels.forEach(function (panel, panelIndex) {
                var isActive = panelIndex === activeIndex;
                panel.hidden = !isActive;
                panel.classList.toggle('is-active', isActive);
            });

            if (counter) {
                counter.textContent = String(activeIndex + 1).padStart(2, '0');
            }

            showcase.classList.remove('is-cycling');
            void showcase.offsetWidth;
            showcase.classList.add('is-cycling');

            if (moveFocus) {
                tabs[activeIndex].focus();
            }
        }

        function stopTimer() {
            if (timer) {
                window.clearInterval(timer);
                timer = null;
            }
        }

        function startTimer() {
            stopTimer();
            if (!reduceMotion && !isPaused) {
                timer = window.setInterval(function () {
                    activate(activeIndex + 1, false);
                }, interval);
            }
        }

        tabs.forEach(function (tab, index) {
            tab.addEventListener('click', function () {
                activate(index, false);
                startTimer();
            });

            tab.addEventListener('keydown', function (event) {
                if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
                    event.preventDefault();
                    activate(activeIndex + 1, true);
                    startTimer();
                }

                if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
                    event.preventDefault();
                    activate(activeIndex - 1, true);
                    startTimer();
                }
            });
        });

        showcase.addEventListener('mouseenter', function () {
            isPaused = true;
            stopTimer();
        });

        showcase.addEventListener('mouseleave', function () {
            isPaused = false;
            startTimer();
        });

        showcase.addEventListener('focusin', function () {
            isPaused = true;
            stopTimer();
        });

        showcase.addEventListener('focusout', function (event) {
            if (!showcase.contains(event.relatedTarget)) {
                isPaused = false;
                startTimer();
            }
        });

        activate(0, false);
        startTimer();
    });
}());
