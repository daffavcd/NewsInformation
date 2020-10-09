<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $kategori = DB::table('articles')
        ->groupBy('category')
        ->get();
        $data = array(
            'user'=> $user,
            'kategori' => $kategori
        );
        return view('profile',$data);
    }
}
