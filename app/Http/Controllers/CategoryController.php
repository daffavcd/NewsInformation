<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $temp = DB::table('articles')
        ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')
        ->select('*', 'categories.id AS category_id','articles.id AS articles_id')
        ->where('category_id', $request->category)
        ->orderBy('articles.id', 'desc')
        ->get();
        
        $nama = \App\Category::where('id', $request->category)->first();

        $kategori = \App\Category::all();
        $user = Auth::user();
        $data = array(
            'data' => $temp,
            'nama' => $nama,
            'kategori' => $kategori,
            'user' => $user
        );
        return view('category', $data);
    }
}
