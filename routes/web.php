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
//     return view('home1');
// });

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home/{id}', 'HomeController@show');

Route::get('admin', 'AdminController@index');


// Route::get('/posts', 'PostsController@index');
// Route::get('/posts/create', 'PostsController@create');
// Route::get('/posts/{post}', 'PostsController@show');
// Route::post('/posts', 'PostsController@store');
// Route::get('/posts/{post}/edit', 'PostsController@edit');
// Route::patch('/posts', 'PostsController@update');
// Route::delete('/posts/{post}', 'PostsController@destroy');


Route::get('users/indexStud', 'UsersController@indexStud')->name('admin.users.indexStud');
Route::get('users/indexLect', 'UsersController@indexLect')->name('admin.users.indexLect');
Route::get('users/indexLectStud', 'UsersController@indexLectStud')->name('admin.users.indexLectStud');
Route::get('users/dropdown/{user}', 'UsersController@dropdown')->name('admin.users.dropdown');
Route::put('users/updatedropdown/{user}', 'UsersController@updatedropdown')->name('admin.users.updatedropdown');
Route::get('posts/indexSv', 'PostsController@indexSv')->name('admin.posts.indexSv');
Route::get('posts/supervisee', 'PostsController@supervisee')->name('admin.posts.supervisee');
// Route::get('posts/{id}/edit', 'PostsController@edit');
Route::get('posts/indexAd', 'PostsController@indexAd')->name('admin.posts.indexAd');
Route::get('posts/dashboardA', 'PostsController@dashboardA')->name('admin.posts.dashboardA');
Route::get('posts/dashboardB', 'PostsController@dashboardB')->name('admin.posts.dashboardB');
Route::get('users/dashboardS', 'UsersController@dashboardS')->name('admin.users.dashboardS');
Route::get('posts/dashboardSV', 'PostsController@dashboardSV')->name('admin.posts.dashboardSV');
Route::get('/file/download/{file}','PostsController@download');


Route::resource('posts', 'PostsController');
Route::resource('users', 'UsersController');
Route::resource('roles', 'RolesController')->middleware('can:isAdmin');

Route::get('/document/create','DocumentController@create');
Route::post('/files','DocumentController@store');
Route::get('/files','DocumentController@index');
Route::get('/files/{id}','DocumentController@show');
Route::get('/file/download/{file}','DocumentController@download');