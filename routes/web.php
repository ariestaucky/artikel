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

Route::get('/', 'PagesController@home')->name('home');

Route::get('/blog', 'PagesController@blog')->name('blog');

Route::get('/profile/{id}', 'DashboardController@profile')->name('profile');

// Route::get('/writer', 'UsersController@show');

Route::get('/contact', 'MessagesController@index')->name('contact');

Route::get('/contact/{name}', 'MessagesController@create')->name('create');

Route::get('/message/{id}', 'MessagesController@show')->name('message');

Route::put('/contact/{id}', 'MessagesController@update')->name('read');

Route::delete('/contact/{id}', 'MessagesController@destroy')->name('delete');

Route::get('/back', 'PagesController@back')->name('back');

Route::get('/view', 'PagesController@view')->name('view');

Route::get('/author/post/{id}', 'PagesController@open')->name('open');

Route::get('/catagory', 'PagesController@catagory')->name('catagory');

Route::get('/search', 'PagesController@search')->name('search');

Route::get('/about', 'PagesController@about')->name('about');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('posts', 'PostsController');

Route::resource('user', 'UsersController');

Route::post('/contact/submit', 'MessagesController@store')->name('submit');

Route::post('ajaxRequest', 'UsersController@ajaxRequest')->name('ajaxRequest');

Route::post('ajaxRequestLike', 'PostsController@ajaxRequestLike')->name('ajaxRequestLike');

Route::post('ajaxRequestIns', 'PostsController@ajaxRequestIns')->name('ajaxRequestIns');

Route::post('ajaxRequestInsert', 'UsersController@ajaxRequestInsert')->name('ajaxRequestInsert');

Route::group([ 'middleware' => 'auth' ], function () {
    Route::get('/counter', 'Controller@notification');
    Route::get('/msg-counter', 'Controller@msg_counter');
});

Route::post('/comment/store', 'CommentController@store')->name('comment.add');

Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

Route::get('/follower', 'UsersController@follower');

Route::get('/following', 'UsersController@following');

Route::get('/history', 'UsersController@history');

Route::get('/ToS', 'PagesController@ToS')->name('ToS');

Route::get('/policies', 'PagesController@policies')->name('policies');

Route::get('/contact-us', 'PagesController@contact_us')->name('contact_us');

Route::post('/contact-us/submit', 'PagesController@send_us')->name('send_us');

Route::get('/social', 'PagesController@social')->name('social');

Route::post('/complete/{id}', 'UsersController@complete')->name('complete');

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('post/mark/{id},{pid?}', 'UsersController@mark')->name('like');

Route::get('profile/mark/{id}', 'UsersController@mark')->name('follow');

Route::get('comment/mark/{id},{pid?}', 'UsersController@mark')->name('comment');

Route::get('reply/mark/{id},{pid?},{cid?}', 'UsersController@mark')->name('reply');

Route::get('newpost/mark/{id},{pid?}', 'UsersController@mark')->name('new_post');

Route::get('author/follower/{id}', 'PagesController@follower')->name('follower');

