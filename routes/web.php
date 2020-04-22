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

Route::group(['prefix' => 'admin', 'middleware' => ['auth','role:super-admin|admin']], function () {

    Route::get('/',function (){
       return redirect(route('admin.main'));
    });

    Route::get('/main', 'AdminController@store')->name('admin.main');
    Route::get('/users','AdminController@storeUsers')->name('admin.users');
    Route::get('/reviews', 'AdminController@storeReviews')->name('admin.reviews');
    Route::get('/addUser','AdminController@storeAddUser')->name('admin.addUser');
    Route::post('/addUser/add', 'AdminController@createUser')->name('admin.add');
});
