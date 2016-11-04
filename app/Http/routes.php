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

Route::auth();

Route::get('/login_instagram', [
    'uses' => 'Auth\AuthController@loginInstagram',
    'as' => 'login.instagram'
]);

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {

    Route::post('user/avatar', 'UserController@avatar');

    Route::resource('user', 'UserController', ['except' => [
        'index', 'create', 'store'
    ]]);
});
