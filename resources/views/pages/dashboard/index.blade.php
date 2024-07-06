@extends('layouts.main')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0 text-dark fw-bold">Dashboard</h3>
        <a href="{{ route('dashboard.create') }}" class="btn btn-primary">Tambah Artikel</a>
    </div>

    @include('components.alert')

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul Artikel</th>
                            <th>Tanggal Post</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $index => $item)
                        <tr class="align-middle">
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
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
                            <td class="text-center" colspan="4">Data tidak ada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDeleteArticle(articleId) {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin menghapus artikel ini?',
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
                    document.getElementById('delete-article-form-' + articleId).submit();
                }
            });
        }
    </script>
@endpush
