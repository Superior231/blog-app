@extends('layouts.auth', ['title' => 'Login - Blog App'])

@section('content')
    <div class="row w-100" style="height: 100svh;">
        <div class="col col-12 col-md-6 col-lg-7 d-flex flex-column justify-content-center" id="hero">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center justify-content-start ms-5 gap-2 text-decoration-none">
                <img src="{{ url('assets/images/logo.png') }}" style="width: 30px; height: auto;" alt="Logo">
                <h4 class="text-color text-center fw-bold my-0 py-0">Blog App</h4>
            </a>
            <div class="d-flex justify-content-center">
                <img src="{{ url('assets/images/hero.gif') }}" alt="Login"
                    style="width: 80%; height: auto;">
            </div>
        </div>
        <div class="col col-12 col-sm-12 col-md-6 col-lg-5 d-flex flex-column justify-content-center">
            <div class="d-flex flex-column justify-content-between h-100">
                <div class="container d-flex flex-column justify-content-center px-auto px-md-5 h-100">
                    <div class="d-flex flex-column align-items-center">
                        <a href="{{ route('home') }}" class="mb-4 d-flex flex-column align-items-center d-none text-decoration-none" id="logo-mobile">
                            <img src="{{ url('assets/images/logo.png') }}" alt="Logo" style="width: 80px; height: auto;">
                        </a>
                        <h3 class="fw-bold">Login</h3>
                        <p>Login Blog App</p>
                    </div>
    
                    <form method="POST" action="{{ route('login') }}" class="auth mt-4">
                        @csrf
    
                        <div class="content mb-3">
                            <div class="pass-logo">
                                <i class='bx bx-user'></i>
                            </div>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                        <div class="content mb-3">
                            <div class="pass-logo">
                                <i class='bx bx-lock-alt'></i>
                            </div>
                            <div class="d-flex align-items-center position-relative">
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" style="padding-right: 45px;"
                                    placeholder="Password" required>
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

                        <div class="d-grid gap-1 mt-4">
                            <button class="btn btn-primary d-block w-100 fw-semibold" type="submit">Login</button>
                            <span class="text-secondary mx-auto d-block my-0 py-0">or</span>
                            <a href="{{ route('google.redirect') }}" class="btn google-btn btn-light border-dark color-dark text-dark rounded-3 w-100 fw-semibold">
                                <img src="{{ url('assets/images/google-icon.png') }}" style="width: 20px;" alt="Google Icon">
                                Login with Google
                            </a>
                        </div>
                        <p class="mb-0 mt-2 text-secondary text-center">
                            Don't have an account yet?
                            <a href="{{ route('register') }}" class="text-decoration-underline text-primary">Register</a>
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
