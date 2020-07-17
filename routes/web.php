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
Route::post('/uploader/img/upload', 'FileController@uploadImg');
Route::post('uploader/review/upload', 'ReviewController@createReview')->name('reviewUpload');
Route::get('/Reviews', 'MainPageController@getPage')->name('getPage');
Route::get('/Reviews/{id}', 'MainPageController@showReview')->name('review')->where('id', '^[0-9]+$');
Route::get('/comments/{id}', 'CommentController@getComments');
Route::post('/auth', 'AuthController@auth');
Route::post('/reg', 'AuthController@register');
Route::get('/user/reviews/{id}', 'ReviewController@getReviewByUser')->where('id', '^[0-9]+$');
Route::get('/user/profile/reviews/{id}', 'ReviewController@usersReviews')->where('id', '^[0-9]+$');
Route::get('/user/{id}/follower', 'UserMenuController@followers');
Route::get('/user/{id}/subscriptions', 'UserMenuController@subscriptions');
Route::get('/user/{id}','UserMenuController@userById')->where('id', '^[0-9]+$');

Route::middleware('auth')->group(function () {
    Route::get('subscribe/user/{id}', 'SubscribeController@subscribe')->where('id', '^[0-9]+$');
    Route::get('unsubscribe/user/{id}', 'SubscribeController@unsubscribe')->where('id', '^[0-9]+$');
    Route::get('/user/changePassForm', 'UserMenuController@changePass');
    Route::put('/user/changePass', 'UserController@changePass');
    Route::get('/user', 'UserMenuController@index');
    Route::get('/addReview', 'MainPageController@showReviewEditor');
    Route::get('/editReview/{id}', 'MainPageController@showEditor')->where('id', '^[0-9]+$');
    Route::get('/like/{id}', 'ReviewController@like')->name('like')->where('id', '^[0-9]+$');
    Route::post('/comment/{id}', 'CommentController@create')->middleware('can:write comment')
        ->name('comment')->where('id', '^[0-9]+$');
    Route::delete('/delete/comment/{id}', 'CommentController@delete')->name('delComment')->where('id', '^[0-9]+$');
    Route::put('/edit/comment/{id}', 'CommentController@edit')->name('editComment')->where('id', '^[0-9]+$');
    Route::delete('/delete/review/{id}', 'ReviewController@delete')->name('delReview')->where('id', '^[0-9]+$');
    Route::put('/edit/review/{id}', 'ReviewController@edit')->name('editReview')->where('id', '^[0-9]+$');

});

Auth::routes();

Route::name('admin.')->prefix('admin')->middleware('auth', 'role:super-admin|admin')->group(function () {

    Route::get('/', function () {
        return redirect(route('admin.main'));
    });

    Route::get('/main', 'AdminController@index')->name('main');
    Route::get('/users', 'AdminController@showUsers')->name('users');
    Route::get('/reviews', 'AdminController@showReviews')->name('reviews');
    Route::get('/reviews/{user}', 'AdminController@showReviewsByUser')->name('reviewsByUser');
    Route::get('/addUser', 'AdminController@showAddUser')->name('addUser');
    Route::post('/addUser/add', 'AdminController@createUser')->name('add');
    Route::post('/ban/user', 'AdminController@banUser')->name('banUser');
    Route::get('/unban/user/{id}', 'AdminController@unbanUser')->name('unbanUser')->where('id', '^[0-9]+$');
    Route::put('/update/user/{id}', 'AdminController@updateUser')->name('updateUser')->where('id', '^[0-9]+$');
});
