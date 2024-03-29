<?php
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/{id}', 'AdminPostsController@getPost')->name('post.blog');

Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin', 'AdminController@index')->name('admin.index');

    Route::resource('/admin/users', 'AdminUsersController');

    Route::resource('/admin/posts', 'AdminPostsController');

    Route::resource('/admin/categories', 'AdminCategoriesController');

    Route::resource('/admin/media', 'AdminMediasController');

    Route::delete('/delete/media', 'AdminMediasController@deleteMedia');

    Route::resource('/admin/comments', 'PostCommentsController');

    Route::resource('/admin/comments/replies', 'CommentRepliesController');

}); 

Route::group(['middleware' => 'auth'], function () {

    Route::post('/comment/reply', 'CommentRepliesController@createReply');
});
