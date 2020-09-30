<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->where('category', $request->category)
            ->get();
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();
        return view('category', ['data' => $temp],['kategori'=> $kategori]);
    }
}
