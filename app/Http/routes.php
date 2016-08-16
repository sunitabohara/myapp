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


    return view('welcome');
});

Route::group(['namespace' => 'Front'], function () {

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

