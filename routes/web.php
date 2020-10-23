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

Route::get('article/{id}', 'ArticleController@index');
Route::post('insertComment', 'ArticleController@insertComment');
Route::post('updateComment', 'ArticleController@updateComment');
Route::post('deleteComment', 'ArticleController@deleteComment');
Route::post('replyComment', 'ArticleController@replyComment');

Route::post('articleLike', 'ArticleController@articleLike');
Route::post('articleUnlike', 'ArticleController@articleUnlike');

Route::get('/about','AboutController');
Route::get('category/{category}','CategoryController');
Route::get('/', 'HomeController');
Route::get('/find','FindController'); 
Route::get('/profile','ProfileController'); 

// AUTH ROUTE
Route::get('/logout','Auth\LoginController@logout'); 
// ------------------------