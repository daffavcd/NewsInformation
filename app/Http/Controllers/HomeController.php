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
        $value = DB::table('articles')->paginate(5);
        $user = Auth::user();
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();
        $data = array(
            'article' => $value,
            'kategori' => $kategori,
            'user'=> $user
        );
        return view('home',$data);
    }
    
}
