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
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth','role:super-admin']], function () {

    Route::get('/',function (){
       return redirect(route('adminMain'));
    });

    Route::get('/main', function (){
        return view('layouts.master');
    })->name('adminMain');

    Route::get('/users', function () {
        return view('layouts.users');
    })->name('adminUsers');

    Route::get('/reviews', function () {
       return view('layouts.reviews');
    })->name('adminReviews');
});
