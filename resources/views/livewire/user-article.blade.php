<div>
    <section class="home pt-4">
        <div class="container">
            <div class="actions d-flex justify-content-between gap-2">
                <!-- Filters -->
                <div class="container-filters d-flex position-relative gap-2">
                    <div class="btn-group">
                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static"
                            aria-expanded="false">Kategori</button>
                        <ul class="dropdown-menu dropdown-menu-lg-start">
                            <div class="categories" style="max-height: 300px; overflow-y: scroll;">
                                @foreach ($categories as $category)
                                    <li>
                                        <label class="dropdown-item" style="cursor: pointer;">
                                            <input type="checkbox" wire:model.live="categoryFilters"
                                                value="{{ $category->title }}"> {{ $category->title }}
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
                    <input class="ms-0 ps-1" type="search" id="search" placeholder="Cari artikel..."
                        autocomplete="off" wire:model.live="search" style="outline: none !important; border: none;">
                    <div class="dropdown dropup">
                        <a class="d-flex align-items-center justify-content-center text-decoration-none p-0 m-0"
                            style="cursor: pointer;" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Filter">
                            <i class='bx bx-slider p-0 m-0'></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item {{ $currentFilter == 'Terbaru' ? 'bg-primary text-light' : '' }}"
                                    wire:click="sortBy('terbaru')" style="cursor: pointer;">Terbaru</a></li>
                            <li><a class="dropdown-item {{ $currentFilter == 'Terlama' ? 'bg-primary text-light' : '' }}"
                                    wire:click="sortBy('terlama')" style="cursor: pointer;">Terlama</a></li>
                            <li><a class="dropdown-item {{ $currentFilter == 'A - Z' ? 'bg-primary text-light' : '' }}"
                                    wire:click="sortBy('az')" style="cursor: pointer;">A - Z</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Search End -->
            </div>

            <div class="category mt-2">
                @foreach ($sortedCategoryFilters as $filter)
                    <span class="badge bg-primary">{{ $filter }}</span>
                @endforeach
            </div>

            <div class="articles mt-4 mb-5">
                @forelse ($articles as $item)
                    <div class="card bg-transparent">
                        <a href="{{ route('detail', $item->slug) }}" class="article">
                            <div class="row g-0">
                                <div class="col-3 col-md-2">
                                    <div class="thumbnail">
                                        <img src="{{ url('storage/thumbnails/' . $item->thumbnail) }}" alt="thumbnail" class="rounded-3">
                                    </div>
                                </div>
                                <div class="col-9 col-md-10">
                                    <div class="card-body ps-3 py-0 my-0">
                                        <h3 class="article-title">{{ $item->title }}</h3>
                                        <p class="mb-0 text-secondary fs-7">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <hr class="text-secondary">

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
