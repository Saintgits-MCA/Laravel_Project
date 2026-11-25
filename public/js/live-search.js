
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-live-search]').forEach(function (container) {

        const form = container.querySelector('[data-search-form]');
        const searchInput = container.querySelector('[data-search-input]');
        const statusFilter = container.querySelector('[data-search-filter]');

        const results = container.querySelector('[data-search-results]');
        const pagination = container.querySelector('[data-search-pagination]');
        const total = container.querySelector('[data-search-total]');

        if (!form || !results || !pagination) return;

        let debounceTimer;
        let controller;

        function loadResults(url, updateAddress = true) {

            if (controller) {
                controller.abort();
            }

            controller = new AbortController();

            container.style.opacity = '0.5';

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                },
                signal: controller.signal
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Unable to load results');
                    }

                    return response.text();
                })
                .then(html => {

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newResults = doc.querySelector('[data-search-results]');
                    const newPagination = doc.querySelector('[data-search-pagination]');
                    const newTotal = doc.querySelector('[data-search-total]');

                    if (newResults) {
                        results.innerHTML = newResults.innerHTML;
                    }

                    if (newPagination) {
                        pagination.innerHTML = newPagination.innerHTML;
                    }

                    if (total && newTotal) {
                        total.textContent = newTotal.textContent;
                    }

                    if (updateAddress) {
                        window.history.pushState({}, '', url);
                    }

                })
                .catch(error => {
                    if (error.name !== 'AbortError') {
                        console.error(error);
                    }
                })
                .finally(() => {
                    container.style.opacity = '1';
                });
        }

        function search() {

            const params = new URLSearchParams(new FormData(form));

            // Always start from page 1 when searching/filtering
            params.delete('page');

            const query = params.toString();
            const url = container.dataset.url + (query ? '?' + query : '');

            loadResults(url);
        }

        // Search automatically while typing
        if (searchInput) {
            searchInput.addEventListener('input', function () {

                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(search, 350);

            });
        }

        // Filter automatically when status changes
        if (statusFilter) {
            statusFilter.addEventListener('change', search);
        }

        // Prevent normal form submission
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            clearTimeout(debounceTimer);
            search();
        });

        // Handle pagination without page reload
        container.addEventListener('click', function (event) {

            const link = event.target.closest(
                '[data-search-pagination] a'
            );

            if (!link || !container.contains(link)) return;

            if (
                link.classList.contains('disabled') ||
                !link.getAttribute('href') ||
                link.getAttribute('href') === '#'
            ) {
                event.preventDefault();
                return;
            }

            event.preventDefault();
            clearTimeout(debounceTimer);

            loadResults(link.href);
        });

    });

});
