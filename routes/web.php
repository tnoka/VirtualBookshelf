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

// ユーザー関連
Route::resource('users', 'usersController');

// フォローする
Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
// フォロー解除
Route::delete('users/{user}/unFollow', 'UsersController@unFollow')->name('unFollow');

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');

Auth::routes();
