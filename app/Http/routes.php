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
    $letter = 'abcdefgHIJKLMN0123456789';
    $str = '';
    for ($i=0; $i < 5; $i++) {
        $str = $str . $letter[rand(0,23)];
    }
    return $str;
    echo urlencode('s中国s lf&*$    43-9_42');
    return baidu_translate('s中国s lf&*$    43-9_42');
    return view('welcome');
});

Route::resource('article', 'ArticleController', ['except' => ['index', 'create']]);
Route::get('articles/create', 'ArticleController@create');
Route::post('articles/upload', 'ArticleController@upload');
Route::get('articles', 'ArticleController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/*// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');*/
