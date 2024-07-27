{{-- Success --}}
@if (session('success'))
    <div class="position-fixed p-3" id="toast-success">
        <div class="toast align-items-center" id="toast-success-content" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class='bx bxs-check-circle text-success fs-2'></i>
                    <span class="ms-2 my-0 py-0 fw-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif


{{-- Error --}}
@if (session('error'))
    <div class="position-fixed p-3" id="toast-error">
        <div class="toast toast-error align-items-center" id="toast-error-content" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class='bx bxs-x-circle text-danger fs-2'></i>
                    <span class="ms-2 my-0 py-0 fw-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl)
            })
            toastList.forEach(toast => toast.show());
        });
    </script>
@endpush
