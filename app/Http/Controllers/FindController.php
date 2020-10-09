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
            ->where('title', 'like', '%' . $request->cari . '%')
            ->get();
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();

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
