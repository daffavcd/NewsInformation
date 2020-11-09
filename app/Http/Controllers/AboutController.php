<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class AboutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $kategori = \App\Category::all();
        $user = Auth::user();
        $data = array(
            'nama' => 'Muhammad Daffa A.R',
            'nim' => '1931710093',
            'kategori' => $kategori,
            'user' => $user
        );
        return view('about', $data);
    }
}
