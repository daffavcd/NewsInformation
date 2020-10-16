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
            ->where('id_article', $request->id)
            ->orderBy('comments.id', 'desc')
            ->get();
        $user = Auth::user();
        $data = array(
            'article' => $temp,
            'comment' => $comment,
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
}
