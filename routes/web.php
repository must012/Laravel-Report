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

Route::get('/', function () {
//    return view('welcome');
    return redirect(route('posts.index'));
});

Route::get('/home', function () {
//    return view('home');
    return redirect(route('posts.index'));
});

Route::post('/posts/imgUpload', [
    "as" => "posts.img",
    "uses" => 'UploadController@imageUpload'
]);

Route::resource('posts', 'PostsController');

Auth::routes();
