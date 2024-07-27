@extends('layouts.main')

@push('styles')
    @livewireStyles()
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0 text-dark fw-bold">Categories</h3>
        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-kategori-modal">Tambah Kategori</a>
    </div>

    @include('components.toast')

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="table-responsive pb-5">
                <table class="table table-striped table-hover" id="myDataTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Updated_at</th>
                            <th>Created_at</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr class="align-middle">
                                <td>{{ $item->title }}</td>
                                <td>{{ Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y, H:i') }} WIB</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }} WIB</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


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
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Datatables Js -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
        $('#myDataTable').DataTable({
            "language": {
                "searchPlaceholder": "Search category..."
            }
        });


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
