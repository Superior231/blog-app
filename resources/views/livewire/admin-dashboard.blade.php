<div>
    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="actions d-flex justify-content-between gap-2">
                <!-- Filters -->
                <div class="container-filters d-flex position-relative gap-2">
                    <div class="btn-group">
                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">Kategori</button>
                        <ul class="dropdown-menu dropdown-menu-lg-start">
                            @foreach ($categories as $category)
                                <li>
                                    <label class="dropdown-item" style="cursor: pointer;">
                                        <input type="checkbox" wire:model.live="categoryFilters" value="{{ $category->title }}"> {{ $category->title }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Filters End -->

                <!-- Search -->
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input class="ms-0 ps-1" type="search" placeholder="Cari artikel..." autocomplete="off"  wire:model.live="search" style="outline: none !important; border: none;">
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

            <div class="category mt-2 mb-3">
                @foreach ($sortedCategoryFilters  as $filter)
                    <span class="badge bg-primary">{{ $filter }}</span>
                @endforeach
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Judul Artikel</th>
                            <th>Author</th>
                            <th>Updated_at</th>
                            <th>Created_at</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $index => $item)
                            <tr class="align-middle">
                                <td class="text-center">{{ ($articles->currentPage() - 1) * $articles->perPage() + $index + 1 }}</td>
                                <td>
                                    <div class="title" style="min-width: 250px;">
                                        {{ $item->title }}
                                    </div>
                                </td>
                                <td>
                                    <div class="username-info d-flex justify-content-center align-items-center gap-2" style="width: max-content;">
                                        <div class="profile-image">
                                            @if (!empty($item->user->avatar))
                                                <img class="img" src="{{ asset('storage/avatars/' . $item->user->avatar) }}">
                                            @elseif (!empty($item->user->avatar_google))
                                                <img class="img" src="{{ $item->user->avatar_google }}">
                                            @else
                                                <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->user->name) }}">
                                            @endif
                                        </div>
                                        <span class="fw-normal py-0 my-0">{{ $item->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="created-at" style="width: max-content;">
                                        {{ Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y, H:i') }} WIB
                                    </div>
                                </td>
                                <td>
                                    <div class="created-at" style="width: max-content;">
                                        {{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }} WIB
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('dashboard.edit', $item->slug) }}" class="btn py-1 btn-primary fw-normal">Edit</a>
                                        <form id="delete-article-form-{{ $item->id }}" action="{{ route('dashboard.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
        
                                            <button type="button" class="btn py-1 btn-light fw-normal" onclick="confirmDeleteArticle({{ $item->id }})">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">Artikel tidak ada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
</div>
