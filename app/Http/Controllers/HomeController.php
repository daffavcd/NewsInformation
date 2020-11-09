<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        // $value = Cache::rememberForever('users', function () {
        // });
        // $value = DB::table('articles')->paginate(5);
        $value = DB::table('articles')
            ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')
            ->select('*', 'categories.id AS category_id','articles.id AS articles_id')
            ->orderBy('articles.id', 'desc')
            ->paginate(5);

        $user = Auth::user();
        $kategori = \App\Category::all();
        $data = array(
            'article' => $value,
            'kategori' => $kategori,
            'user' => $user
        );
        return view('home', $data);
    }
}
