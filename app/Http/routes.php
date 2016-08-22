<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {

    return Redirect::route('front.dashboard');
//    return view('welcome');
});

Route::get('files/get/{source}/{filename}', ['as' => 'files', 'uses' => 'FileEntryController@get']);
Route::get('files/images/{source}/{id}/{filename}', ['as' => 'images', 'uses' => 'FileEntryController@image']);

Route::group(['namespace' => 'Front','middleware' => ['auth']], function () {

	// Route::resource('dashboard','DashboardController');
	Route::get('dashboard', 'DashboardController@index')->name('front.dashboard');
	Route::get('about', 'DashboardController@about')->name('front.about');
	Route::get('service', 'DashboardController@services')->name('front.services');
	Route::get('contact', 'DashboardController@contact')->name('front.contact');
	Route::get('portfolio', 'DashboardController@portfolio')->name('front.portfolio');
	Route::get('blog', 'DashboardController@blog')->name('front.blog');
	Route::get('pricing', 'DashboardController@pricing')->name('front.pricing');
	Route::get('sidebar', 'DashboardController@sidebar')->name('front.sidebar');
});

//for page refresh
header('Expires: Sun, 22 Aug 2016 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['namespace' => 'Admin','prefix'=>'admin', 'middleware' => ['auth']], function () {

    Route::resource('users','UserController');
    Route::get('users/{id}/upload', 'UserController@upload')->name('admin.users.upload');
    Route::post('users', 'UserController@storeImage')->name('admin.users.storeImage');

});
