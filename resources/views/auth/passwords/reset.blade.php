@extends('layouts.auth', ['title' => 'Reset Password - Blog App'])

@section('content')
    <div class="row w-100" style="height: 100svh;">
        <div class="col col-12 col-md-6 col-lg-7 d-flex flex-column justify-content-center" id="hero">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center justify-content-start ms-5 gap-2 text-decoration-none">
                <img src="{{ url('assets/images/logo.png') }}" style="width: 30px; height: auto;" alt="Logo">
                <h4 class="text-color text-center fw-bold my-0 py-0">Blog App</h4>
            </a>
            <div class="d-flex justify-content-center">
                <img src="{{ url('assets/images/hero.gif') }}" alt="Reset Password"
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
                        <h3 class="fw-bold">Reset Password</h3>
                        <p class="text-secondary">{{ config('app.name') }}</p>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="auth mt-2">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email Address --}}
                        <div class="content mb-3">
                            <div class="pass-logo">
                                <i class='bx bx-envelope'></i>
                            </div>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email Address"
                                value="{{ $email ?? old('email') }}" required autocomplete="email" readonly autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="content mb-3">
                            <div class="pass-logo">
                                <i class='bx bx-lock-alt'></i>
                            </div>
                            <div class="d-flex align-items-center position-relative">
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" style="padding-right: 45px;"
                                    placeholder="New Password" required autocomplete="new-password">
                                <div class="showPass d-flex align-items-center justify-content-center position-absolute end-0 h-100"
                                    id="showPass" style="cursor: pointer; width: 50px; border-radius: 0px 10px 10px 0px;"
                                    onclick="showPass()">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </div>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="content mb-3">
                            <div class="pass-logo">
                                <i class='bx bx-lock-alt'></i>
                            </div>
                            <div class="d-flex align-items-center position-relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" style="padding-right: 45px;"
                                    placeholder="Confirm New Password" required autocomplete="new-password">
                                <div class="showPass d-flex align-items-center justify-content-center position-absolute end-0 h-100"
                                    style="cursor: pointer; width: 50px; border-radius: 0px 10px 10px 0px;"
                                    onclick="showPass2()">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary d-block w-100 fw-semibold" type="submit">
                                Reset Password
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
