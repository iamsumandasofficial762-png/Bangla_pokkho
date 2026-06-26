(function () {
    'use strict';

    function initializeHeritageSection(section) {
        var cardsContainer = section.querySelector('.heritage-community-cards');
        var cards = Array.prototype.slice.call(section.querySelectorAll('[data-heritage-card]'));
        var panels = Array.prototype.slice.call(section.querySelectorAll('[data-heritage-panel]'));
        var activeCard = null;

        function closePanel(restoreFocus) {
            cardsContainer.classList.remove('is-detail-open');

            cards.forEach(function (card) {
                card.classList.remove('is-active');
                card.setAttribute('aria-expanded', 'false');
                card.removeAttribute('aria-hidden');
            });

            panels.forEach(function (panel) {
                panel.hidden = true;
            });

            if (restoreFocus && activeCard) {
                activeCard.focus();
            }

            activeCard = null;
        }

        function openPanel(card) {
            var key = card.getAttribute('data-heritage-card');
            var targetPanel = section.querySelector('[data-heritage-panel="' + key + '"]');

            if (!targetPanel) return;

            activeCard = card;
            cardsContainer.classList.add('is-detail-open');

            cards.forEach(function (item) {
                var isActive = item === card;
                item.classList.toggle('is-active', isActive);
                item.setAttribute('aria-expanded', isActive ? 'true' : 'false');
                if (isActive) {
                    item.removeAttribute('aria-hidden');
                } else {
                    item.setAttribute('aria-hidden', 'true');
                }
            });

            panels.forEach(function (panel) {
                panel.classList.remove('is-visible');
                panel.hidden = panel !== targetPanel;
            });

            window.requestAnimationFrame(function () {
                targetPanel.classList.add('is-visible');
            });
        }

        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                openPanel(card);
            });

            card.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openPanel(card);
                }
            });
        });

        panels.forEach(function (panel) {
            panel.querySelector('.heritage-detail-close').addEventListener('click', function () {
                panel.classList.remove('is-visible');
                closePanel(true);
            });
        });

        section.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && activeCard) {
                closePanel(true);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.heritage-community-section').forEach(initializeHeritageSection);
    });
})();
