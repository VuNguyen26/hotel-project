import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
    const toastElements = document.querySelectorAll('[data-toast]');

    toastElements.forEach((toast) => {
        const closeBtn = toast.querySelector('[data-toast-close]');

        const hideToast = () => {
            toast.classList.add('opacity-0', 'translate-x-4');
            setTimeout(() => toast.remove(), 250);
        };

        closeBtn?.addEventListener('click', hideToast);
        setTimeout(hideToast, 3500);
    });

    const confirmModal = document.getElementById('confirmModal');
    const confirmModalMessage = document.getElementById('confirmModalMessage');
    const confirmModalSubmit = document.getElementById('confirmModalSubmit');
    const confirmModalCancel = document.getElementById('confirmModalCancel');

    let pendingForm = null;

    const openConfirmModal = (form) => {
        if (!confirmModal || !confirmModalMessage || !confirmModalSubmit || !confirmModalCancel) return;

        pendingForm = form;
        confirmModalMessage.textContent = form.dataset.confirmMessage || 'Bạn có chắc muốn tiếp tục thao tác này không?';
        confirmModal.classList.remove('hidden');
        confirmModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };

    const closeConfirmModal = () => {
        if (!confirmModal) return;

        confirmModal.classList.add('hidden');
        confirmModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        pendingForm = null;
    };

    confirmModalCancel?.addEventListener('click', closeConfirmModal);

    confirmModal?.addEventListener('click', (event) => {
        if (event.target === confirmModal) {
            closeConfirmModal();
        }
    });

    confirmModalSubmit?.addEventListener('click', () => {
        if (!pendingForm) return;

        pendingForm.dataset.confirmed = 'true';
        closeConfirmModal();
        pendingForm.requestSubmit();
    });

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) return;

        if (form.dataset.confirm === 'true' && form.dataset.confirmed !== 'true') {
            event.preventDefault();
            openConfirmModal(form);
            return;
        }

        if ((form.method || '').toLowerCase() === 'get') return;

        const submitter = event.submitter;
        if (!(submitter instanceof HTMLButtonElement || submitter instanceof HTMLInputElement)) return;

        if (submitter.dataset.loadingApplied === 'true') return;

        submitter.dataset.loadingApplied = 'true';
        submitter.dataset.originalText = submitter.innerHTML;

        submitter.disabled = true;
        submitter.classList.add('opacity-70', 'cursor-not-allowed');

        const loadingText = submitter.dataset.loadingText || 'Đang xử lý...';
        submitter.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                ${loadingText}
            </span>
        `;

        form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach((btn) => {
            if (btn !== submitter) {
                btn.disabled = true;
                btn.classList.add('opacity-60', 'cursor-not-allowed');
            }
        });
    }, true);
});
