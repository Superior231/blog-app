@extends('layouts.main')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    <section id="profile" class="pt-0">
        <div class="row g-1 g-lg-3">
            <div class="col col-12 col-lg-8">
                <div class="mt-3 card card-profile">
                    <div class="banner">
                        @auth
                            @if ($user->id == Auth::user()->id && !empty(Auth::user()->banner))
                                <img class="card-img-top" id="edit-banner" src="{{ asset('storage/banners/' . Auth::user()->banner) }}" alt="banner">
                            @elseif (!empty($user->banner))
                                <img class="card-img-top" id="edit-banner" src="{{ asset('storage/banners/' . $user->banner) }}" alt="banner">
                            @else
                                <img class="card-img-top" id="edit-banner" src="{{ url('assets/images/banner.png') }}" alt="banner">
                            @endif
                        @else
                            @if (!empty($user->banner))
                                <img class="card-img-top" id="edit-banner" src="{{ asset('storage/banners/' . $user->banner) }}" alt="banner">
                            @else
                                <img class="card-img-top" id="edit-banner" src="{{ url('assets/images/banner.png') }}" alt="banner">
                            @endif
                        @endauth
                    </div>

                    <div class="header">
                        <div class="foto position-relative">
                            <div class="avatar" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#avatar-img-preview">
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
                        <div class="d-flex d-md-none flex-column align-items-center gap-0">
                            <small class="text-color fs-7 py-0 my-0">{{ '@' . $user->slug }}</small>
                            <h5 class="fw-bold text-center text-dark py-0 my-0">{{ $user->name }}</h5>
                        </div>

                        <div class="info d-flex align-items-center justify-content-center gap-4 text-dark">
                            <a class="followers-info d-flex flex-column align-items-center text-dark" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#followersModal">
                                <h6 class="fw-semibold">{{ $user->followers->count() }}</h6>
                                <p class="fs-8">Followers</p>
                            </a>
                            <a class="following-info d-flex flex-column align-items-center text-dark" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#followingModal">
                                <h6 class="fw-semibold">{{ $user->following->count() }}</h6>
                                <p class="fs-8">Following</p>
                            </a>
                            <div class="articles-info d-flex flex-column align-items-center">
                                <h6 class="fw-semibold">{{ $user->articles->count() }}</h6>
                                <p class="fs-8">Articles</p>
                            </div>
                        </div>

                        <div class="actions d-grid d-md-flex justify-content-md-end w-100">
                            @auth()
                                @if ($user->id == Auth::user()->id)
                                    <a href="{{ route('edit.profile', [$user->slug]) }}" class="edit-profile text-center text-light bg-primary py-2 px-3 rounded-pill position-relative">
                                        <small style="fs-8">Edit profile</small>
                                    </a>
                                @else         
                                    @if ($isFollowing)
                                        <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-primary unfollow-btn text-center py-2 px-3 rounded-pill" type="submit">
                                                <small style="fs-8">Unfollow</small>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="followed_id" value="{{ $user->id }}">
                                            <button class="follow-btn border-transparent border-0 text-center text-light bg-primary py-2 px-3 rounded-pill" type="submit">
                                                <small style="fs-8">Follow</small>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                                
                            @else
                                <a href="#" onclick="login()" class="follow-btn text-center text-light bg-primary py-2 px-3 rounded-pill">
                                    <small style="fs-8">Follow</small>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-none d-md-flex flex-column juctify-content-center gap-0 mt-3">
                            <h5 class="fw-bold text-dark my-0 py-0">{{ $user->name }}</h5>
                            <small class="text-color fs-7 py-0 my-0">{{ '@' . $user->slug }}</small>
                        </div>
                        <div class="card-text mt-3">
                            @auth()
                                @if ($user->id == Auth::user()->id && !empty(Auth::user()->description))
                                    {{ Auth::user()->description }}
                                @elseif (!empty($user->description))
                                    {{ $user->description }}
                                @else
                                    No description yet.
                                @endif

                            @else
                                @if (!empty($user->description))
                                    {{ $user->description }}
                                @else
                                    No description yet.
                                @endif
                            @endauth
                        </div>
                    </div>
                    
                    <div class="card-footer" id="social-media">
                        <ul class="mb-0 list-inline">
                            <li class="list-inline-item">
                                <a href="{{ $user->facebook ? $user->facebook : '#' }}" target="_blank" rel="noopener noreferrer" title="Facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ $user->instagram ? $user->instagram : '#' }}" target="_blank" rel="noopener noreferrer" title="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ $user->twitter ? $user->twitter : '#' }}" target="_blank" rel="noopener noreferrer" title="Twitter">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col col-12 col-lg-4 sticky-top" id="articles">
                <div class="mt-3 card">
                    <div class="card-header d-flex align-items-center">
                        <h6 class="py-2 my-0 fw-bold">Scan here!</h6>
                    </div>
                    <div class="gap-1 card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="qr-code">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(request()->getSchemeAndHttpHost() . '/@' . $user->slug) }}&size=100x100" alt="QR Code" id="qr-code" data-filename="{{ $user->slug }}">
                        </div>
                        <span class="text-center text-muted fs-8">{{ request()->getSchemeAndHttpHost() . '/@' . $user->slug }}</span>
                        <div class="gap-2 d-grid d-md-flex justify-content-md-center w-100">
                            <button class="gap-1 btn btn-sm border-0 btn-primary d-flex align-items-center justify-content-center rounded-circle" id="download-qr-btn">
                                <i class='bx bxs-download'></i> QR Code
                            </button>
                            <button class="gap-1 btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center rounded-circle" id="copy-link">
                                <i class='bx bxs-copy'></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-3 card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="py-2 my-0 fw-bold">Articles</h6>
                            <a href="{{ route('author.article', $user->slug) }}" class="fs-7">See all</a>
                        </div>
                    </div>
                    <div class="pt-0 mt-0 card-body pb-0 mb-0">
                        @forelse ($articles as $item)
                            <a href="{{ route('detail', $item->slug) }}" class="gap-1 article d-flex align-items-center">
                                <div class="thumbnail" style="width: 50px; height: 50px;">
                                    <img class="img" src="{{ asset('storage/thumbnails/' . $item->thumbnail) }}"
                                        alt="Thumbnail">
                                </div>
                                <div class="article-info d-flex flex-column justify-content-center">
                                    <h6 class="py-0 my-0 ellipsis-1">{{ $item->title }}</h6>
                                    <div class="categories ellipsis-1">
                                        @php
                                            $categories = explode(',', $item->category);
                                        @endphp
                                        @foreach ($categories as $category)
                                            <span class="fs-8 text-secondary">{{ $category }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="py-2 my-0 text-muted">No articles found.</p>
                        @endforelse
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
    @auth()
        @if ($user->id == Auth::user()->id)
            <div class="modal fade" id="edit-avatar-img" tabindex="-1" aria-labelledby="edit-avatar-img-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="action position-relative">
                            <form id="delete-avatar-form-{{ Auth::user()->id }}" action="{{ route('delete-avatar', Auth::user()->id) }}" method="POST">
                                @csrf @method('DELETE') 
                                <button class="px-3 py-2 bg-danger text-light border-none border-0 position-absolute top-0 end-0" type="button" onclick="deleteAvatar({{ Auth::user()->id }})" style="margin-top: 80px; z-index: 99999;">Delete</button>
                            </form>
                        </div>

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
                                    <small class="form-text"><i>Avatar must be in .jpg, .jpeg, .png, or .webp format</i></small>
                                </div>
                                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="slug" value="{{ Auth::user()->slug }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
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

    <!-- Followers Modal -->
    @livewire('follow-modal', ['userId' => $user->id])
@endsection

@push('scripts')
    @livewireScripts()

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('download-qr-btn').addEventListener('click', function () {
            const qrImage = document.getElementById('qr-code');
            const imageUrl = qrImage.src;
            const filename = qrImage.getAttribute('data-filename') || 'qr-code';
        
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
        
            img.crossOrigin = 'Anonymous'; // agar tidak kena CORS
            img.onload = function () {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
        
                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'qr-code-' + filename + '.png';
                link.click();
            };
        
            img.src = imageUrl;
        });

        document.getElementById('copy-link').addEventListener('click', function () {
            const link = document.createElement('input');
            link.value = '{{ request()->getSchemeAndHttpHost() . '/@' . $user->slug }}';
            document.body.appendChild(link);
            link.select();
            document.execCommand('copy');
            document.body.removeChild(link);

            const icon = this.querySelector('i');
            icon.classList.remove('bxs-copy');
            icon.classList.add('bx-check');

            setTimeout(function () {
                icon.classList.remove('bx-check');
                icon.classList.add('bxs-copy');
            }, 3000);
        });

        function unfollow(userId, avatar, avatar_google, slug, name) {
            var avatarUrl = avatar ? '{{ asset('storage/avatars/') }}/' + avatar : 
                    (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));
                
            $('#unfollow-form').attr('action', "{{ route('unfollow', '') }}" + '/' + userId);

            Swal.fire({
                title: '<img src="' + avatarUrl + '" class="profile-image" style="width: 90px; height: 90px; border-radius: 50%;">',
                html: '<p class="my-0 py-0 text-dark">Unfollow <b>' + name + '</b> <small>(@' + slug + ')</small>?</p>',
                showCancelButton: true,
                confirmButtonText: 'Unfollow',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    cancelButton: 'bg-soft-blue text-dark border-0 shadow-none',
                    confirmButton: 'bg-danger border-0 shadow-none',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('unfollow-form').submit();
                }
            });
        }

        function removeFollower(userId, avatar, avatar_google, slug, name) {
            var avatarUrl = avatar ? '{{ asset('storage/avatars/') }}/' + avatar : 
                    (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));
                
            $('#removeFollower-form').attr('action', "{{ route('removeFollower', '') }}" + '/' + userId);

            Swal.fire({
                title: '<img src="' + avatarUrl + '" class="profile-image" style="width: 90px; height: 90px; border-radius: 50%;">',
                html: '<p class="my-0 py-0 text-dark">Remove <b>' + name + '</b> <small>(@' + slug + ')</small> from your followers?</p>',
                showCancelButton: true,
                confirmButtonText: 'Remove',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    cancelButton: 'bg-soft-blue text-dark border-0 shadow-none',
                    confirmButton: 'bg-danger border-0 shadow-none',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('removeFollower-form').submit();
                }
            });
        }
    </script>
@endpush
