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
// Route::get('/', function () {
//     return view('index');
// });

// ログイン状態のみ
Route::group(['middleware' => 'auth'], function(){
    
    // resourceでCRUDルーティングをまとめて設定
    // ユーザー関連
    Route::resource('users', 'usersController');

    // 本関連
    Route::resource('products', 'ProductController');
    Route::get('/products/{id}', 'ProductController@show')->name('product.show');
    Route::put('products/{products}', 'ProductController@update')->name('products.update');

    // コメント関連
    Route::resource('comments', 'CommentsController');

    // フォローする
    Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
    // フォロー解除
    Route::delete('users/{user}/unFollow', 'UsersController@unFollow')->name('unFollow');



});


Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');

// 認証系に必要なルーティング定義を一通り追加
Auth::routes();
