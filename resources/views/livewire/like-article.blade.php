<div class="article-interaction d-flex align-items-center justify-content-end">
    @auth()
        <a wire:click.prevent="like" class="likes d-flex align-items-center gap-1" role="button">
            @if ($liked)
                <i class='bx bxs-heart bx-tada text-danger fs-5'></i>
                <p class="my-0 py-0 fs-7 fw-semibold text-danger">{{ $likeCount }}</p>
            @else
                <i class='bx bx-heart text-danger'></i>
                <p class="my-0 py-0 fs-7">{{ $likeCount }}</p>
            @endif
        </a>
        <a href="#comment" class="comments d-flex align-items-center gap-1">
            <i class='bx bxs-comment-detail text-primary'></i>
            <p class="my-0 py-0 fs-7">{{ $total_comments }}</p>
        </a>
    @else
        <a onclick="login()" class="likes d-flex align-items-center gap-1" role="button">
            <i class='bx bx-heart text-danger'></i>
            <p class="my-0 py-0 fs-7">{{ $likeCount }}</p>
        </a>
        <a href="#comment" class="comments d-flex align-items-center gap-1" role="button">
            <i class='bx bxs-comment-detail text-primary'></i>
            <p class="my-0 py-0 fs-7">{{ $total_comments }}</p>
        </a>
    @endauth
</div>
