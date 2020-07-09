<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
        'middleware' => ['auth:api'],
    ], 
    function () {
        Route::apiResources([
            'posts' => 'API\PostController',
        ]);

        Route::post('posts/{post}/toogle-publish', 'API\PostController@tooglePublish');
        Route::patch('users/update', 'API\UserController@update');
        Route::patch('users/password', 'API\UserController@changePassword');
    }
);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


