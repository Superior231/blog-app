<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReport;
use Illuminate\Http\Request;

class CommentReportController extends Controller
{
    public function reportComment(Request $request)
    {
        $data = $request->all();

        CommentReport::create($data);

        return redirect()->back()->with('success', 'Laporan berhasil dibuat!');
    }

    public function deleteComment($id)
    {
        $data = Comment::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
    }

    public function deleteCommentReport($id)
    {
        $data = CommentReport::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus!');
    }
}
