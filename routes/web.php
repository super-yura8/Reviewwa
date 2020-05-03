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

Route::name('admin.')->prefix('admin')->middleware('auth','role:super-admin|admin')->group(function () {

    Route::get('/',function (){
       return redirect(route('admin.main'));
    });

    Route::get('/main', 'AdminController@index')->name('main');
    Route::get('/users','AdminController@showUsers')->name('users');
    Route::get('/reviews', 'AdminController@showReviews')->name('reviews');
    Route::get('/addUser','AdminController@showAddUser')->name('addUser');
    Route::post('/addUser/add', 'AdminController@createUser')->name('add');
    Route::get('/ban/user/{id}', 'AdminController@banUser')->name('banUser');
});
