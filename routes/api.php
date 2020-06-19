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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('books','BooksController@index');
Route::post('book','BooksController@store');
Route::get('book/{id}','BooksController@show');
Route::delete('book/{id}','BooksController@destroy');
Route::post('addComment','BooksController@addComment');
Route::post('addAnswer','BooksController@addAnswer');
Route::post('likeComment','BooksController@likeComment');
Route::post('dislikeComment','BooksController@dislikeComment');
Route::post('likeAnswer','BooksController@likeAnswer');
Route::post('dislikeAnswer','BooksController@dislikeAnswer');

Route::group([

    'middleware' => 'api'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});


