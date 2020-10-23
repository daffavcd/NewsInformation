<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = Auth::user();
        $kategori = DB::table('articles')
        ->groupBy('category')
            ->get();

        $jumlah_likes = DB::table('likes')
            ->select(DB::raw('count(*) as jumlah_likes'))
            ->where('id_article', $request->id)
            ->first();
        @$cek_likes = DB::table('likes')
            ->select('*')
            ->where('id_article', $request->id)
            ->where('id_user', $user->id)
            ->first();
        $total = 1;
        $jumlah_comment = DB::table('comments')
            ->select(DB::raw('count(*) as jumlah'))
            ->where('id_article', $request->id)
            ->first();

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

        $data = array(
            'article' => $temp,
            'comment' => $comment,
            'anak_comment' => $anak_comment,
            'kategori' => $kategori,
            'jumlah_comment' => $jumlah_comment,
            'user' => $user,
            'jumlah_likes' => $jumlah_likes,
            'cek_likes' => $cek_likes
        );
        return view('article', $data);
    }
    public function articleLike(Request $request)
    {
        $bawa = new Like;
        $user = Auth::user();
        $bawa->id_article = $request->id_article;
        $bawa->id_user = $user->id;

        $bawa->save();
        return json_encode(array(
            "statusCode" => 200,
        ));
    }
    public function articleUnlike(Request $request)
    {
        $user = Auth::user();
        DB::table('likes')
            ->where('id_article', $request->id_article)
            ->where('id_user', $user->id)
            ->delete();
        return json_encode(array(
            "statusCode" => 200,
        ));
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
