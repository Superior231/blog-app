@extends('layouts.auth', ['title' => 'Forgot Password - Blog App'])

@section('content')
    <div class="row w-100" style="height: 100svh;">
        <div class="col col-12 col-md-6 col-lg-7 d-flex flex-column justify-content-center" id="hero">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center justify-content-start ms-5 gap-2 text-decoration-none">
                <img src="{{ url('assets/images/logo.png') }}" style="width: 30px; height: auto;" alt="Logo">
                <h4 class="text-color text-center fw-bold my-0 py-0">Blog App</h4>
            </a>
            <div class="d-flex justify-content-center">
                <img src="{{ url('assets/images/hero.gif') }}" alt="Forgot Password"
                    style="width: 80%; height: auto;">
            </div>
        </div>

        <div class="col col-12 col-sm-12 col-md-6 col-lg-5 d-flex flex-column justify-content-center">
            <div class="d-flex flex-column justify-content-between h-100">
                <div class="container d-flex flex-column justify-content-center px-auto px-md-5 h-100">
                    <div class="d-flex flex-column align-items-center text-center">
                        <a href="{{ route('home') }}" class="mb-4 d-flex flex-column align-items-center d-none text-decoration-none" id="logo-mobile">
                            <img src="{{ url('assets/images/logo.png') }}" alt="Logo" style="width: 80px; height: auto;">
                        </a>
                        <h3 class="fw-bold">Forgot Password</h3>
                        <p>{{ config('app.name') }}</p>
                    </div>

                    <p class="mb-3 text-center text-secondary text-md-start small">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </p>

                    @if (session('status'))
                        <div class="py-2 mt-3 alert alert-success d-flex align-items-center" role="alert" style="font-size: 0.85rem;">
                            <i class='bx bxs-check-circle fs-4 me-2'></i>
                            <div>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="auth mt-3" id="forgot-password-form">
                        @csrf

                        <div class="content mb-3">
                            <div class="pass-logo">
                                <i class='bx bx-envelope'></i>
                            </div>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email Address"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary d-block w-100 fw-semibold" {{ session('status') ? 'disabled' : '' }} type="submit" id="forgot-password-btn">
                                <span id="btn-text">
                                    {{ session('status') ? 'Link Sent Successfully' : 'Email Password Reset Link' }}
                                </span>
                            </button>
                        </div>

                        <p class="mt-4 mb-0 text-center text-secondary">
                            Remember your password?
                            <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                        </p>
                    </form>
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
            document.getElementById('forgot-password-form').addEventListener('submit', function () {
                const btn = document.getElementById('forgot-password-btn');
                const btnText = document.getElementById('btn-text');

                btn.disabled = true;
                btnText.innerText = '{{ __("Sending...") }}';
            });
        </script>
@endpush
