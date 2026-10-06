@auth()
    @if (!Auth::user()->hasVerifiedEmail())
        <div class="alert alert-warning border-0 border-start border-4 border-warning shadow-sm rounded-end-4 p-3 mb-2"
            role="alert">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 w-100">
                <div class="d-flex align-items-center">
                    <i class='bx bx-envelope fs-2 text-warning-emphasis me-3 flex-shrink-0'></i>
                    <div>
                        <h6 class="fw-bold text-warning-emphasis mb-1 small">
                            Verify Your Email Address
                        </h6>
                        <p class="mb-0 text-warning-emphasis text-break" style="font-size: 0.75rem;">
                            Please verify your email address to access all features. If you did not receive the email, we
                            can send another one.
                        </p>
                    </div>
                </div>

                <a href="{{ route('verification.notice') }}"
                    class="d-flex align-items-center text-decoration-none fw-semibold text-warning-emphasis ms-md-3 flex-shrink-0 small justify-content-end">
                    <span>Verify Email</span>
                    <i class='bx bx-chevron-right fs-5 ms-1'></i>
                </a>
            </div>
        </div>
    @endif
@endauth
