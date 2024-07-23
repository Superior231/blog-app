// Comment Box
function commentBox(textarea, buttonId) {
    try {
        textarea.style.height = 'auto'; // Reset the height
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Set the height to the scroll height

        const button = document.getElementById(buttonId);
        const commentText = textarea.value.trim();
        
        if (commentText.length > 0) {
            button.classList.add('text-primary');
            button.disabled = false;
        } else {
            button.classList.remove('text-primary');
            button.disabled = true;
        }
    } catch (error) {
        console.error('Fitur comment box tidak ditemukan!', error);
    }
}
// Comment Box End



function confirmDeleteComment(commentId) {
    Swal.fire({
        icon: 'question',
        title: 'Anda Yakin?',
        text: 'Apakah Anda yakin ingin menghapus komentar ini?',
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
            Swal.fire({
                title: "Deleted!",
                text: "Komentar berhasil dihapus!",
                icon: "success",
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    confirmButton: 'sw-confirm',
                }
            });

            Livewire.emit('deleteComment', commentId);
        }
    });
}

function confirmDeleteReplay(commentId) {
    Swal.fire({
        icon: 'question',
        title: 'Anda Yakin?',
        text: 'Apakah Anda yakin ingin menghapus komentar ini?',
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
            Swal.fire({
                title: "Deleted!",
                text: "Komentar berhasil dihapus!",
                icon: "success",
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    confirmButton: 'sw-confirm',
                }
            });

            Livewire.emit('deleteComment', commentId); // Emit event to delete replay
        }
    });
}

function replay(commentId) {
    const replayComment = document.getElementById(`replay-comment-${commentId}`);
    if (replayComment) {
        if (replayComment.classList.contains('d-none')) {
            replayComment.classList.remove('d-none');
            replayComment.classList.add('d-block');
        } else {
            replayComment.classList.remove('d-block');
            replayComment.classList.add('d-none');
        }
    }
}

function reportComment(id, avatar, avatar_google, name, created_at, body) {
    var avatarUrl = avatar ? "{{ asset('storage/avatars/') }}/" + avatar : 
            (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));

    $('#comment_id').val(id);
    $('#user-profile').attr('src', avatarUrl);
    $('#username').text(name);
    $('#created_at').text(created_at);
    $('#comment-body').text(body);
    $('#reportComment').modal('show');
}

function reportReplay(id, avatar, avatar_google, name, created_at, body) {
    var avatarUrl = avatar ? "{{ asset('storage/avatars/') }}/" + avatar : 
            (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));

    $('#comment_id').val(id);
    $('#user-profile').attr('src', avatarUrl);
    $('#username').text(name);
    $('#created_at').text(created_at);
    $('#comment-body').text(body);
    $('#report-comment-form').attr('action', '#' + id);
    $('#reportComment').modal('show');
}