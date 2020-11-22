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
        $kategori = \App\Category::all();

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
    public function sortLast(Request $request)
    {
        $user = Auth::user();
        $temp = Article::find($request->id);
        $comment = DB::table('comments')
            ->leftJoin('users', 'users.id', '=', 'comments.id_user')
            ->select('*', 'comments.id AS id_comment', 'users.id AS id_user')
            ->where('id_article', $request->id)
            ->where('id_comment_parent', 0)
            ->orderBy('comments.id', 'asc')
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
            'user' => $user,
        );
        return view('load_sort', $data);
    }
    public function sortTop(Request $request)
    {
        $user = Auth::user();
        $temp = Article::find($request->id);
        $comment = DB::table('comments')
        ->select('*','comments.id AS id_comment','users.id AS id_user')
            ->leftJoin('users', 'users.id', '=', 'comments.id_user')
            ->leftJoin('hitung_count', 'hitung_count.comment_id', '=', 'comments.id')
            ->where('id_article', $request->id)
            ->where('id_comment_parent', 0)
            ->orderBy('total_likes', 'desc')
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
            'user' => $user,
        );
        return view('load_sort', $data);
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
    public function commentLike(Request $request)
    {
        $user = Auth::user();

        $get_comment_likes = DB::table('comment_likes')
            ->where('comment_id', $request->comment_id)
            ->where('id_user', $user->id)
            ->first();
        if (empty($get_comment_likes)) {
            $bawa = new \App\Comment_like;
            $bawa->comment_id = $request->comment_id;
            $bawa->id_user = $user->id;
            $bawa->likes = 1;

            $bawa->save();

            return json_encode(array(
                "statusCode" => 'insert',
            ));
        } else if ($get_comment_likes->likes == 1) {
            DB::table('comment_likes')
                ->where('comment_id', $request->comment_id)
                ->where('id_user', $user->id)
                ->delete();

            return json_encode(array(
                "statusCode" => 'delete',
            ));
        } else {
            \App\Comment_like::where('comment_id', $request->comment_id)->where('id_user', $user->id)->update(['likes' => 1]);

            return json_encode(array(
                "statusCode" => 'update',
            ));
        }
    }
    public function commentDislike(Request $request)
    {
        $user = Auth::user();
        $get_comment_likes = DB::table('comment_likes')
            ->where('comment_id', $request->comment_id)
            ->where('id_user', $user->id)
            ->first();
        if (empty($get_comment_likes)) {
            $bawa = new \App\Comment_like;
            $bawa->comment_id = $request->comment_id;
            $bawa->id_user = $user->id;
            $bawa->likes = 0;

            $bawa->save();
            return json_encode(array(
                "statusCode" => 'insert',
            ));
        } else if ($get_comment_likes->likes == 0) {
            DB::table('comment_likes')
                ->where('comment_id', $request->comment_id)
                ->where('id_user', $user->id)
                ->delete();
            return json_encode(array(
                "statusCode" => 'delete',
            ));
        } else {
            $get = \App\Comment_like::where('comment_id', $request->comment_id)->where('id_user', $user->id)->update(['likes' => 0]);
            return json_encode(array(
                "statusCode" => 'update',
            ));
        }
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
