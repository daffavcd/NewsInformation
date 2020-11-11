<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use PDF;

class ArticleController extends ControllerAdmin
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
        $tujuan_upload = 'images/';
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
        $ctg = \App\Category::all();
        $data = DB::table('articles')
            ->select('*', 'articles.id as id_article', 'categories.name as category_name', 'admins.name as admin_name', 'categories.id as category_id')
            ->leftJoin('admins', 'admins.id', '=', 'articles.id_admin')
            ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')
            ->where('articles.id', $id)
            ->first();
        return view('admin/article/edit',  ['data' => $data, 'ctg' => $ctg]);
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
        $bawa = Article::find($id);

        $file = $request->file('featured_image');
        if (!empty($file)) {
            unlink(public_path('images/' . $bawa->featured_image));
            $waktu = date('ymdhis');
            $bawa->featured_image = $waktu . '_' . $file->getClientOriginalName();
            $tujuan_upload = 'images/';
            $file->move($tujuan_upload, $waktu . '_' . $file->getClientOriginalName());
        }
        $bawa->title = $request->title;
        $bawa->content = $request->content;
        $bawa->category_id = $request->category_id;
        $bawa->save();
        return redirect('/admin/article')->with(['success' => 'Article Update Success !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $flight = Article::find($request->id);

        unlink(public_path('images/' . $flight->featured_image));
        $flight->delete();
        return back()->with(['success' => 'Article Deleted !']);
    }
    function pdf(Request $request)
    {
        $article = DB::table('articles')
        ->select('*', 'articles.id as id_article', 'categories.name as category_name', 'admins.name as admin_name')
        ->leftJoin('admins', 'admins.id', '=', 'articles.id_admin')
        ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')
        ->where('articles.id', $request->id)
        ->first();
        // return view('admin/article/dynamic_pdf', ['article' => $article]);
        
        $pdf = PDF::loadview('admin/article/dynamic_pdf', ['article' => $article]);
        return $pdf->download($article->title.'_'.date('ymd').'.pdf');
    }

}
