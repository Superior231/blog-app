<div>
    <section class="home pt-4">
        <div class="container">
            <div class="actions d-flex justify-content-between gap-2">
                <!-- Filters -->
                <div class="container-filters d-flex position-relative gap-2">
                    <div class="btn-group">
                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">Kategori</button>
                        <ul class="dropdown-menu dropdown-menu-lg-start">
                            <div class="categories" style="max-height: 300px; overflow-y: scroll;">
                                @foreach ($categories as $category)
                                    <li>
                                        <label class="dropdown-item" style="cursor: pointer;">
                                            <input type="checkbox" wire:model.live="categoryFilters" value="{{ $category->title }}"> {{ $category->title }}
                                        </label>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                </div>
                <!-- Filters End -->

                <!-- Search -->
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input class="ms-0 ps-1" type="search" id="search" placeholder="Cari artikel..." autocomplete="off"  wire:model.live="search" style="outline: none !important; border: none;">
                    <div class="dropdown dropup">
                        <a class="d-flex align-items-center justify-content-center text-decoration-none p-0 m-0" style="cursor: pointer;" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" title="Filter">
                            <i class='bx bx-slider p-0 m-0'></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item {{ $currentFilter == 'Terbaru' ? 'bg-primary text-light' : '' }}" wire:click="sortBy('terbaru')" style="cursor: pointer;">Terbaru</a></li>
                            <li><a class="dropdown-item {{ $currentFilter == 'Terlama' ? 'bg-primary text-light' : '' }}" wire:click="sortBy('terlama')" style="cursor: pointer;">Terlama</a></li>
                            <li><a class="dropdown-item {{ $currentFilter == 'A - Z' ? 'bg-primary text-light' : '' }}" wire:click="sortBy('az')" style="cursor: pointer;">A - Z</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Search End -->
            </div>

            <div class="category mt-2">
                @foreach ($sortedCategoryFilters  as $filter)
                    <span class="badge bg-primary">{{ $filter }}</span>
                @endforeach
            </div>

            <div class="row g-3 g-md-4 mt-0 pt-0 mt-lg-2 mb-5">
                @forelse ($articles as $item)
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card h-100">
                            <a href="{{ route('detail', $item->slug) }}" class="article h-100">
                                <div class="thumbnail">
                                    <img src="{{ url('storage/thumbnails/' . $item->thumbnail) }}" alt="thumbnail" class="rounded-3 mb-3">
                                </div>
                                <div class="category d-flex flex-wrap mb-3 gap-2">
                                    @foreach (explode(',', $item->category) as $categories)
                                        <p class="badge p-1 m-0 text-primary">{{ $categories }}</p>
                                    @endforeach
                                </div>
                                <h3 class="article-title mb-3">{{ $item->title }}</h3>
                            </a>
                            
                            <div class="article-interaction d-flex align-items-center justify-content-end gap-2 mt-2">
                                <div class="likes d-flex align-items-center gap-1">
                                    <i class='bx bxs-like'></i>
                                    <p class="my-0 py-0 text-dark fs-7">{{ $item->like_articles->where('like', true)->count() }}</p>
                                </div>
                                <div class="dislikes d-flex align-items-center gap-1">
                                    <i class='bx bxs-dislike'></i>
                                    <p class="my-0 py-0 text-dark fs-7">{{ $item->like_articles->where('dislike', true)->count() }}</p>
                                </div>
                                <div class="comments d-flex align-items-center gap-1">
                                    <i class='bx bxs-comment-detail'></i>
                                    <p class="my-0 py-0 text-dark fs-7">5</p>
                                </div>
                            </div>

                            <hr class="bg-secondary">
                            <div class="footer d-flex justify-content-between align-items-center">
                                <a href="{{ route('author.show', ['slug' => $item->user->slug]) }}" class="author d-flex align-items-center gap-1">
                                    <div class="profile-author">
                                        @if (!empty($item->user->avatar))
                                            <img class="img" src="{{ asset('storage/avatars/' . $item->user->avatar) }}">
                                        @elseif (!empty($item->user->avatar_google))
                                            <img class="img" src="{{ $item->user->avatar_google }}">
                                        @else
                                            <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->user->name) }}">
                                        @endif
                                    </div>
                                    <p class="my-0 py-0 text-dark fs-7">{{ $item->author ? $item->author : $item->user->name }}</p>
                                </a>
                                <p class="mb-0 text-secondary fs-7">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="fs-4 text-dark">Artikel tidak ada.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-container d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
        </div>
    </section>
</div>
