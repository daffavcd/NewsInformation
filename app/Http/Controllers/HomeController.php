<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function __invoke(Request $request)
    {
        $value = Cache::rememberForever('users', function () {
            return Article::all();
        });
        return view('home', ['article' => $value]);
    }
}
