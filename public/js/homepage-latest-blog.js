(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.home-latest-blog-section').forEach(function (section) {
            var search = section.querySelector('[data-home-blog-search]');
            var category = section.querySelector('[data-home-blog-category]');
            var results = section.querySelector('[data-home-blog-results]');
            var clearButton = section.querySelector('[data-home-blog-clear]');
            var status = section.querySelector('[data-home-blog-status]');
            var list = section.querySelector('[data-home-blog-result-list]');
            var endpoint = section.getAttribute('data-blog-search-url');
            var timer = null;
            var controller = null;

            if (!search || !category || !results || !clearButton || !endpoint) return;

            function updateClearButton() {
                clearButton.hidden = search.value.length === 0;
            }

            function hideResults() {
                if (controller) controller.abort();
                results.hidden = true;
                status.textContent = '';
                list.replaceChildren();
            }

            function showMessage(message, iconClass) {
                list.replaceChildren();
                status.replaceChildren();

                var wrapper = document.createElement('div');
                wrapper.className = 'home-blog-result-message';
                var icon = document.createElement('i');
                icon.className = iconClass;
                icon.setAttribute('aria-hidden', 'true');
                var text = document.createElement('span');
                text.textContent = message;
                wrapper.append(icon, text);
                status.appendChild(wrapper);
            }

            function renderBlogs(blogs) {
                status.replaceChildren();
                list.replaceChildren();

                if (!blogs.length) {
                    showMessage('কোনো ব্লগ পাওয়া যায়নি', 'far fa-newspaper');
                    return;
                }

                blogs.forEach(function (blog) {
                    var row = document.createElement('a');
                    row.className = 'home-blog-result-item';
                    row.href = blog.url;

                    var image = document.createElement('img');
                    image.src = blog.image;
                    image.alt = blog.title;
                    image.loading = 'lazy';

                    var content = document.createElement('div');
                    content.className = 'home-blog-result-content';
                    var title = document.createElement('h3');
                    title.textContent = blog.title;
                    var meta = document.createElement('div');
                    meta.className = 'home-blog-result-meta';
                    var date = document.createElement('time');
                    date.textContent = '';
                    var divider = document.createElement('span');
                    divider.setAttribute('aria-hidden', 'true');
                    divider.textContent = '';
                    var categoryName = document.createElement('span');
                    categoryName.textContent = blog.category || 'ব্লগ';
                    meta.append(date, divider, categoryName);
                    content.append(title, meta);

                    var arrow = document.createElement('i');
                    arrow.className = 'fas fa-arrow-right home-blog-result-arrow';
                    arrow.setAttribute('aria-hidden', 'true');
                    row.append(image, content, arrow);
                    list.appendChild(row);
                });
            }

            function loadResults() {
                var keyword = search.value.trim();
                var categoryId = category.value;

                if (!keyword && !categoryId) {
                    hideResults();
                    return;
                }

                if (controller) controller.abort();
                controller = new AbortController();
                results.hidden = false;
                showMessage('ব্লগ খোঁজা হচ্ছে...', 'fas fa-circle-notch fa-spin');

                var url = new URL(endpoint, window.location.origin);
                url.searchParams.set('q', keyword);
                url.searchParams.set('category_id', categoryId);

                fetch(url.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    signal: controller.signal
                })
                    .then(function (response) {
                        if (!response.ok) throw new Error('Search request failed');
                        return response.json();
                    })
                    .then(function (data) {
                        renderBlogs(data.blogs || []);
                    })
                    .catch(function (error) {
                        if (error.name !== 'AbortError') {
                            showMessage('ব্লগ লোড করা যাচ্ছে না। আবার চেষ্টা করুন।', 'fas fa-exclamation-circle');
                        }
                    });
            }

            search.addEventListener('input', function () {
                updateClearButton();
                window.clearTimeout(timer);
                timer = window.setTimeout(loadResults, 350);
            });

            clearButton.addEventListener('click', function () {
                search.value = '';
                updateClearButton();
                search.focus();
                window.clearTimeout(timer);
                loadResults();
            });

            category.addEventListener('change', function () {
                window.clearTimeout(timer);
                loadResults();
            });

            updateClearButton();
        });
    });
})();
