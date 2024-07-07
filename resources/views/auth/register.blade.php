@extends('layouts.auth', [
    'title' => 'Register'
])

@section('content')
    <h5 class="text-dark fw-bold">Sign Up</h5>

    <a href="{{ route('google.redirect') }}" class="btn btn-light border-dark color-dark rounded-3 w-100 mt-2 mb-4">
        <img src="{{ url('assets/images/google-icon.png') }}" style="width: 20px;" alt="Google Icon">
        Sign Up with Google
    </a>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="mb-1">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Tulis nama kamu" autocomplete="name" required autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="mb-1">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Tulis alamat email kamu" value="{{ old('email') }}" required autocomplete="email">
        </div>
        <div class="mb-3">
            <label for="password" class="mb-1">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password kamu" required>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan ulang password kamu" required>
        </div>

        <button class="btn btn-primary d-block w-100" type="submit">Sign Up</button>
        <p class="mb-0 mt-2 text-secondary text-center">
            Sudah Memiliki Akun? 
            <a href="{{ route('login') }}" class="text-decoration-underline text-primary">Masuk</a>
        </p>
    </form>
@endsection
