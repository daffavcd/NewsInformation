<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
class HomeController extends Controller
{
    
    public function __invoke(Request $request)
    {
        $temp = Article::all();
        return view('home', ['article'=> $temp]);
    }
    
}
