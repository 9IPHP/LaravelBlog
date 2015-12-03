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

Route::resource('article', 'ArticleController', ['except' => ['index', 'create']]);
Route::get('articles/create', 'ArticleController@create');
Route::get('articles/getslug', 'ArticleController@getslug');
Route::post('articles/upload', 'ArticleController@upload');
Route::get('articles/user/{user_id}', 'ArticleController@forUser');
Route::get('articles', 'ArticleController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('tags', 'TagController@index');
Route::get('tag/{slug}', 'TagController@show');

Route::resource('user', 'UserController', ['except' => ['index', 'create', 'store']]);
// Route::get('user/{id}/articles', 'UserController@articles');
// Route::get('users', 'UserController@index');
/*Route::get('users', 'UserController@index');
Route::get('user/{id}', 'UserController@show');
Route::get('user/{id}/articles', 'UserController@articles');
Route::get('user/{id}/edit', 'UserController@edit');
Route::patch('user/{id}', 'UserController@update');*/

/*// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');*/
