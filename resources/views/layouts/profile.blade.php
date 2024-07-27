<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.style')
</head>

<body>
    @include('components.navbar')

    <section class="profile bg-soft-blue pt-0 pb-4">
        <div class="container">
            @include('components.toast')
        </div>

        <!-- Header -->
        <div class="container container-header">
            <div class="profile-header py-0 my-0">
                <div class="banner">
                    @auth
                        @if ($user->id == Auth::user()->id && !empty(Auth::user()->banner))
                            <img class="img img-banner" id="edit-banner" src="{{ asset('storage/banners/' . Auth::user()->banner) }}" alt="banner">
                        @elseif (!empty($user->banner))
                            <img class="img img-banner" id="edit-banner" src="{{ asset('storage/banners/' . $user->banner) }}" alt="banner">
                        @else
                            <img class="img img-banner" id="edit-banner" src="{{ url('assets/images/banner.png') }}" alt="banner">
                        @endif
                    @else
                        @if (!empty($user->banner))
                            <img class="img img-banner" id="edit-banner" src="{{ asset('storage/banners/' . $user->banner) }}" alt="banner">
                        @else
                            <img class="img img-banner" id="edit-banner" src="{{ url('assets/images/banner.png') }}" alt="banner">
                        @endif
                    @endauth
                </div>

                <div class="user">
                    <div class="info d-flex align-items-center gap-2 gap-md-3">
                        <div class="foto position-relative">
                            <div class="profile-image" data-bs-toggle="modal" data-bs-target="#avatar-img-preview">
                                <div class="image-overlay"></div>
                                @auth
                                    @if ($user->id == Auth::user()->id && !empty(Auth::user()->avatar))
                                        <img class="img img-avatar" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                                    @elseif ($user->id == Auth::user()->id && !empty(Auth::user()->avatar_google))
                                        <img class="img img-avatar" src="{{ Auth::user()->avatar_google }}">
                                    @elseif (!empty($user->avatar))
                                        <img class="img img-avatar" src="{{ asset('storage/avatars/' . $user->avatar) }}">
                                    @elseif (!empty($user->avatar_google))
                                        <img class="img img-avatar" src="{{ $user->avatar_google }}">
                                    @else
                                        <img class="img img-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($user->name) }}">
                                    @endif
                                @else
                                    @if (!empty($user->avatar))
                                        <img class="img img-avatar" src="{{ asset('storage/avatars/' . $user->avatar) }}">
                                    @elseif (!empty($user->avatar_google))
                                        <img class="img img-avatar" src="{{ $user->avatar_google }}">
                                    @else
                                        <img class="img img-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($user->name) }}">
                                    @endif
                                @endauth
                            </div>

                            @auth()
                                @if ($user->id == Auth::user()->id)
                                    <div class="foto-icon" data-bs-toggle="modal" data-bs-target="#edit-avatar-img">
                                        <i class='bx bxs-camera p-0 m-0'></i>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <div class="username">
                            @auth
                                @if ($user->id == Auth::user()->id)
                                    <h3 class="fw-bold text-light p-0 m-0">{{ Auth::user()->name }}</h2>
                                        <p class="text-light p-0 m-0">&#64;{{ Auth::user()->slug }}</p>
                                    @else
                                        <h3 class="fw-bold text-light p-0 m-0">{{ $user->name }}</h2>
                                            <p class="text-light p-0 m-0">&#64;{{ $user->slug }}</p>
                                @endif
                            @else
                                <h3 class="fw-bold text-light p-0 m-0">{{ $user->name }}</h2>
                                    <p class="text-light p-0 m-0">&#64;{{ $user->slug }}</p>
                                @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container info mt-4">
            <ul class="nav nav-tabs d-flex align-items-center justify-content-center">
                @auth()
                    @if ($user->id == Auth::user()->id)
                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}"
                                class="nav-link {{ $nav_tab_active == 'profile' ? 'active' : '' }}"
                                href="#">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.article') }}"
                                class="nav-link {{ $nav_tab_active == 'article' ? 'active' : '' }}"
                                href="#">Article</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('author.show', ['slug' => $user->slug]) }}"
                                class="nav-link {{ $nav_tab_active == 'profile' ? 'active' : '' }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('author.article', ['slug' => $user->slug]) }}"
                                class="nav-link {{ $nav_tab_active == 'article' ? 'active' : '' }}">Article</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a href="{{ route('author.show', ['slug' => $user->slug]) }}"
                            class="nav-link {{ $nav_tab_active == 'profile' ? 'active' : '' }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('author.article', ['slug' => $user->slug]) }}"
                            class="nav-link {{ $nav_tab_active == 'article' ? 'active' : '' }}">Article</a>
                    </li>
                @endauth
            </ul>

            @yield('content')

        </div>
    </section>

    <!-- Modal -->
    @auth()
        @if ($user->id == Auth::user()->id)
            <div class="modal fade" id="edit-avatar-img" tabindex="-1" aria-labelledby="edit-avatar-img-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="modal-header">
                                <h4 class="modal-title" id="edit-avatar-img-label">Edit avatar</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex flex-column align-items-center gap-3">
                                <div class="profile-image" style="width: 120px; height: 120px;">
                                    @if (!empty($user->avatar))
                                        <img class="img img-avatar" id="edit-avatar" src="{{ asset('storage/avatars/' . $user->avatar) }}">
                                    @elseif (!empty($user->avatar_google))
                                        <img class="img img-avatar" id="edit-avatar" src="{{ $user->avatar_google }}">
                                    @else
                                        <img class="img img-avatar" id="edit-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($user->name) }}">
                                    @endif
                                </div>

                                <div class="mb-3 w-100">
                                    <label for="edit-avatar-input">Avatar</label>
                                    <input type="file" name="avatar" id="edit-avatar-input" class="form-control" accept=".jpg, .jpeg, .png, .webp">
                                </div>
                                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <div class="modal fade" id="avatar-img-preview" tabindex="-1" aria-labelledby="avatar-img-preview-label" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0">
                    <div class="close d-flex justify-content-end w-100" data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                        <i class='bx bx-x text-light fs-1'></i>
                    </div>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="avatar" style="max-width: 400px;">
                        @if (!empty($user->avatar))
                            <img class="img img-avatar" src="{{ asset('storage/avatars/' . $user->avatar) }}">
                        @elseif (!empty($user->avatar_google))
                            <img class="img img-avatar" src="{{ $user->avatar_google }}">
                        @else
                            <img class="img img-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($user->name) }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="back-to-top">
        <a class="icon-back-to-top" href="#"><i class='bx bxs-chevron-up fs-2'></i></a>
    </div>

    @include('components.footer')

    @include('components.script')
</body>

</html>
