<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Comment as ModelsComment;
use App\Models\LikeComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comment extends Component
{
    public $body, $replyBodies = [];
    public $article, $comment_id;
    public $filter = 'latest';
    public $filterText = 'Terbaru';

    public $likeCommentCount = 0;
    public $dislikeCommentCount = 0;
    public $commentLiked = false;
    public $commentDisliked = false;
    
    protected $listeners = [
        'deleteComment' => 'destroy',
        'setFilter' => 'setFilter',
        'reportComment' => 'reportComment'
    ];

    public function mount($id)
    {
        $this->article = Article::findOrFail($id);
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->filterText = match($filter) {
            'popular' => 'Komentar terpopuler',
            'latest' => 'Terbaru',
            default => 'Semua komentar',
        };
    }

    public function store()
    {
        $this->validate([
            'body' => 'required|string',
        ]);

        $comment = ModelsComment::create([
            'user_id' => Auth::id(),
            'article_id' => $this->article->id,
            'body' => $this->body
        ]);

        $this->body = '';

        if ($comment) {
            return redirect()->with('success', 'Komentar berhasil dibuat!');
        } else {
            return redirect()->with('error', 'Komentar gagal dibuat!');
        }
    }

    public function reply($id)
    {
        $this->comment_id = $id;
        $this->replyBodies[$id] = $this->replyBodies[$id] ?? '';
    }

    public function replyStore($id)
    {
        $this->validate([
            'replyBodies.' . $id => 'required|string',
        ]);

        $replyBody = $this->replyBodies[$id] ?? '';

        if ($replyBody) {
            $comment = ModelsComment::create([
                'user_id' => Auth::user()->id,
                'article_id' => $this->article->id,
                'body' => $replyBody,
                'comment_id' => $id
            ]);
    
            if ($comment) {
                $this->replyBodies[$id] = ''; // Reset balasan setelah berhasil
                return redirect()->back()->with('success', 'Balasan komentar berhasil dibuat!');
            } else {
                return redirect()->back()->with('error', 'Balasan komentar gagal dibuat!');
            }
        } else {
            return redirect()->back()->with('error', 'Balasan komentar tidak boleh kosong!');
        }
    }

    public function destroy($id)
    {
        $comment = ModelsComment::findOrFail($id);

        if (Auth::user()->roles === "admin" || $comment->user_id === Auth::id()) {
            $comment->delete();
        }
    }


    // Likes and Dislikes
    private function updateCounts($id)
    {
        $this->likeCommentCount = LikeComment::where('comment_id', $id)->where('like', true)->count();
        $this->dislikeCommentCount = LikeComment::where('comment_id', $id)->where('dislike', true)->count();
        $this->commentLiked = Auth::check() && LikeComment::where('comment_id', $id)->where('user_id', Auth::id())->where('like', true)->exists();
        $this->commentDisliked = Auth::check() && LikeComment::where('comment_id', $id)->where('user_id', Auth::id())->where('dislike', true)->exists();
    }

    public function like($id)
    {
        $user_id = Auth::user()->id;
        $like = LikeComment::where('comment_id', $id)
                ->where('user_id', $user_id)
                ->first();
    
        if ($like && $like->like) {
            $like->delete();
        } else {
            LikeComment::updateOrCreate(
                ['comment_id' => $id, 'user_id' => $user_id],
                ['like' => true, 'dislike' => false]
            );
        }
        $this->updateCounts($id);
    }

    public function dislike($id)
    {
        $user_id = Auth::user()->id;
        $like = LikeComment::where('comment_id', $id)
                ->where('user_id', $user_id)
                ->first();
    
        if ($like && $like->dislike) {
            $like->delete();
        } else {
            LikeComment::updateOrCreate(
                ['comment_id' => $id, 'user_id' => $user_id],
                ['like' => false, 'dislike' => true]
            );
        }
        $this->updateCounts($id);
    }


    public function render()
    {
        $commentsQuery = ModelsComment::with(['user', 'childrens'])
            ->where('article_id', $this->article->id)
            ->whereNull('comment_id');

        if ($this->filter === 'popular') {
            $commentsQuery->withCount('childrens')->orderBy('childrens_count', 'DESC');
        } elseif ($this->filter === 'latest') {
            $commentsQuery->orderBy('created_at', 'DESC');
        } elseif ($this->filter === 'all') {
            $commentsQuery->orderBy('created_at', 'ASC');
        }

        $comments = $commentsQuery->get();
        $total_comments = ModelsComment::where('article_id', $this->article->id)->count();
        
        return view('livewire.comment', [
            'comments' => $comments,
            'total_comments' => $total_comments,
        ]);
    }
}
