<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;

        return 'Selamat datang di article ' . $id;
    }
    public function about()
    {
        $nama = 'Muhammad Daffa A.R';
        $nim    = '1931710093';
        return 'Nama    : ' . $nama . '<br> NIM     : ' . $nim;
    }
}
