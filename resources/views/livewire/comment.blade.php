<div>
    <div class="comment py-3 py-md-5">
        <h3 class="py-3">Komentar</h3>

        {{-- Your Comment --}}
        @auth()
            <form action="#" class="header d-flex align-items-start gap-2">
                <div class="profile-image">
                    @if (!empty(Auth::user()->avatar))
                        <img class="img" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                    @elseif (!empty(Auth::user()->avatar_google))
                        <img class="img" src="{{ Auth::user()->avatar_google }}">
                    @else
                        <img class="img"
                            src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                    @endif
                </div>

                <div class="input-comment d-flex align-items-center gap-2 w-100">
                    <textarea name="comment" placeholder="Tulis komentarmu..." oninput="commentBox(this, 'commentBtn')"></textarea>
                    <button type="submit" id="commentBtn" title="Kirim Komentar" disabled>
                        <i class='bx bxs-send'></i>
                    </button>
                </div>
            </form>
        @else
            <div class="header d-flex align-items-start-gap-2">
                <div class="profile-image">
                    <img class="img" src="{{ url('assets/images/user.jpg') }}">
                </div>

                <div class="input-comment d-flex align-items-center gap-2 w-100">
                    <textarea name="comment" id="comment" placeholder="Tulis komentarmu..." oninput="commentBox(this)"></textarea>
                    <button type="button" id="sendBtn" onclick="login()" title="Kirim Komentar">
                        <i class='bx bxs-send'></i>
                    </button>
                </div>
            </div>
        @endauth
        {{-- Your Comment End --}}


        {{-- Filter --}}
        <div class="dropdown d-flex justify-content-end my-4 my-md-5">
            <a class="dropdown-toggle text-decoration-none text-dark fw-medium fs-6 p-0 m-0" style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">Komentar terpopuler</a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item bg-primary text-light" href="#" wire:click.prevent="$emit('setFilter', 'popular')">Komentar terpopuler</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="$emit('setFilter', 'latest')">Terbaru</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="$emit('setFilter', 'all')">Semua komentar</a>
                </li>
            </ul>
        </div>
        {{-- Filter End --}}


        {{-- Comments --}}
        <div class="comment-container">
            <div class="comment-content">
                <div class="header d-flex gap-1">
                    <a href="#" class="profile-image">
                        <img class="img" src="{{ url('assets/images/user.jpg') }}">
                    </a>
                    <div class="user-info d-flex justify-content-between w-100">
                        <a href="#" class="author-name text-dark d-flex align-items-start gap-2">
                            <div class="username d-flex flex-column gap-0">
                                <p class="fw-semibold p-0 m-0 fs-7">Hikmal Falah Agung M</p>
                                <p class="text-color fs-7">
                                    @hikmalfalaham
                                </p>
                            </div>
                            <p class="text-color p-0 m-0 fs-8">&middot; 5 menit yang lalu</p>
                        </a>
                        <div class="actions d-flex align-items-center gap-2">
                            <div class="hapus">
                                <a class="text-danger text-decoration-none" href="#" title="Hapus Komentar">
                                    <i class='bx bx-trash-alt fs-5'></i>
                                </a>
                            </div>

                            <div class="dropdown">
                                <a class="report-comment text-color" href="#" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown">
                                    <i class='bx bx-error-circle fs-5'></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        @auth()
                                            <button data-bs-toggle="modal" data-bs-target="#reportComment"
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
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda possimus unde nisi quae recusandae libero odio ipsum excepturi fugiat atque.
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
                        <div class="replay text-decoration-none" style="cursor: pointer;" onclick="replay(1)">
                            <span class="fw-semibold">(1) Balas</span>
                        </div>
                    </div>
                </div>
                {{-- User Comment End --}}


                {{-- Replay --}}
                <div class="replay-comment d-none mt-3" id="replay-comment-1">
                    @auth()
                        <form wire:submit.prevent="replayStore(1)" class="header d-flex align-items-start gap-2">
                            <div class="profile-image">
                                @if (!empty(Auth::user()->avatar))
                                    <img class="img" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                                @elseif (!empty(Auth::user()->avatar_google))
                                    <img class="img" src="{{ Auth::user()->avatar_google }}">
                                @else
                                    <img class="img"
                                        src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                                @endif
                            </div>

                            <div class="input-comment d-flex align-items-center gap-2 w-100">
                                <textarea name="replay" placeholder="Balas komentar..." oninput="commentBox(this, 'replayBtn')"></textarea>
                                <button type="submit" id="replayBtn" title="Kirim Replay" disabled>
                                    <i class='bx bxs-send'></i>
                                </button>
                            </div>
                        </form>
                    @endauth

                    <hr class="bg-secondary w-100">
                    <div class="comment-replay text-decoration-none d-flex flex-column gap-0 ms-4">
                        <div class="header d-flex">
                            <a href="#" class="profile-image">
                                <img class="img" src="{{ url('assets/images/user.jpg') }}">
                            </a>
                            <div class="user-info d-flex justify-content-between w-100">
                                <a href="#" class="author-name text-dark d-flex align-items-start gap-2">
                                    <div class="username d-flex flex-column gap-0">
                                        <p class="fw-semibold p-0 m-0 fs-7">Justina Xie</p>
                                        <p class="text-color fs-7">
                                            @xcl0624
                                        </p>
                                    </div>
                                    <p class="text-color p-0 m-0 fs-8">&middot; 1 menit yang lalu</p>
                                </a>
                                <div class="actions d-flex align-items-center gap-2">
                                    <div class="hapus">
                                        <a class="text-danger text-decoration-none" href="#"
                                            title="Hapus Komentar">
                                            <i class='bx bx-trash-alt fs-5'></i>
                                        </a>
                                    </div>

                                    <div class="dropdown">
                                        <a class="report-comment text-color" href="#"
                                            id="dropdownMenuLink-replay" data-bs-toggle="dropdown">
                                            <i class='bx bx-error-circle fs-5'></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink-replay">
                                            <li>
                                                @auth()
                                                    <button data-bs-toggle="modal" data-bs-target="#reportComment"
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


                        {{-- user replay --}}
                        <div class="user-comment d-flex flex-column mt-0 py-0">
                            <span class="comment-body">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minus quae veritatis, quas
                                quaerat expedita perspiciatis facere. Explicabo voluptatum alias autem vitae
                                suscipit fuga doloremque libero? Sapiente enim laborum.
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
                        {{-- user replay end --}}
                    </div>
                </div>
                {{-- Replay End --}}
            </div>
            <hr class="bg-secondary w-100">
        </div>
        {{-- Comments End --}}
    </div>
</div>
