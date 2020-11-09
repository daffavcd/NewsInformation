<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::table('articles')
            ->select('*', 'articles.id as id_article', 'categories.name as category_name', 'admins.name as admin_name')
            ->leftJoin('admins', 'admins.id', '=', 'articles.id_admin')
            ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')
            ->orderByDesc('id_article')
            ->get();
        return view('admin\article\index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ctg = \App\Category::all();
        return view('admin\article\create', ['categories' => $ctg]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('featured_image');
        $waktu = date('ymdhis');
        $data = new \App\Article;

        $data->title = $request->title;
        $data->content = $request->content;
        $data->category_id = $request->category_id;
        // $data->id_admin = $user->id;
        $data->featured_image = $waktu . '_' . $file->getClientOriginalName();

        $data->save();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'images/article';
        $file->move($tujuan_upload, $waktu . '_' . $file->getClientOriginalName());
        return redirect('/admin/article')->with(['success' => 'Insert Article Success !']);;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
