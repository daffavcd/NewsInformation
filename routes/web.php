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

Route::get('article/{id}', 'ArticleController');

Route::get('/about','AboutController');
Route::get('category/{category}','CategoryController');
Route::get('/', 'HomeController');
Route::get('/find','FindController'); 

// LOGOUT ROUTE
Route::get('/logout','Auth\LoginController@logout'); 
// ------------------------