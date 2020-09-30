<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __invoke(Request $request)
    {
        $value = Cache::rememberForever('users', function () {
            return Article::all();
        });
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();
        return view('home', ['article' => $value],['kategori' => $kategori]);
    }
}
