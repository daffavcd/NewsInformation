<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('article/{id}', function ($id) {
    return 'Halaman Article dengan id ' . $id;
});
Route::get('about/', function () {
    $nim = '1931710093';
    $nama = 'Muhammad Daffa A.R';
    return 'Nama    : ' . $nama . '<br> NIM     : '.$nim;
});

Route::get('/home', 'HomeController@index')->name('home');
