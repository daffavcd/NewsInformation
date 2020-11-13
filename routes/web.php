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
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
// ------------------------

// ADMIN ROUTE
Route::resources([
    'admin/article' => 'Admin\ArticleController'
]);
Route::get('/admin/article/{id}/pdf', 'Admin\ArticleController@pdf');
Route::post('/admin/article/delete', 'Admin\ArticleController@destroy');
Route::post('/admin/loginAdmin', 'Admin\LoginController@adminLogin');
Route::get('/admin/logoutAdmin', 'Admin\LoginController@logout');
Route::get('/login/admin', 'Admin\LoginController@showAdminLoginForm');
Route::get('/admin','Admin\HomeController');
// ------------------------