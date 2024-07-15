@extends('layouts.main')

@push('styles')
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2 mb-5" id="admin-article-info">
        <div class="col text-decoration-none">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="info d-flex align-items-center gap-3">
                        <i class='bx bxs-user-detail fs-1 text-primary py-0 my-0'></i>
                        <div class="card-info d-flex flex-column justify-content-center gap-2">
                            <h4 class="py-0 my-0 fw-semibold">Total User</h4>
                            <h5 class="fs-6 py-0 my-0">{{ $users->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col text-decoration-none">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="info d-flex align-items-center gap-3">
                        <i class='bx bxs-user-circle fs-1 text-primary py-0 my-0'></i>
                        <div class="card-info d-flex flex-column justify-content-center gap-2">
                            <h4 class="py-0 my-0 fw-semibold">Admin</h4>
                            <h5 class="fs-6 py-0 my-0">{{ $admin_total }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-md-12 text-decoration-none">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="info d-flex align-items-center gap-3">
                        <i class='bx bxs-user fs-1 text-primary py-0 my-0'></i>
                        <div class="card-info d-flex flex-column justify-content-center gap-2">
                            <h4 class="py-0 my-0 fw-semibold">Users</h4>
                            <h5 class="fs-6 py-0 my-0">{{ $user_total }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0 text-dark fw-bold">Users</h3>
        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-user-modal">Tambah User</a>
    </div>

    @include('components.alert')

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="table-responsive pb-5">
                <table class="table table-striped table-hover" id="myDataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Articles</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>
                                <div class="username d-flex justify-content-start" style="width: max-content;">
                                    <div class="username-info d-flex justify-content-center align-items-center gap-2">
                                        <div class="profile-image">
                                            @if (!empty($item->avatar))
                                                <img class="img" src="{{ asset('storage/avatars/' . $item->avatar) }}">
                                            @elseif (!empty($item->avatar_google))
                                                <img class="img" src="{{ $item->avatar_google }}">
                                            @else
                                                <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->name) }}">
                                            @endif
                                        </div>
                                        <span class="fw-normal py-0 my-0">{{ $item->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="roles-info">
                                    <span class="fw-normal py-0 my-0">
                                        {{ $item->roles }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="email-info">
                                    <span class="fw-normal py-0 my-0">{{ $item->email }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="articles-info">
                                    <span class="fw-normal py-0 my-0">{{ $item->articles->count() }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="actions d-flex justify-content-center gap-2">
                                    <a href="#" class="btn py-1 btn-primary fw-normal" onclick="editUsers('{{ $item->id }}', '{{ $item->avatar }}', '{{ $item->avatar_google }}', '{{ $item->roles }}', '{{ $item->name }}', '{{ $item->email }}')" data-bs-toggle="modal" data-bs-target="#edit-user-modal" title="Edit">Edit</a>

                                    <form id="delete-user-form-{{ $item->id }}" action="{{ route('users.destroy', $item->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn py-1 btn-light fw-normal" onclick="confirmDeleteUser({{ $item->id }})">
                                            Hapus
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
        <!-- Modal Tambah User -->
        <div class="modal fade" id="tambah-user-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header mb-0 pb-0 border-0 d-flex align-items-center justify-content-between">
                            <h3 class="modal-title" id="tambah-user-label">Tambah User</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="roles-tambah" class="mb-2 mt-3">Roles</label>
                                <select id="roles-tambah" name="roles" class="form-select" aria-label="Default select example">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
    
                            <div class="error-message-container mb-2 mt-3">
                                <label for="username-tambah">Username</label>
                                <p class="text-danger fw-bolder py-0 my-0" id="error-message-tambah-username"></p>
                            </div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="username-tambah" value="{{ old('name') }}" placeholder="Masukkan Username" autocomplete="off" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                            <label for="email-tambah" class="mb-2 mt-3">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email-tambah" placeholder="Masukkan Email" autocomplete="off" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                            <div class="error-message-container mb-2 mt-3">
                                <label for="password-tambah">Password</label>
                                <p class="text-danger fw-bolder py-0 my-0" id="error-message-tambah-password"></p>
                            </div>
                            <div class="content-tambah-user" id="content-tambah-password">
                                <input type="password" class="form-control" name="password" id="password-tambah" placeholder="Masukkan password" autocomplete="off" required>
                                <div class="pass-logo-pass" style="background-color: transparent;">
                                    <div class="showPass" id="showPassTambah" style="display: none;"><i class="fa-regular fa-eye-slash"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-primary px-4" id="tambah-user-btn">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Tambah User -->

        <!-- Modal Edit User -->
        <div class="modal fade" id="edit-user-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header mb-0 pb-0 border-0 d-flex align-items-center justify-content-between">
                        <h3 class="modal-title" id="edit-user-label">Edit User</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form id="edit-user-form" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="modal-body">
                            <figure class="profile d-flex flex-column justify-content-center align-items-center gap-3 mb-4">
                                <div class="profile-image" style="width: 80px; height: 80px;">
                                    <img id="edit-avatar" class="img img-avatar" src="">
                                </div>
                            </figure>
        
                            <label for="edit-avatar-input" class="mb-2">Upload Avatar (jpg, jpeg, png dan webp)</label>
                            <input type="file" class="form-control upload-avatar @error('avatar') is-invalid @enderror" name="avatar" accept=".jpg, .jpeg, .png" id="edit-avatar-input">
                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        
                            <div class="select-container d-flex align-items-center gap-2 w-100">
                                <div class="edit-roles-container w-100">
                                    <label for="edit-roles" class="mb-2 mt-3">Roles</label>
                                    <select id="edit-roles" name="roles" class="form-select" aria-label="Default select example">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="error-message-container mb-2 mt-3">
                                <label for="edit-name">Username</label>
                                <p class="text-danger fw-bolder py-0 my-0" id="error-message-edit-username"></p>
                            </div>
                            <input type="text" id="edit-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Masukkan Username" autocomplete="off" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        
                            <div class="error-message-container mb-2 mt-3">
                                <label for="edit-email" class="">Email</label>
                                <p class="text-danger fw-bolder py-0 my-0" id="error-message-edit-email"></p>
                            </div>
                            <input type="email" id="edit-email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email" autocomplete="off" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" id="edit-user-btn" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        <!-- Modal Edit User End -->
    <!-- Modal End -->
@endsection

@push('scripts')
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
                "searchPlaceholder": "Search users..."
            }
        });

        function editUsers(id, avatar, avatar_google, roles, name, email) {
            var avatarUrl = avatar ? '{{ asset('storage/avatars/') }}/' + avatar : 
                    (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));

            $('#edit-avatar').attr('src', avatarUrl);
            $('#edit-avatar-input').val('');
            $('#edit-roles').val(roles);
            $('#edit-name').val(name);
            $('#edit-email').val(email);

            $('#edit-user-form').attr('action', "{{ route('users.update', '') }}" + '/' + id);
            $('#edit-user-modal').modal('show');
        }

        function confirmDeleteUser(userId) {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin menghapus akun ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    icon: 'sw-icon',
                    confirmButton: 'sw-confirm',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-form-' + userId).submit();
                }
            });
        }
    </script>
@endpush
