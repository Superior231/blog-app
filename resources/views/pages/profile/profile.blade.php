@extends('layouts.profile')

@section('content')
    <div class="info d-flex align-items-center justify-content-center gap-4 mt-5 mb-4 mb-md-5">
        <div class="followers-info d-flex flex-column align-items-center">
            <h3 class="fw-semibold">64</h3>
            <p class="fs-7">Followers</p>
        </div>
        <div class="followeing-info d-flex flex-column align-items-center">
            <h3 class="fw-semibold">14</h3>
            <p class="fs-7">Following</p>
        </div>
        <div class="articles-info d-flex flex-column align-items-center">
            <h3 class="fw-semibold">{{ $user->articles->count() }}</h3>
            <p class="fs-7">Articles</p>
        </div>
    </div>

    <div class="actions d-flex align-items-center justify-content-center gap-2">
        @auth()
            @if ($user->id == Auth::user()->id)
                <a href="{{ route('edit.profile', [$user->slug]) }}" class="edit-profile text-center text-light bg-primary py-2 px-3 rounded-3 w-100">
                    Edit profile
                </a>
            @else
                <a href="#" class="edit-profile text-center text-light bg-primary py-2 px-3 rounded-3 w-100">
                    Follow
                </a>
            @endif
            
        @else
            <a href="#" onclick="login()" class="edit-profile text-center text-light bg-primary py-2 px-3 rounded-3 w-100">
                Follow
            </a>
        @endauth

        <a href="{{ $user->facebook }}" class="facebook bg-primary text-light py-2 px-3 rounded-3" target="__blank" title="Facebook">
            <i class="fa-brands fa-facebook-f p-0 m-0"></i>
        </a>
        <a href="{{ $user->twitter }}" class="x bg-dark text-light py-2 px-3 rounded-3" target="__blank" title="X">
            <i class="fa-brands fa-x-twitter p-0 m-0"></i>
        </a>
        <a href="{{ $user->instagram }}" class="instagram bg-danger text-light py-2 px-3 rounded-3" target="__blank" title="Instagram">
            <i class="fa-brands fa-instagram p-0 m-0"></i>
        </a>
    </div>

    <div class="description mt-4 mt-md-5 mb-4">
        <h5 class="fw-semibold">Deskripsi</h5>
        <p class="fs-7">
            @auth()
                @if ($user->id == Auth::user()->id && !empty(Auth::user()->description))
                    {{ Auth::user()->description }}
                @elseif (!empty($user->description))
                    {{ $user->description }}
                @else
                    Belum ada deskripsi.
                @endif

            @else
                @if (!empty($user->description))
                    {{ $user->description }}
                @else
                    Belum ada deskripsi.
                @endif
            @endauth
        </p>
    </div>
@endsection
