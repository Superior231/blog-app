@extends('layouts.main')

@push('styles')
    @livewireStyles()
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    @include('components.toast')

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="actions d-flex justify-content-between align-items-center">
                <h4 class="py-0 my-0 fw-bold">Categories</h4>
                <a class="btn btn-primary d-flex align-items-center gap-1 px-4 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#tambah-kategori-modal">
                    <i class='bx bx-plus fs-5'></i>
                    Create
                </a>
            </div>
            <hr>

            <div class="table-responsive pb-5">
                <table class="table table-striped table-hover" id="myDataTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Updated at</th>
                            <th>Created at</th>
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
                                    <div class="gap-2 actions d-flex align-items-center justify-content-center pe-3">
                                        <a href="#" class="p-2 rounded btn btn-primary d-flex align-items-center justify-content-center" onclick="editCategory('{{ $item->id }}', '{{ $item->title }}')" data-bs-toggle="modal" data-bs-target="#edit-kategori-modal">
                                            <i class='p-0 m-0 bx bxs-pencil'></i>
                                        </a>
                                        <form id="delete-category-form-{{ $item->id }}" action="{{ route('category.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
        
                                            <button type="button" class="p-2 rounded btn btn-danger d-flex align-items-center justify-content-center" onclick="confirmDeleteCategory({{ $item->id }})">
                                                <i class='p-0 m-0 bx bxs-trash'></i>
                                            </button>
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
                        <div class="modal-header">
                            <h4 class="modal-title" id="tambah-kategori-label">Create category</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="title" class="mb-1">Category</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter new category" required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-primary px-4" id="tambah-kategori-btn">Create</button>
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
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-kategori-label">Edit category</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form id="edit-category-form" method="POST">
                        @csrf @method('PUT')

                        <div class="modal-body">
                            <label for="edit-title" class="mb-1">Category</label>
                            <input type="text" name="title" class="form-control" id="edit-title" placeholder="Enter new category" required>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" id="edit-kategori-btn" class="btn btn-primary px-4">Save</button>
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
                "searchPlaceholder": "Search..."
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
                title: 'Are You Sure?',
                text: 'Are you sure you want to delete this category?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    icon: 'sw-icon',
                    closeButton: 'bg-secondary border-0 shadow-none',
                    confirmButton: 'bg-danger border-0 shadow-none',
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
