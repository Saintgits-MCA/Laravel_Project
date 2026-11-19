
@if(session('success'))
    <div class="modal fade success-modal"
         id="successModal"
         tabindex="-1"
         aria-labelledby="successModalLabel"
         aria-hidden="true"
         data-bs-keyboard="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">

                {{-- Header --}}
                <div class="modal-header border-0 pb-0">
                    <div class="ms-auto"></div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body px-5 pt-2 pb-5">

                    <div class="success-icon mb-3">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <h4 class="fw-bold text-dark mb-2"
                        id="successModalLabel">
                        Success!
                    </h4>

                    <p class="text-muted mb-4">
                        {{ session('success') }}
                    </p>

                    <button type="button"
                            class="btn btn-danger px-4 py-2 fw-semibold"
                            data-bs-dismiss="modal"
                            id="successModalOk">
                        OK
                    </button>

                </div>
            </div>
        </div>
    </div>

    @once
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const modalElement =
                    document.getElementById('successModal');

                if (!modalElement || typeof bootstrap === 'undefined') {
                    return;
                }

                const successModal =
                    bootstrap.Modal.getOrCreateInstance(modalElement);

                const okButton =
                    document.getElementById('successModalOk');

                // Open success modal
                successModal.show();

                // Focus OK button after modal opens
                modalElement.addEventListener('shown.bs.modal', function () {
                    okButton.focus();
                });

                // Close modal when Enter is pressed
                modalElement.addEventListener('keydown', function (event) {

                    if (event.key === 'Enter') {
                        event.preventDefault();

                        // Use Bootstrap's normal dismiss mechanism
                        okButton.click();
                    }

                });

                // Clean up any leftover backdrop after closing
                modalElement.addEventListener('hidden.bs.modal', function () {

                    // Only clean up if no other modal is open
                    if (!document.querySelector('.modal.show')) {

                        document.querySelectorAll('.modal-backdrop')
                            .forEach(function (backdrop) {
                                backdrop.remove();
                            });

                        document.body.classList.remove('modal-open');

                        document.body.style.removeProperty('overflow');
                        document.body.style.removeProperty('padding-right');
                    }

                });

            });
        </script>
    @endonce
@endif
