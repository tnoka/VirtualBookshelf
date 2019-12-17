<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// 会員退会
Route::delete('/users/{id}', 'UsersController@destroy')->name('user.destroy');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザー
Route::get('/user', function(){
    return Auth::user();
})->name('user');

// 本の投稿
Route::post('/products', 'ProductController@store')->name('product.store');

// 本の一覧
Route::get('/products', 'ProductController@index')->name('product.index');
// 人気順
Route::get('/products/indexRank', 'ProductController@indexRank')->name('product.indexRank');
// フィード
Route::get('/products/indexFeed', 'ProductController@indexFeed')->name('product.indexFeed');


// 本の詳細
Route::get('/products/{id}', 'ProductController@show')->name('product.show');

// コメント
Route::post('/products/{product}/comments', 'ProductController@addComment')->name('product.comment');

// いいね（読みたい本）
Route::put('/products/{id}/favorite', 'ProductController@favorite')->name('product.favorite');

// いいね（読みたい本）解除
Route::delete('/products/{id}/favorite', 'ProductController@unFavorite');

// トークンリフレッシュ
Route::get('/refresh-token', function (Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();
    return response()->json();
});