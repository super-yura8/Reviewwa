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

Route::get('/', 'MainPageController@index')->name('mainPage');
Route::get('/addReview', 'MainPageController@showReviewEditor');
Route::post('/uploader/img/upload', 'FileController@uploadImg');
Route::post('uploader/review/upload', 'ReviewController@createReview')->name('reviewUpload');
Route::get('/Reviews','MainPageController@getPage')->name('getPage');
