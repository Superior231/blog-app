<div>
    <!-- Followers -->
    <!-- wire:ignore.self ==> agar pada saat search modal tetap terbuka -->
    <div wire:ignore.self class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title d-flex align-items-center justify-content-center w-100">
                        <h5 class="modal-title" id="followersLabel">Followers</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="search" wire:model.live="searchFollowers" placeholder="Search...">
                </div>
                <div class="modal-body">
                    @forelse ($followers as $item)
                        <div class="profile d-flex align-items-center gap-2 mb-3">
                            <a href="{{ route('author.show', ['slug' => $item->slug]) }}" class="profile-image position-absolute">
                                @if (!empty($item->avatar))
                                    <img class="img img-avatar" src="{{ asset('storage/avatars/' . $item->avatar) }}">
                                @elseif (!empty($item->avatar_google))
                                    <img class="img img-avatar" src="{{ $item->avatar_google }}">
                                @else
                                    <img class="img img-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->name) }}">
                                @endif
                            </a>
                            <div class="username d-flex flex-column justify-content-center gap-0 w-100">
                                <div class="name d-flex align-items-center gap-2">
                                    <a href="{{ route('author.show', ['slug' => $item->slug]) }}" class="text-dark">
                                        <h5 class="py-0 my-0">{{ $item->name }}</h5>
                                    </a>
                                    @auth()
                                        @if (!$item->followers->contains(Auth::user()->id))
                                            @if (Auth::user()->id != $item->id)
                                                <form action="{{ route('follow') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="followed_id" value="{{ $item->id }}">
                                                    <button class="follow-btn text-primary border-none border-0 bg-transparent fs-7" type="submit"> &middot; Follow</button>
                                                </form>
                                            @endif
                                        @endif
                                    @endauth
                                </div>
                                <a href="{{ route('author.show', ['slug' => $item->slug]) }}" class="text-dark">
                                    <p class="fs-7 py-0 my-0 text-color">@<small>{{ $item->slug }}</small></p>
                                </a>
                            </div>
                            @auth()
                                <div class="action d-flex justify-content-end">
                                    @if (Auth::user()->id == $item->following->contains(Auth::user()->id))
                                        <form action="{{ route('removeFollower', $item->id) }}" id="removeFollower-form"
                                            method="POST" class="w-100">
                                            @csrf @method('DELETE')
                                            <button onclick="removeFollower('{{ $item->id }}', '{{ $item->avatar }}', '{{ $item->avatar_google }}', '{{ $item->slug }}')" class="removeFollower-btn bg-soft-blue border-none border-0 py-2 px-3 rounded-3 fs-7" type="button">Hapus</button>
                                        </form>
                                    @elseif (Auth::user()->id != $item->id)
                                        @if (!$item->followers->contains(Auth::user()->id))
                                            <form action="{{ route('follow') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="followed_id" value="{{ $item->id }}">
                                                <button class="follow-btn bg-primary text-light border-none border-0 py-2 px-3 rounded-3 fs-7" type="submit">Follow</button>
                                            </form>
                                        @else
                                            <form action="{{ route('unfollow', $item->id) }}" id="unfollow-form"
                                                method="POST" class="w-100">
                                                @csrf @method('DELETE')
                                                <button onclick="unfollow('{{ $item->id }}', '{{ $item->avatar }}', '{{ $item->avatar_google }}', '{{ $item->slug }}')" class="unfollow-btn bg-soft-blue text-dark border-none border-0 py-2 px-3 rounded-3 fs-7" type="button">Following</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            @endauth
                        </div>
                    @empty
                        <div class="error-message d-flex justify-content-center align-items-center py-4">
                            <span class="py-0 my-0 fs-7">Tidak ada followers.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Folowing -->
    <div wire:ignore.self class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title d-flex align-items-center justify-content-center w-100">
                        <h5 class="modal-title" id="followingLabel">Following</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="search" wire:model.live="searchFollowing" placeholder="Search...">
                </div>
                <div class="modal-body">
                    @forelse ($following as $item)
                        <div class="profile d-flex align-items-center gap-2 mb-3">
                            <a href="{{ route('author.show', ['slug' => $item->slug]) }}" class="profile-image position-absolute">
                                @if (!empty($item->avatar))
                                    <img class="img img-avatar" src="{{ asset('storage/avatars/' . $item->avatar) }}">
                                @elseif (!empty($item->avatar_google))
                                    <img class="img img-avatar" src="{{ $item->avatar_google }}">
                                @else
                                    <img class="img img-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->name) }}">
                                @endif
                            </a>
                            <a href="{{ route('author.show', ['slug' => $item->slug]) }}" class="username text-dark d-flex flex-column justify-content-center gap-0 w-100">
                                <h5 class="py-0 my-0">{{ $item->name }}</h5>
                                <p class="fs-7 py-0 my-0 text-color">@<small>{{ $item->slug }}</small></p>
                            </a>
                            @auth()
                                <div class="action d-flex justify-content-end">
                                    @if (Auth::user()->id != $item->id)
                                        @if (!$item->followers->contains(Auth::user()->id))
                                            <form action="{{ route('follow') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="followed_id" value="{{ $item->id }}">
                                                <button class="follow-btn bg-primary text-light border-none border-0 py-2 px-3 rounded-3 fs-7" type="submit">Follow</button>
                                            </form>
                                        @else
                                            <form action="{{ route('unfollow', $item->id) }}" id="unfollow-form"
                                                method="POST" class="w-100">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="unfollow('{{ $item->id }}', '{{ $item->avatar }}', '{{ $item->avatar_google }}', '{{ $item->slug }}')" class="unfollow-btn bg-soft-blue text-dark border-none border-0 py-2 px-3 rounded-3 fs-7" type="button">Following</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            @endauth
                        </div>
                    @empty
                        <div class="error-message d-flex justify-content-center align-items-center py-4">
                            <span class="py-0 my-0 fs-7">Tidak ada following.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
