@extends('layouts.main')

@push('styles')
    @livewireStyles()
    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    @include('components.toast')

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

        <div class="col text-decoration-none">
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

        <div class="col text-decoration-none">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="info d-flex align-items-center gap-3">
                        <i class='bx bxs-check-circle fs-1 text-success py-0 my-0'></i>
                        <div class="card-info d-flex flex-column justify-content-center gap-2">
                            <h4 class="py-0 my-0 fw-semibold">Approved</h4>
                            <h5 class="fs-6 py-0 my-0">{{ $user_approved }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col text-decoration-none">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="info d-flex align-items-center gap-3">
                        <i class='bx bxs-x-circle fs-1 text-danger py-0 my-0'></i>
                        <div class="card-info d-flex flex-column justify-content-center gap-2">
                            <h4 class="py-0 my-0 fw-semibold">Banned</h4>
                            <h5 class="fs-6 py-0 my-0">{{ $user_banned }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col text-decoration-none">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="info d-flex align-items-center gap-3">
                        <i class='bx bxs-info-circle fs-1 text-primary py-0 my-0'></i>
                        <div class="card-info d-flex flex-column justify-content-center gap-2">
                            <h4 class="py-0 my-0 fw-semibold">Reports</h4>
                            <h5 class="fs-6 py-0 my-0">{{ $report_count }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="actions d-flex justify-content-between align-items-center">
                <h4 class="py-0 my-0 fw-bold">Users</h4>
                <a class="btn btn-primary d-flex align-items-center gap-1 px-4 py-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#tambah-user-modal">
                    <i class='bx bx-plus fs-5'></i>
                    Create
                </a>
            </div>
            <hr>
            <div class="table-responsive pb-5">
                <table class="table table-striped table-hover align-middle" id="myDataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th class="text-center">Articles</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>
                                <a href="{{ route('author.show', $item->slug) }}" class="username d-flex justify-content-start" style="width: max-content;">
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
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="fw-normal py-0 my-0">{{ $item->name }}</span>
                                            <small class="fs-7 py-0 my-0 text-color">{{ '@' . $item->slug }}</small>
                                        </div>
                                    </div>
                                </a>
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
                                <div class="articles-info text-center pe-3">
                                    <span class="fw-normal py-0 my-0">{{ $item->articles->count() }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="status-info d-flex align-items-center justify-content-center pe-3">
                                    @if ($item->status == 'Approved')
                                        <i class='bx bxs-check-circle text-success fs-3'></i>
                                    @else
                                        <i class='bx bxs-x-circle text-danger fs-3'></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="gap-2 actions d-flex align-items-center justify-content-center pe-3">
                                    <a href="#" class="p-2 rounded btn btn-primary d-flex align-items-center justify-content-center"
                                    onclick="editUsers(
                                        @js($item->id),
                                        @js($item->avatar),
                                        @js($item->avatar_google),
                                        @js($item->roles),
                                        @js($item->slug),
                                        @js($item->name),
                                        @js($item->email),
                                        @js($item->status),
                                        @js($item->password)
                                    )"
                                    data-bs-toggle="modal" data-bs-target="#edit-user-modal" title="Edit">
                                        <i class='p-0 m-0 bx bxs-pencil'></i>
                                    </a>

                                    <form id="delete-user-form-{{ $item->id }}" action="{{ route('users.destroy', $item->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="p-2 rounded btn btn-danger d-flex align-items-center justify-content-center" onclick="confirmDeleteUser({{ $item->id }})">
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

    @livewire('admin-comment-report')

    <!-- Modal -->
        <!-- Modal Tambah User -->
        <div class="modal fade" id="tambah-user-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="tambah-user-label">Create user</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="roles-tambah">Roles</label>
                            <select id="roles-tambah" name="roles" class="form-select" aria-label="Default select example">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
    
                            <label for="name-tambah" class="mt-3">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name-tambah" value="{{ old('name') }}" placeholder="Enter name" autocomplete="off" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                            <label for="email-tambah" class="mt-3">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email-tambah" placeholder="Enter Email" autocomplete="off" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                            <div class="error-message-container mt-3">
                                <label for="password-tambah">Password</label>
                                <p class="text-danger fw-bolder py-0 my-0" id="error-message-tambah-password"></p>
                            </div>
                            <div class="content-tambah-user" id="content-tambah-password">
                                <input type="password" class="form-control" name="password" id="password-tambah" placeholder="Enter password" autocomplete="off" required>
                                <div class="pass-logo-pass" style="background-color: transparent;">
                                    <div class="showPass" id="showPassTambah" style="display: none;"><i class="fa-regular fa-eye-slash"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-primary px-4" id="tambah-user-btn">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit User -->
        <div class="modal fade" id="edit-user-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="edit-user-label">Edit User</h4>
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
                                    <label for="edit-roles" class="mt-3">Roles</label>
                                    <select id="edit-roles" name="roles" class="form-select" aria-label="Default select example">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="edit-status-container w-100">
                                    <label for="edit-status" class="mt-3">Status</label>
                                    <select id="edit-status" name="status" class="form-select" aria-label="Default select example">
                                        <option value="Approved">Approved</option>
                                        <option value="Banned">Banned</option>
                                    </select>
                                </div>
                            </div>

                            <label for="edit-username" class="mt-3">Username</label>
                            <input type="text" id="edit-username" class="form-control @error('username') is-invalid @enderror" name="slug" placeholder="Enter username" autocomplete="off" required>
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        
                            <label for="edit-name" class="mt-3">Name</label>
                            <input type="text" id="edit-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter name" autocomplete="off" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
        
                            <label for="edit-email" class="mt-3">Email</label>
                            <input type="email" id="edit-email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email" autocomplete="off" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <label for="edit-password" class="mt-3">Change password</label>
                            <input type="password" class="form-control" name="password" id="edit-password" placeholder="Enter new password" autocomplete="off">
                        </div>
                        <div class="modal-footer border-0">
                            <button type="submit" id="edit-user-btn" class="btn btn-primary px-4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

        function editUsers(id, avatar, avatar_google, roles, slug, name, email, status, password) {
            var avatarUrl = avatar ? '{{ asset('storage/avatars/') }}/' + avatar : 
                    (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));

            $('#edit-avatar').attr('src', avatarUrl);
            $('#edit-avatar-input').val('');
            $('#edit-roles').val(roles);
            $('#edit-username').val(slug);
            $('#edit-name').val(name);
            $('#edit-email').val(email);
            $('#edit-status').val(status);
            $('#edit-password').val('');

            $('#edit-user-form').attr('action', "{{ route('users.update', '') }}" + '/' + id);
            $('#edit-user-modal').modal('show');
        }

        function confirmDeleteUser(userId) {
            Swal.fire({
                icon: 'question',
                title: 'Are You Sure?',
                text: 'Are you sure you want to delete this user?',
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
                    document.getElementById('delete-user-form-' + userId).submit();
                }
            });
        }

        function seeAll(commentId) {
            var detailsElement = document.getElementById("seeComment" + commentId);
            var iconSeeComment = document.getElementById("iconSeeComment" + commentId)
            var reportBody     = document.getElementById("reportBody" + commentId)

            detailsElement.classList.toggle("active");

            if (detailsElement.classList.contains("active")) {
                iconSeeComment.classList.remove("fa-angle-up");
                iconSeeComment.classList.add("fa-angle-down");
                reportBody.classList.remove("d-none");
            } else {
                iconSeeComment.classList.remove("fa-angle-down");
                iconSeeComment.classList.add("fa-angle-up");
                reportBody.classList.add("d-none");
            }
        }

        function confirmDeleteReport(reportId) {
            Swal.fire({
                icon: 'question',
                title: 'Are You Sure?',
                text: 'Are you sure you want to delete this report?',
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
                    document.getElementById('delete-report-form-' + reportId).submit();
                }
            });
        }

        function confirmDeleteComment(reportId, commentId) {
            Swal.fire({
                icon: 'question',
                title: 'Are You Sure?',
                text: 'Are you sure you want to delete this comment?',
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
                    document.getElementById('delete-comment-form-' + reportId + '-' + commentId).submit();
                }
            });
        }

        function confirmBannedUser(reportId, userId) {
            Swal.fire({
                icon: 'question',
                title: 'Are You Sure?',
                text: 'Are you sure you want to banned this user?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
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
                    document.getElementById('banned-user-form-' + reportId + '-' + userId).submit();
                }
            });
        }
    </script>
@endpush
