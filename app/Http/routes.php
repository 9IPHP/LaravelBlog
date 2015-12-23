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
Route::get('test', function(){

    // $user = Auth::loginUsingId(2);
    $role = \App\Role::findOrFail(3);
    $role->assignPermission(1);
    // dd($role);
    // dd($user->assignRole(5));
    dd($role->permissions->fetch('id')->toArray());
    dd($user->roles->toArray());
    dd(auth()->user()->hasPermission('article.create'));
    return view('welcome');
});
Route::get('/', 'ArticleController@index');

Route::resource('article', 'ArticleController', ['except' => ['index', 'create']]);
Route::get('articles/create', 'ArticleController@create');
Route::get('articles/view/{id}', 'ArticleController@view');
Route::post('articles/active', 'ArticleController@active');
Route::post('articles/like', 'ArticleController@like');
Route::post('articles/collect', 'ArticleController@collect');
Route::post('articles/upload', 'ArticleController@upload');
Route::get('articles/user/{user_id}', 'ArticleController@forUser');
Route::get('articles', 'ArticleController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('tags', 'TagController@index');
Route::get('tag/{slug}', 'TagController@show');

Route::post('comment/store', 'CommentController@store');
Route::get('comment/get', 'CommentController@getComments');

Route::resource('user', 'UserController', ['only' => ['show', 'edit', 'update']]);
Route::get('user/{id}/articles', 'UserController@articles');
Route::get('user/{id}/collects', 'UserController@collects');
Route::get('users', 'UserController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'role:editor', 'namespace' => 'Admin'], function()
{
    Route::get('index', 'IndexController@index');
    // Route::resource('/admin/index', 'IndexController');
    Route::resource('articles', 'ArticleController', ['only' => ['index', 'destroy']]);
    Route::get('articles/index', 'ArticleController@index');
    // Route::delete('articles/index', 'ArticleController@destroy');
    Route::get('articles/trash', 'ArticleController@trash');
    Route::delete('articles/delete/{id}', 'ArticleController@forceDestroy');
    Route::post('articles/deletes', 'ArticleController@forceDestroyAll');

    Route::get('users/index', 'UserController@index');
});
