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

//Auth::routes();

Route::get('/', function () {
//    return view('welcome');
    return redirect(route('posts.index'));
});

Route::get('/home', function () {
//    return view('home');
    return redirect(route('posts.index'));
});

// posts 이미지 업로드

Route::post('/posts/imgUpload', [
    "as" => "posts.img",
    "uses" => 'UploadController@imageUpload'
]);

// 포스트 라우팅
Route::resource('posts', 'PostsController');

// 첨부파일 라우팅
Route::resource('attachments','AttachmentsController',[
    'only'=>['store','destroy','show']
]);

// 댓글 라우팅
Route::resource('comments','CommentsController',[
    'only' => ['update','destroy']
]);

Route::resource('posts.comments','CommentsController',[
    'only' => ['store']
]);

// 모달 라우팅
Route::get('books/{bookname}',[
    'as' => 'books.get',
    'uses' => 'BooksController@get'
]);

// 사용자 가입
Route::get('auth/register',[
    'as'=>'users.create',
    "uses"=>'UsersController@create'
]);

Route::post('auth/register',[
    'as'=>'users.store',
    "uses"=>'UsersController@store'
]);

Route::get('auth/confirm/{code}',[
    'as'=>'users.confirm',
    "uses"=>'UsersController@confirm'
])->where('code','[\pL-\pN]{60}');

Route::get('auth/{user}/edit',[
    'as'=>'users.edit',
    'uses'=>'UsersController@edit'
]);

// 사용자 인증

Route::get('auth/login',[
    'as'=>'sessions.create',
    "uses"=>'SessionsController@create'
]);

Route::post('auth/login',[
    'as'=>'sessions.store',
    "uses"=>'SessionsController@store'
]);

Route::get('auth/logout',[
    'as'=>'sessions.destroy',
    "uses"=>'SessionsController@destroy'
]);

// 비밀번호 변경

Route::get('auth/remind',[
    'as'=>'remind.create',
    "uses"=>'PasswordsController@getRemind'
]);

Route::post('auth/remind',[
    'as'=>'remind.store',
    "uses"=>'PasswordsController@postRemind'
]);

Route::get('auth/reset/{token}',[
    'as'=>'reset.create',
    "uses"=>'PasswordsController@getReset'
])->where('code','[\pL-\pN]{60}');

Route::post('auth/reset/{token}',[
    'as'=>'reset.store',
    "uses"=>'PasswordsController@postReset'
]);

// 소셜 로그인
Route::get('social/{provider}',[
    'as' => 'social.login',
    'uses' => 'SocialController@execute',
]);
