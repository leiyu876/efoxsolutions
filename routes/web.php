<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PageController@welcome')->name('welcome');
Route::get('/post/{post}', 'PageController@post')->name('post');

Auth::routes();

Route::group([
        'middleware' => ['auth'],
    ], 
    function () {

        Route::get('/home', 'PostController@index')->name('home');

        Route::get('/users/edit', 'UserController@edit')->name('users.edit');
        Route::get('/users/update', 'UserController@update');

        Route::get('/users/password', 'UserController@changePassword')->name('users.password');

        Route::resources([
            'posts' => 'PostController',
        ]);
    }
);
