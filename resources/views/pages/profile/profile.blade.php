@extends('layouts.profile')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    <div class="info d-flex align-items-center justify-content-center gap-4 mt-5 mb-4 mb-md-5">
        <a class="followers-info d-flex flex-column align-items-center text-dark" data-bs-toggle="modal" data-bs-target="#followersModal">
            <h3 class="fw-semibold">{{ $user->followers->count() }}</h3>
            <p class="fs-7">Followers</p>
        </a>
        <a class="following-info d-flex flex-column align-items-center text-dark" data-bs-toggle="modal" data-bs-target="#followingModal">
            <h3 class="fw-semibold">{{ $user->following->count() }}</h3>
            <p class="fs-7">Following</p>
        </a>
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
                @if ($isFollowing)
                    <form action="{{ route('unfollow', $user->id) }}" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button class="unfollow-btn border-primary border-1 text-center bg-transparent py-2 px-3 rounded-3 w-100" type="submit">Unfollow</button>
                    </form>
                @else
                    <form action="{{ route('follow') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="followed_id" value="{{ $user->id }}">
                        <button class="follow-btn border-primary border-1 text-center text-light bg-primary py-2 px-3 rounded-3 w-100" type="submit">Follow</button>
                    </form>
                @endif
            @endif
            
        @else
            <a href="#" onclick="login()" class="follow-btn text-center text-light bg-primary py-2 px-3 rounded-3 w-100">
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

    <!-- Followers Modal -->
    @livewire('follow-modal', ['userId' => $user->id])
@endsection

@push('scripts')
    @livewireScripts()
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function unfollow(userId, avatar, avatar_google, slug) {
            var avatarUrl = avatar ? '{{ asset('storage/avatars/') }}/' + avatar : 
                    (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));
                
            $('#unfollow-form').attr('action', "{{ route('unfollow', '') }}" + '/' + userId);

            Swal.fire({
                title: '<img src="' + avatarUrl + '" class="profile-image" style="width: 90px; height: 90px; border-radius: 50%;">',
                html: '<p class="my-0 py-0 text-dark">Unfollow @' + slug + '?</p>',
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

        function removeFollower(userId, avatar, avatar_google, slug) {
            var avatarUrl = avatar ? '{{ asset('storage/avatars/') }}/' + avatar : 
                    (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));
                
            $('#removeFollower-form').attr('action', "{{ route('removeFollower', '') }}" + '/' + userId);

            Swal.fire({
                title: '<img src="' + avatarUrl + '" class="profile-image" style="width: 90px; height: 90px; border-radius: 50%;">',
                html: '<p class="my-0 py-0 text-dark">Remove @' + slug + ' from your followers ?</p>',
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
