<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $temp = Article::find($request->id);
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();

        $user = Auth::user();
        $data = array(
            'article' => $temp,
            'kategori' => $kategori,
            'user' => $user
        );
        return view('article', $data);
    }
}
