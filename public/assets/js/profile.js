function deleteAvatar(userId) {
    Swal.fire({
        icon: 'question',
        title: 'Are You Sure?',
        text: 'Are you sure you want to delete this avatar?',
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
            document.getElementById('delete-avatar-form-' + userId).submit();
        }
    });
}

function deleteBanner(userId) {
    Swal.fire({
        icon: 'question',
        title: 'Are You Sure?',
        text: 'Are you sure you want to delete this banner?',
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
            document.getElementById('delete-banner-form-' + userId).submit();
        }
    });
}