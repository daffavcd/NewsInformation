<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $kategori = DB::table('articles')
            ->groupBy('category')
            ->get();
            $data = array(
                'nama' => 'Muhammad Daffa A.R',
                'nim' => '1931710093',
                'kategori' => $kategori
            );
        return view('about',$data);
    }
}
