<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Comment as ModelsComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comment extends Component
{
    public $body, $replyBodies = [];
    public $article, $comment_id;
    public $filter = 'latest';
    public $filterText = 'Terbaru';
    
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
            return redirect()->back()->with('success', 'Komentar berhasil dibuat!');
        } else {
            return redirect()->back()->with('error', 'Komentar gagal dibuat!');
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

        return view('livewire.comment', compact('comments', 'total_comments'));
    }
}
