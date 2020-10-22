<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $temp = Article::find($request->id);
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();

        $comment = DB::table('comments')
            ->leftJoin('users', 'users.id', '=', 'comments.id_user')
            ->select('*', 'comments.id AS id_comment', 'users.id AS id_user')
            ->where('id_article', $request->id)
            ->where('id_comment_parent', 0)
            ->orderBy('comments.id', 'desc')
            ->get();
        $total = 1;

        //cari setiap anak di var + temp
        foreach ($comment as $value) {
            ${"comment_child_" . $total} = DB::table('comments')
                ->leftJoin('users', 'users.id', '=', 'comments.id_user')
                ->select('*', 'comments.id AS id_comment', 'users.id AS id_user')
                ->where('id_comment_parent', $value->id_comment)
                ->orderBy('comments.id', 'asc')
                ->get();
            $total++;
        }
        //masukkan var tdi ke dalam 1 buah array
        $anak_comment = array();
        for ($i = 0; $i < $total - 1; $i++) {
            $anak_comment[$i] = ${"comment_child_" . ($i + 1)};
        }

        $user = Auth::user();
        $data = array(
            'article' => $temp,
            'comment' => $comment,
            'anak_comment' => $anak_comment,
            'kategori' => $kategori,
            'user' => $user
        );
        return view('article', $data);
    }
    public function insertComment(Request $request)
    {
        $bawa = new Comment;
        $user = Auth::user();
        $bawa->id_article = $request->id_article;
        $bawa->id_user = $user->id;
        $bawa->comment = $request->comment;

        $bawa->save();
        return back()->with(['success' => 'Comment insert Success !']);
    }
    public function updateComment(Request $request)
    {
        $bawa = Comment::find($request->id);
        $bawa->comment = $request->comment;

        $bawa->save();
        return back()->with(['success' => 'Comment Update Success !']);
    }
    public function deleteComment(Request $request)
    {
        $flight = Comment::find($request->id);

        $flight->delete();
        return back()->with(['success' => 'Comment Deleted !']);
    }
    public function replyComment(Request $request)
    {
        $bawa = new Comment;
        $user = Auth::user();
        $bawa->id_article = $request->id_article;
        $bawa->id_user = $user->id;
        $bawa->comment = $request->comment;
        $bawa->id_comment_parent = $request->id_comment_parent;

        $bawa->save();
        return back()->with(['success' => 'Reply insert Success !']);
    }
}
