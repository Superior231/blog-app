<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Comment extends Component
{
    public function render()
    {
        $user = User::all();
        return view('livewire.comment', [
            'user' => $user
        ]);
    }
}
