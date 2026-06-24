(function () {
    'use strict';

    var tabList = document.querySelector('.about-pokkho-tabs');

    if (!tabList) {
        return;
    }

    var tabs = Array.prototype.slice.call(tabList.querySelectorAll('[data-about-tab]'));
    var panels = Array.prototype.slice.call(document.querySelectorAll('[data-about-panel]'));

    function activateTab(tab, moveFocus) {
        var target = tab.getAttribute('data-about-tab');

        tabs.forEach(function (item) {
            var active = item === tab;
            item.classList.toggle('is-active', active);
            item.classList.toggle('text-primary', active);
            item.setAttribute('aria-selected', active ? 'true' : 'false');
            item.setAttribute('tabindex', active ? '0' : '-1');
        });

        panels.forEach(function (panel) {
            var active = panel.getAttribute('data-about-panel') === target;
            panel.classList.toggle('is-active', active);
            panel.hidden = !active;
        });

        if (moveFocus) {
            tab.focus();
        }
    }

    tabList.addEventListener('click', function (event) {
        var tab = event.target.closest('[data-about-tab]');

        if (tab) {
            activateTab(tab, false);
        }
    });

    tabList.addEventListener('keydown', function (event) {
        var currentIndex = tabs.indexOf(document.activeElement);

        if (currentIndex === -1 || (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight')) {
            return;
        }

        event.preventDefault();
        var direction = event.key === 'ArrowRight' ? 1 : -1;
        var nextIndex = (currentIndex + direction + tabs.length) % tabs.length;
        activateTab(tabs[nextIndex], true);
    });
}());
