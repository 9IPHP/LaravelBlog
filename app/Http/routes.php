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
    $user2 = App\User::find(2);
    $user4 = App\User::find(4);
    $user2->follows()->save($user4);
    dd($user2->follows->toArray());
    return view('welcome');
});
Route::get('/', 'ArticleController@index');

Route::resource('article', 'ArticleController', ['except' => ['index', 'create']]);
Route::get('articles/create', 'ArticleController@create');
Route::get('articles/view/{id}', 'ArticleController@view');
Route::post('articles/active', 'ArticleController@active');
Route::post('articles/like', 'ArticleController@like');
Route::post('articles/opt', 'ArticleController@restoreOrDelete');
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
Route::get('user/{id}/resetpwd', 'UserController@resetpwd');
Route::patch('user/{id}/updatepwd', 'UserController@updatepwd');
Route::get('user/{id}/articles', 'UserController@articles');
Route::get('user/{id}/collects', 'UserController@collects');
Route::get('user/{id}/trash', 'UserController@trash');
Route::get('users', 'UserController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'role:editor', 'namespace' => 'Admin'], function()
{
    Route::get('/', 'IndexController@index');
    Route::get('index', 'IndexController@index');
    // Route::resource('/admin/index', 'IndexController');
    Route::resource('articles', 'ArticleController', ['only' => ['index', 'destroy']]);
    Route::get('articles/index', 'ArticleController@index');
    // Route::delete('articles/index', 'ArticleController@destroy');
    Route::get('articles/trash', 'ArticleController@trash');
    Route::delete('articles/delete/{id}', 'ArticleController@forceDestroy');
    Route::post('articles/deletes', 'ArticleController@forceDestroyAll');
    Route::post('articles/restore/{id}', 'ArticleController@restoreDeleted');
    Route::get('articles/comments', 'ArticleController@comments');
    Route::get('articles/tags', 'ArticleController@tags');
    Route::post('articles/deltag', 'ArticleController@deltag');
    Route::post('articles/delcomment', 'ArticleController@delcomment');

    // Route::resource('users', 'UserController', ['only' => ['index', 'edit', 'update']]);
    Route::get('users/index', 'UserController@index');
    Route::post('users/changerole', 'UserController@changeRole');
    Route::get('users/roles', 'UserController@roles');
    Route::get('users/roles/{id}/edit', 'UserController@editRole');
    Route::put('users/roles/{id}/edit', 'UserController@updateRole');
    Route::patch('users/roles/{id}/edit', 'UserController@updateRole');
    Route::delete('users/{id}', 'UserController@destroy');

    Route::get('images/index', 'ImageController@index');
    Route::resource('images', 'ImageController');
    Route::post('images/delimage', 'ImageController@delimage');

    Route::resource('options', 'OptionController', ['except' => ['show', 'edit', 'destroy']]);
    Route::get('options/index', 'OptionController@index');
});
