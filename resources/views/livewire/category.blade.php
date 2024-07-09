<div>
    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="actions d-flex justify-content-end mb-3">
                <!-- Search -->
                <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input class="ms-0 ps-1" type="search" id="search" placeholder="Cari kategori..." autocomplete="off"  wire:model.live="search" style="outline: none !important; border: none;">
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
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="#" class="btn py-1 btn-primary fw-normal" onclick="editCategory('{{ $item->id }}', '{{ $item->title }}')" data-bs-toggle="modal" data-bs-target="#edit-kategori-modal">Edit</a>
                                    <form id="delete-category-form-{{ $item->id }}" action="{{ route('category.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
    
                                        <button type="button" class="btn py-1 btn-light fw-normal" onclick="confirmDeleteCategory({{ $item->id }})">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                            
                        @empty
                        <tr>
                            <td class="text-center" colspan="4">Kategori tidak ada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container d-flex justify-content-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
