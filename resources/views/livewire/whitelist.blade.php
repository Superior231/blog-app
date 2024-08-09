<div>
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
            <div class="dropdown">
                <a class="d-flex align-items-center justify-content-center text-decoration-none p-0 m-0" style="cursor: pointer;" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" title="Filter">
                    <i class='bx bx-slider p-0 m-0'></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end" aria-labelledby="dropdownMenuLink">
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
    

    <div class="row row-cols-1 whitelist-content g-3 py-3 mt-2">
        @forelse ($whitelisted as $item)
            <a href="{{ route('detail', $item->slug) }}" class="col text-dark mt-0">
                <div class="thumbnail">
                    <img src="{{ url('storage/thumbnails/' . $item->thumbnail) }}" alt="thumbnail" class="rounded-3 mb-3">
                </div>
                <div class="article-info d-flex justify-content-between gap-2 mt-0">
                    <div class="article-body d-flex flex-column">
                        <div class="category mb-2 gap-2">
                            @foreach (explode(',', $item->category) as $categories)
                                <p class="badge p-1 m-0 text-primary">{{ $categories }}</p>
                            @endforeach
                        </div>
                        <h3 class="article-title fw-semibold">{{ $item->title }}</h3>
                    </div>
                    <div class="action d-flex align-items-center">
                        <a onclick="whitelist('{{ $item->id }}')" style="cursor: pointer;">
                            <i class='bx bxs-bookmark-star text-primary fs-4 mt-2'></i>
                        </a>
                    </div>
                </div>
            </a>

            <hr class="text-secondary">

        @empty
            <div class="d-flex justify-content-center align-items-center">
                <p class="fs-4 text-dark">Artikel tidak ada.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-container d-flex justify-content-center">
        {{ $whitelisted->links() }}
    </div>
</div>

@push('scripts')
    <script>
        function whitelist(article_id) {
            Swal.fire({
                icon: 'info',
                title: 'Information',
                text: 'Anda yakin ingin menghapus artikel ini di whitelist Anda?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    icon: 'border-primary text-primary',
                    confirmButton: 'btn-primary',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('whitelist', article_id);
                }
            })
        }
    </script>
@endpush
