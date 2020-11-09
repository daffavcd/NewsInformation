<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FindController extends Controller
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
            ->select('*', 'categories.id AS category_id', 'articles.id AS articles_id')
            ->where('title', 'like', '%' . $request->cari . '%')
            ->orderBy('articles.id', 'desc')
            ->get();
        $kategori = \App\Category::all();

        $user = Auth::user();
        $data = array(
            'data' => $temp,
            'cari' => $request->get('cari'),
            'kategori' => $kategori,
            'user' => $user
        );
        return view('find', $data);
    }
}
