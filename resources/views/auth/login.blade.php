@extends('layouts.auth', [
    'title' => 'Login'
])

@section('content')
    <h5 class="text-dark fw-bold mb-4">Sign In</h5>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="mb-1">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Tulis alamat email kamu" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="mb-1">Password</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password kamu" required>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="d-grid gap-3 mt-4">
            <button class="btn btn-primary d-block w-100" type="submit">Sign In</button>
            <a href="{{ route('google.redirect') }}" class="btn btn-light border-dark color-dark rounded-3 w-100">
                <img src="{{ url('assets/images/google-icon.png') }}" style="width: 20px;" alt="Google Icon">
                Login with Google
            </a>
        </div>
        <p class="mb-0 mt-2 text-secondary text-center">
            Belum Memiliki Akun?
            <a href="{{ route('register') }}" class="text-decoration-underline text-primary">Daftar</a>
        </p>
    </form>
@endsection
