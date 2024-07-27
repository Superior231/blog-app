function deleteAvatar(userId) {
    Swal.fire({
        icon: 'question',
        title: 'Anda Yakin?',
        text: 'Apakah Anda yakin ingin menghapus avatar ini?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
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
            document.getElementById('delete-avatar-form-' + userId).submit();
        }
    });
}

function deleteBanner(userId) {
    Swal.fire({
        icon: 'question',
        title: 'Anda Yakin?',
        text: 'Apakah Anda yakin ingin menghapus banner ini?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
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
            document.getElementById('delete-banner-form-' + userId).submit();
        }
    });
}