<?php

namespace App\Livewire;

use App\Models\CommentReport;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCommentReport extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $numberOfPaginatorsRendered = [];

    public $search = '';
    public $filter = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterCommentRepors()
    {
        $this->filter = $this->filter === 'desc' ? 'asc' : 'desc';
    }


    public function render()
    {
        $user = User::all();

        $commentReports = CommentReport::with(['user', 'comment.user'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('comment.user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('comment', function ($query) {
                $query->where('body', 'like', '%' . $this->search . '%');
            })
            ->orWhere('report', 'like', '%' . $this->search . '%')
            ->orderBy('updated_at', $this->filter)
            ->paginate(6);

        return view('livewire.admin-comment-report', [
            'user' => $user,
            'commentReports' => $commentReports
        ]);
    }
}
