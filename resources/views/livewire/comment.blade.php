<div>
    <div class="comment py-3 py-md-5">
        <h3 class="py-3">{{ $total_comments }} Komentar</h3>

        {{-- Your Comment --}}
        @auth()
            <form wire:submit.prevent="store" class="header d-flex align-items-start gap-2">
                <div class="profile-image">
                    @if (!empty(Auth::user()->avatar))
                        <img class="img" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                    @elseif (!empty(Auth::user()->avatar_google))
                        <img class="img" src="{{ Auth::user()->avatar_google }}">
                    @else
                        <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                    @endif
                </div>

                <div class="input-comment d-flex align-items-center gap-2 w-100">
                    <textarea wire:model.defer="body" placeholder="Tulis komentarmu..." oninput="commentBox(this, 'commentBtn')"></textarea>
                    <button type="submit" id="commentBtn" title="Kirim Komentar">
                        <i class='bx bxs-send'></i>
                    </button>
                </div>
            </form>
        @else
            <div class="header d-flex align-items-center justify-content-center gap-2">
                <span>Login dulu untuk berkomentar </span>
                <a href="{{ route('login') }}" class="text-decoration-underline">klik disini!</a>
            </div>
        @endauth
        {{-- Your Comment End --}}


        {{-- Filter --}}
        <div class="dropdown d-flex justify-content-end my-4 my-md-5">
            <a class="dropdown-toggle text-decoration-none text-dark fw-medium fs-6 p-0 m-0" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">{{ $filterText }}</a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item {{ $filter == 'popular' ? 'bg-primary text-light' : '' }}" href="#" wire:click.prevent="setFilter('popular')">Komentar terpopuler</a>
                </li>
                <li>
                    <a class="dropdown-item {{ $filter == 'latest' ? 'bg-primary text-light' : '' }}" href="#" wire:click.prevent="setFilter('latest')">Terbaru</a>
                </li>
                <li>
                    <a class="dropdown-item {{ $filter == 'all' ? 'bg-primary text-light' : '' }}" href="#" wire:click.prevent="setFilter('all')">Semua komentar</a>
                </li>
            </ul>
        </div>
        {{-- Filter End --}}


        {{-- Comments --}}
        <div class="comment-container">
            @forelse ($comments as $item)
                <div class="comment-content">
                    <div class="header d-flex gap-1">
                        <a href="{{ route('author.show', ['slug' => $item->user->slug]) }}" class="profile-image">
                            @if (!empty($item->user->avatar))
                                <img class="img" src="{{ asset('storage/avatars/' . $item->user->avatar) }}">
                            @elseif (!empty($item->user->avatar_google))
                                <img class="img" src="{{ $item->user->avatar_google }}">
                            @else
                                <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->user->name) }}">
                            @endif
                        </a>
                        <div class="user-info d-flex justify-content-between w-100">
                            <div class="author-name d-flex align-items-start gap-2">
                                <a href="{{ route('author.show', ['slug' => $item->user->slug]) }}" class="username d-flex flex-column gap-0">
                                    <p class="fw-semibold p-0 m-0 fs-7">{{ $item->user->name }}</p>
                                    <p class="text-color fs-7">&#64;{{ $item->user->slug }}</p>
                                </a>
                                <p class="text-color p-0 m-0 fs-8">&middot; {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="actions d-flex align-items-center gap-2">
                                @auth()
                                    @if (Auth::user()->roles == 'admin')
                                        <div class="hapus">
                                            <a class="text-danger text-decoration-none" href="#" onclick="confirmDeleteComment({{ $item->id }})" title="Hapus Komentar">
                                                <i class='bx bx-trash-alt fs-5'></i>
                                            </a>
                                        </div>

                                    @else
                                        @if ($item->user_id == Auth::user()->id)
                                            <div class="hapus">
                                                <a class="text-danger text-decoration-none" href="#" title="Hapus Komentar" onclick="confirmDeleteComment({{ $item->id }})" title="Hapus Komentar">
                                                    <i class='bx bx-trash-alt fs-5'></i>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @endauth

                                <div class="dropdown">
                                    <a class="report-comment text-color" href="#" id="dropdownMenuLink"
                                        data-bs-toggle="dropdown">
                                        <i class='bx bx-error-circle fs-5'></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li>
                                            @auth()
                                                <button onclick='reportComment({{ json_encode($item->id) }}, {{ json_encode($item->user->avatar) }}, {{ json_encode($item->user->avatar_google) }}, {{ json_encode($item->user->name) }}, {{ json_encode($item->user->slug) }}, {{ json_encode($item->created_at->diffForHumans()) }}, {{ json_encode($item->body) }})' data-bs-toggle="modal" data-bs-target="#reportComment"
                                                    class="dropdown-item d-flex align-items-center gap-2">
                                                    <i class='bx bxs-flag-alt fs-5'></i> Report
                                                </button>
                                            @else
                                                <button class="dropdown-item d-flex align-items-center gap-2" onclick="login()">
                                                    <i class='bx bxs-flag-alt fs-5'></i> Report
                                                </button>
                                            @endauth
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- User Comment --}}
                    <div class="user-comment d-flex flex-column gap-2 mt-0 py-0">
                        <span class="comment-body">
                            {{ $item->body }}
                        </span>

                        <div class="actions d-flex align-items-center justify-content-between gap-2 my-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="like text-decoration-none" style="cursor: pointer;">
                                    <span class="text-color py-0 my-0"><i class='bx bxs-like py-0 my-0'></i> 1</span>
                                </div>
                                <div class="dislike text-decoration-none" style="cursor: pointer;">
                                    <span class="text-color py-0 my-0"><i class='bx bxs-dislike py-0 my-0'></i> 0</span>
                                </div>
                            </div>
                            <div class="reply text-decoration-none" style="cursor: pointer;" onclick="reply({{ $item->id }})">
                                <span class="text-dark fs-7">{{ $item->childrens->count() > 0 ? "{$item->childrens->count()} Balasan" : 'Balas' }}</span>
                            </div>
                        </div>
                    </div>
                    {{-- User Comment End --}}


                    {{-- Reply --}}
                    <div class="reply-comment d-none mt-3" id="reply-comment-{{ $item->id }}">
                        @auth()
                            <form wire:submit.prevent="replyStore({{ $item->id }})" class="header d-flex align-items-start gap-2">
                                <div class="profile-image">
                                    @if (!empty(Auth::user()->avatar))
                                        <img class="img" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                                    @elseif (!empty(Auth::user()->avatar_google))
                                        <img class="img" src="{{ Auth::user()->avatar_google }}">
                                    @else
                                        <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                                    @endif
                                </div>

                                <div class="input-comment d-flex align-items-center gap-2 w-100">
                                    <textarea wire:model.defer="replyBodies.{{ $item->id }}" placeholder="Balas komentar..." oninput="commentBox(this, '{{ $item->id }}')"></textarea>
                                    <button type="submit" id="{{ $item->id }}" title="Kirim Balasan">
                                        <i class='bx bxs-send'></i>
                                    </button>
                                </div>
                            </form>
                        @endauth


                        <div class="comment-reply text-decoration-none d-flex flex-column gap-0 ms-4">
                            @if ($item->childrens)
                                @foreach ($item->childrens as $item2)
                                    <hr class="bg-secondary w-100">
                                    <div class="header d-flex">
                                        <a href="{{ route('author.show', ['slug' => $item2->user->slug]) }}" class="profile-image">
                                            @if (!empty($item2->user->avatar))
                                                <img class="img" src="{{ asset('storage/avatars/' . $item2->user->avatar) }}">
                                            @elseif (!empty($item2->user->avatar_google))
                                                <img class="img" src="{{ $item2->user->avatar_google }}">
                                            @else
                                                <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item2->user->name) }}">
                                            @endif
                                        </a>
                                        <div class="user-info d-flex justify-content-between w-100">
                                            <div class="author-name d-flex align-items-start gap-2">
                                                <a href="{{ route('author.show', ['slug' => $item2->user->slug]) }}" class="username d-flex flex-column gap-0">
                                                    <p class="fw-semibold p-0 m-0 fs-7">{{ $item2->user->name }}</p>
                                                    <p class="text-color fs-7">&#64;{{ $item2->user->slug }}</p>
                                                </a>
                                                <p class="text-color p-0 m-0 fs-8">&middot; {{ $item2->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="actions d-flex align-items-center gap-2">
                                                @auth
                                                    @if (Auth::user()->roles == 'admin')
                                                        <div class="hapus">
                                                            <a class="text-danger text-decoration-none" href="#" title="Hapus Komentar" onclick="confirmDeleteComment({{ $item2->id }})">
                                                                <i class='bx bx-trash-alt fs-5'></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        @if ($item2->user_id == Auth::user()->id)
                                                            <div class="hapus">
                                                                <a class="text-danger text-decoration-none" href="#" title="Hapus Komentar" onclick="confirmDeleteReplay({{ $item2->id }})">
                                                                    <i class='bx bx-trash-alt fs-5'></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endauth

                                                <div class="dropdown">
                                                    <a class="report-comment text-color" href="#"
                                                        id="dropdownMenuLink-reply" data-bs-toggle="dropdown">
                                                        <i class='bx bx-error-circle fs-5'></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink-reply">
                                                        <li>
                                                            @auth()
                                                                <button onclick='reportReplay({{ json_encode($item2->id) }}, {{ json_encode($item2->user->avatar) }}, {{ json_encode($item2->user->avatar_google) }}, {{ json_encode($item2->user->name) }}, {{ json_encode($item2->user->slug) }}, {{ json_encode($item2->created_at->diffForHumans()) }}, {{ json_encode($item2->body) }})' data-bs-toggle="modal" data-bs-target="#reportComment" class="dropdown-item d-flex align-items-center gap-2">
                                                                    <i class='bx bxs-flag-alt fs-5'></i> Report
                                                                </button>
                                                            @else
                                                                <button class="dropdown-item d-flex align-items-center gap-2" onclick="login()">
                                                                    <i class='bx bxs-flag-alt fs-5'></i> Report
                                                                </button>
                                                            @endauth
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- user reply --}}
                                    <div class="user-comment d-flex flex-column mt-0 py-0">
                                        <span class="comment-body">
                                            {{ $item2->body }}
                                        </span>

                                        <div class="actions d-flex align-items-center gap-3 my-2">
                                            <div class="like text-decoration-none" style="cursor: pointer;">
                                                <span class="text-color py-0 my-0"><i class='bx bxs-like py-0 my-0'></i> 0</span>
                                            </div>
                                            <div class="dislike text-decoration-none" style="cursor: pointer;">
                                                <span class="text-color py-0 my-0"><i class='bx bxs-dislike py-0 my-0'></i> 0</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif


                            {{-- user reply end --}}
                        </div>
                    </div>
                    {{-- Reply End --}}
                </div>
                <hr class="bg-secondary w-100">

            @empty
                <div class="error-message d-flex justify-content-center align-items-center">
                    <span>Tidak ada komentar.</span>
                </div>
            @endforelse
        </div>
        {{-- Comments End --}}
    </div>
</div>
