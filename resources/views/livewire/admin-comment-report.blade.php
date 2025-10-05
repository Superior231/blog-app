<div>
    <div class="user-reports-container">
        <div class="comment-reports">
            <div class="title d-flex align-items-center mx-0 px-0 pb-3 mt-5">
                <h3 class="mb-0 text-dark fw-bold">Comment Reports</h3>
            </div>
    
            <div class="actions mb-4">
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input class="ms-0 ps-1" type="search" id="search" placeholder="Search..." autocomplete="off"  wire:model.live="search" style="outline: none !important; border: none;">
                    <button wire:click="filterCommentRepors" class="border-none border-0 p-0 m-0 bg-transparent" title="Filter">
                        <i class='bx bx-menu-alt-left {{ $filter === "asc" ? "bx-rotate-180" : "" }} fs-5 p-0 m-0 mt-1'></i>
                    </button>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
                @forelse ($commentReports as $item)
                    <div class="col">
                        <div class="card card-report">
                            <div class="card-header border-0">
                                <div class="title d-flex justify-content-between">
                                    <h5 class="from">From:</h5>
                                    <div class="actions">
                                        <div class="dropdown">
                                            <i class="bx bx-dots-vertical-rounded fs-5" id="action-{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;" title="Actions"></i>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="action-{{ $item->id }}">
                                                <li>
                                                    <a class="dropdown-item">
                                                        <form id="delete-comment-form-{{ $item->id }}-{{ $item->comment->id }}" action="{{ route('report.delete.comment', $item->comment->id) }}" method="post" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="bg-transparent border-0 text-secondary" onclick="confirmDeleteComment({{ $item->id }}, {{ $item->comment->id }})">
                                                                Delete comment
                                                            </button>
                                                        </form>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item">
                                                        <form id="delete-report-form-{{ $item->id }}" action="{{ route('report.delete', $item->id) }}" method="post" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="bg-transparent border-0 text-secondary" onclick="confirmDeleteReport({{ $item->id }})">
                                                                Delete report
                                                            </button>
                                                        </form>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item">
                                                        <form id="banned-user-form-{{ $item->id }}-{{ $item->comment->user->id }}" action="{{ route('users.update', $item->comment->user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Banned">
                                                            <input type="hidden" name="roles" value="{{ $item->comment->user->roles }}">
                                                            <input type="hidden" name="name" value="{{ $item->comment->user->name }}">
                                                            <input type="hidden" name="email" value="{{ $item->comment->user->email }}">
                                                            <button type="button" class="bg-transparent border-0 text-secondary" onclick="confirmBannedUser({{ $item->id }}, {{ $item->comment->user->id }})">
                                                                Banned user
                                                            </button>
                                                        </form>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="username my-2">
                                    <div class="username-info">
                                        <div class="profile-image">
                                            @if (!empty($item->user->avatar))
                                                <img class="img" src="{{ asset('storage/avatars/' . $item->user->avatar) }}">
                                            @elseif (!empty($item->user->avatar_google))
                                                <img class="img" src="{{ $item->user->avatar_google }}">
                                            @else
                                                <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->user->name) }}">
                                            @endif
                                        </div>
                                        <div class="nickname">
                                            <p class="fw-semibold p-0 m-0 fs-7">{{ $item->user->name }}</p>
                                            <p class="text-color p-0 m-0 fs-8">{{ $item->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" onclick="seeAll({{ $item->id }})" id="seeComment{{ $item->id }}">
                                <div class="report w-100">
                                    <div class="header d-flex justify-content-between gap-2 w-100">
                                        <div class="username d-flex justify-content-between align-items-center w-100">
                                            <div class="username-info">
                                                <div class="profile-image">
                                                    @if (!empty($item->comment->user->avatar))
                                                        <img class="img" src="{{ asset('storage/avatars/' . $item->comment->user->avatar) }}">
                                                    @elseif (!empty($item->comment->user->avatar_google))
                                                        <img class="img" src="{{ $item->comment->user->avatar_google }}">
                                                    @else
                                                        <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->comment->user->name) }}">
                                                    @endif
                                                </div>
                                                <div class="nickname">
                                                    <p class="fw-semibold p-0 m-0 fs-7">{{ $item->comment->user->name }}</p>
                                                    <p class="text-color p-0 m-0 fs-8">{{ $item->comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <div class="reason">
                                                <span class="badge bg-primary">{{ $item->report }}</span>
                                            </div>
                                        </div>
                                        <div class="action d-flex align-items-center">
                                            <i class='fa-solid fa-angle-up fs-8' id="iconSeeComment{{ $item->id }}"></i>
                                        </div>
                                    </div>
                                    <div class="report-info d-none mt-3" id="reportBody{{ $item->id }}">
                                        <span class="comment-body">
                                            {{ $item->comment->body }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="error-message-container d-flex justify-content-center align-items-center py-5 w-100">
                        <h5 class="text-color">No report found.</h5>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="pagination-container d-flex justify-content-center align-items-center my-3 my-md-4">
            {{ $commentReports->links() }}
        </div>
    </div>
</div>
