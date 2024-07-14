<div class="article-interaction d-flex align-items-center justify-content-end gap-2">
    @auth()
        <a wire:click.prevent="like({{ $article_id }})" class="likes d-flex align-items-center gap-1 @if($liked) active @endif">
            <i class='bx bxs-like'></i>
            <p class="my-0 py-0 fs-7">{{ $likeCount }}</p>
        </a>
        <a wire:click.prevent="dislike({{ $article_id }})" class="dislikes d-flex align-items-center gap-1 @if($disliked) active @endif">
            <i class='bx bxs-dislike'></i>
            <p class="my-0 py-0 fs-7">{{ $dislikeCount }}</p>
        </a>
        <a class="comments d-flex align-items-center gap-1">
            <i class='bx bxs-comment-detail'></i>
            <p class="my-0 py-0 text-dark fs-7">5</p>
        </a>

    @else
        <a onclick="login()" class="likes d-flex align-items-center gap-1">
            <i class='bx bxs-like'></i>
            <p class="my-0 py-0 text-dark fs-7">{{ $likeCount }}</p>
        </a>
        <a onclick="login()" class="dislikes d-flex align-items-center gap-1">
            <i class='bx bxs-dislike'></i>
            <p class="my-0 py-0 text-dark fs-7">{{ $dislikeCount }}</p>
        </a>
        <a onclick="login()" class="comments d-flex align-items-center gap-1">
            <i class='bx bxs-comment-detail'></i>
            <p class="my-0 py-0 text-dark fs-7">5</p>
        </a>
    @endauth
</div>