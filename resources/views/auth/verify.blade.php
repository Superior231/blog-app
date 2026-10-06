@extends('layouts.auth', ['title' => 'Verify Email - Blog App'])

@section('content')
    <div class="row w-100" style="height: 100svh;">
        <div class="col col-12 col-md-6 col-lg-7 d-flex flex-column justify-content-center" id="hero">
            <a href="{{ route('home') }}"
                class="logo d-flex align-items-center justify-content-start ms-5 gap-2 text-decoration-none">
                <img src="{{ url('assets/images/logo.png') }}" style="width: 30px; height: auto;" alt="Logo">
                <h4 class="text-color text-center fw-bold my-0 py-0">Blog App</h4>
            </a>
            <div class="d-flex justify-content-center">
                <img src="{{ url('assets/images/hero.gif') }}" alt="Verify Email" style="width: 80%; height: auto;">
            </div>
        </div>

        <div class="col col-12 col-sm-12 col-md-6 col-lg-5 d-flex flex-column justify-content-center">
            <div class="d-flex flex-column justify-content-between h-100">
                <div class="container d-flex flex-column justify-content-center px-auto px-md-5 h-100">
                    <div class="d-flex flex-column align-items-center text-center">
                        <a href="{{ route('home') }}"
                            class="mb-4 d-flex flex-column align-items-center d-none text-decoration-none" id="logo-mobile">
                            <img src="{{ url('assets/images/logo.png') }}" alt="Logo" style="width: 80px; height: auto;">
                        </a>
                        <h3 class="fw-bold">Verify Email</h3>
                        <p class="text-secondary">{{ config('app.name') }}</p>
                    </div>

                    @if (session('resent'))
                        <div class="py-2 mt-3 alert alert-success d-flex align-items-center" role="alert"
                            style="font-size: 0.85rem;">
                            <i class='bx bxs-check-circle fs-4 me-2'></i>
                            <div>
                                A fresh verification link has been sent to your email address.
                            </div>
                        </div>
                    @endif

                    <div class="text-center text-secondary my-3 small">
                        <p class="text-center text-secondary text-md-start small" style="font-size: 0.95rem;">
                            Thanks for signing up! To unlock all features, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-2" id="verify-form">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary d-block w-100 fw-semibold"
                                {{ session('resent') ? 'disabled' : '' }} id="verify-btn">
                                <span id="btn-text">
                                    {{ session('resent') ? 'Verification Link Sent' : 'Resend Verification Email' }}
                                </span>
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('home') }}"
                        class="gap-2 py-0 my-0 mt-3 text-center align-items-center justify-content-center d-flex btn btn-link text-decoration-none text-secondary">
                        <i class='py-0 my-0 bx bx-arrow-back text-secondary fs-4'></i>
                        Back
                    </a>
                </div>

                <div class="footer d-flex justify-content-center py-5" style="height: 20px">
                    <small class="text-secondary">Copyright &copy; {{ date('Y') }}. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('verify-form').addEventListener('submit', function() {
            const btn = document.getElementById('verify-btn');
            const btnText = document.getElementById('btn-text');

            btn.disabled = true;
            btnText.innerText = '{{ __('Sending...') }}';
        });
    </script>
@endpush
