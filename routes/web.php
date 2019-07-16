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

Route::pattern('id', '[0-9]+');

//LOGIN
Route::get('/', 'LoginController@index');
Route::post('/log', 'LoginController@log');
Route::get('/log','LoginController@logout');


Route::group(['middleware' => ['user']], function () {

    Route::get('/articles','HomeContoller@index');
    Route::get('/articles/{id}','HomeContoller@show')->name('single_article');
    Route::get('/articles/create' ,'HomeContoller@create')->name('insert_article');
    Route::post('/articles','HomeContoller@store');
    Route::get('/articles/delete/{id}' ,'HomeContoller@destroy')->name('delete_art');
    Route::get('/user/{id}','LoginController@user')->name('user_articles');

});





