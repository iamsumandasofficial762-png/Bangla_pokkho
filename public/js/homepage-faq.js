(function () {
    'use strict';

    function setItemState(item, open) {
        var button = item.querySelector('.home-faq-question');
        var answer = item.querySelector('.home-faq-answer');

        item.classList.toggle('is-open', open);
        button.setAttribute('aria-expanded', open ? 'true' : 'false');
        answer.setAttribute('aria-hidden', open ? 'false' : 'true');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-home-faq-accordion]').forEach(function (accordion) {
            var items = Array.prototype.slice.call(accordion.querySelectorAll('.home-faq-item'));

            items.forEach(function (item) {
                item.querySelector('.home-faq-question').addEventListener('click', function () {
                    var willOpen = !item.classList.contains('is-open');

                    items.forEach(function (otherItem) {
                        setItemState(otherItem, false);
                    });

                    if (willOpen) {
                        setItemState(item, true);
                    }
                });
            });
        });
    });
})();
