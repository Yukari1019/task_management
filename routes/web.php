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
    return redirect('/login');
});
Route::get('/tasks', 'TaskController@index')->name('task.list');
Route::get('/taskshow/{id}', 'TaskController@show')->name('task.show');
Route::get('/tasknew', 'TaskController@create')->name('task.new');
Route::post('/taskstore', 'TaskController@store')->name('task.store');
Route::get('/taskedit/{id}', 'TaskController@edit')->name('task.edit');
Route::post('/taskupdate/{id}', 'TaskController@update')->name('task.update');
Route::get('/taskdelete/{id}', 'TaskController@destroy')->name('task.delete');
Route::post('/taskdoing/{id}','TaskController@doing')->name('task.doing');
Route::post('/taskdone/{id}','TaskController@done')->name('task.done');
Route::get('/taskmypage', 'TaskController@mypage')->name('task.mypage');
Route::get('/postclient', 'PostController@show')->name('post.client');
//Route::get('/postcontent', 'PostController@show')->name('post.content');
// Route::get('/post',function(){
//     return response()->json(['post' => 'yamada']);
// });

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');
Route::get('/logout', 'HomeController@logout');
