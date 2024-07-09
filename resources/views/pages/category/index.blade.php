@extends('layouts.main')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0 text-dark fw-bold">Categories</h3>
        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-kategori-modal">Tambah Kategori</a>
    </div>

    @include('components.alert')

    @livewire('category')


    <!-- Modal -->
        <!-- Modal Tambah Kategori -->
        <div class="modal fade" id="tambah-kategori-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header mb-0 pb-0 border-0 d-flex align-items-center justify-content-between">
                            <h3 class="modal-title" id="tambah-kategori-label">Tambah Kategori</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="title" class="mb-1">Kategori</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan nama kategorinya" required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-primary px-4" id="tambah-kategori-btn">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Tambah Kategori -->

        <!-- Modal Edit Kategori -->
        <div class="modal fade" id="edit-kategori-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header mb-0 pb-0 border-0 d-flex align-items-center justify-content-between">
                        <h3 class="modal-title" id="edit-kategori-label">Edit Kategori</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form id="edit-category-form" method="POST">
                        @csrf @method('PUT')

                        <div class="modal-body">
                            <label for="edit-title" class="mb-1">Kategori</label>
                            <input type="text" name="title" class="form-control" id="edit-title" placeholder="Masukkan nama kategorinya" required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" id="edit-kategori-btn" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        <!-- Modal Edit Kategori End -->
    <!-- Modal End -->
@endsection

@push('scripts')
    @livewireScripts()
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function editCategory(id, title) {
            $('#edit-title').val(title);

            $('#edit-category-form').attr('action', "{{ route('category.update', '') }}" + '/' + id);
            $('#edit-kategori-modal').modal('show');
        }

        function confirmDeleteCategory(categoryId) {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin menghapus kategori ini?',
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
                    document.getElementById('delete-category-form-' + categoryId).submit();
                }
            });
        }
    </script>
@endpush
