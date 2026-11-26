
import './bootstrap';
import '@hotwired/turbo';

// Debounced live search for Students and Schools
const searchTimers = new WeakMap();

document.addEventListener('input', function (event) {
    const input = event.target;

    if (
        !input.matches('#studentSearch') &&
        !input.matches('#schoolSearch') &&
        !input.matches('#userSearch')
    ) {
        return;
    }

    const form = input.closest('form[data-turbo-frame]');

    if (!form) {
        console.error('Turbo search form not found.');
        return;
    }

    clearTimeout(searchTimers.get(form));

    const timer = setTimeout(function () {
        const pageInput = form.querySelector('input[name="page"]');

        if (pageInput) {
            pageInput.remove();
        }

        form.requestSubmit();
    }, 400);

    searchTimers.set(form, timer);
});

// Submit when the student status filter changes
document.addEventListener('change', function (event) {
    if (!event.target.matches('#status_filter')) {
        return;
    }

    const form = event.target.closest('form[data-turbo-frame]');

    if (form) {
        clearTimeout(searchTimers.get(form));
        form.requestSubmit();
    }
});
