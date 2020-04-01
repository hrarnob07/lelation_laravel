<?php

use Illuminate\Http\Request;

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

Route::group(
    ['prefix'=>'v1'],
    static function (){
        Route::post('registration','Api\V1\UserController@store');
        Route::post('login','Api\V1\Auth\AuthController@login');

        Route::group(["middleware" => "auth:api"],
            static function(){
            Route::group(['prefix' => 'post'], static function (){
                Route::post('create','Api\V1\PostController@store');

            });

            Route::group(['prefix' => 'comment'], static function (){
                    Route::post('create','Api\V1\CommentController@store');

                });

        });
    }
);
