<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $nama = 'Muhammad Daffa A.R';
        $nim    = '1931710093';
        return 'Nama    : ' . $nama . '<br> NIM     : ' . $nim;
    }
}
