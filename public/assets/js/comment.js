// Comment Box
function commentBox(textarea, buttonId) {
    try {
        textarea.style.height = 'auto'; // Reset the height
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Set the height to the scroll height

        const button = document.getElementById(buttonId);
        const commentText = textarea.value.trim();
        
        if (commentText.length > 0) {
            button.classList.add('text-primary');
        } else {
            button.classList.remove('text-primary');
        }
    } catch (error) {
        console.error('Comment box feature not found!', error);
    }
}


function confirmDeleteComment(commentId) {
    Swal.fire({
        icon: 'question',
        title: 'Are You Sure?',
        text: 'Do you want to delete this comment?',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        customClass: {
            popup: 'sw-popup',
            title: 'sw-title',
            htmlContainer: 'sw-text',
            icon: 'border-primary text-primary',
            closeButton: 'bg-secondary border-0 shadow-none',
            confirmButton: 'bg-danger border-0 shadow-none',
        },
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Comment deleted successfully!",
                icon: "success",
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    confirmButton: 'sw-confirm',
                }
            });

            Livewire.dispatch('deleteComment', { id: commentId });
        }
    });
}

function confirmDeleteReplay(commentId) {
    Swal.fire({
        icon: 'question',
        title: 'Are You Sure?',
        text: 'Do you want to delete this reply?',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        customClass: {
            popup: 'sw-popup',
            title: 'sw-title',
            htmlContainer: 'sw-text',
            icon: 'border-primary text-primary',
            closeButton: 'bg-secondary border-0 shadow-none',
            confirmButton: 'bg-danger border-0 shadow-none',
        },
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Reply deleted successfully!",
                icon: "success",
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    confirmButton: 'sw-confirm',
                }
            });

            Livewire.dispatch('deleteComment', { id: commentId });
        }
    });
}

function reply(commentId) {
    const replayComment = document.getElementById(`reply-comment-${commentId}`);
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

function reportComment(id, avatar, avatar_google, name, slug, created_at, body) {
    var avatarUrl = avatar ? avatarBaseUrl + avatar : 
            (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));

    $('#comment_id').val(id);
    $('#user-profile').attr('src', avatarUrl);
    $('#username').text(name);
    $('#slug').text('@' + slug);
    $('#created_at').text(created_at);
    $('#comment-body').text(body);
    $('#reportComment').modal('show');
}

function reportReplay(id, avatar, avatar_google, name, slug, created_at, body) {
    var avatarUrl = avatar ? avatarBaseUrl + avatar : 
            (avatar_google ? avatar_google : "https://ui-avatars.com/api/?background=random&name=" + encodeURIComponent(name));

    $('#comment_id').val(id);
    $('#user-profile').attr('src', avatarUrl);
    $('#username').text(name);
    $('#slug').text('@' + slug);
    $('#created_at').text(created_at);
    $('#comment-body').text(body);
    $('#report-comment-form').attr('action', '#' + id);
    $('#reportComment').modal('show');
}