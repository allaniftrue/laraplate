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

Route::group(['middleware' => 'web'], function () {

    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    Route::group(['middleware' => 'auth'], function () {

        Route::get('dashboard', 'Dashboard\DashboardController@index');
        Route::get('dashboard/profile', 'Dashboard\ProfileController@index');
        Route::post('dasboard/profile/upload', 'Dashboard\ProfileController@upload');
        Route::post('dashboard/profile/store', 'Dashboard\ProfileController@store');
        Route::post('dashboard/profile/login/update', 'Dashboard\ProfileController@updatePassword');
    });

});



