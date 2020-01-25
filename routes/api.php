<?php

use Illuminate\Http\Request;
Use App\Books;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//External api
Route::get('/external-books/', 'BookController@externalBooks');
Route::get('/external-books/{id}', 'BookController@getexternalBook');
//Alternative external api
Route::get('/external-posts/', 'BookController@externalPosts');
Route::get('/external-posts/{id}', 'BookController@getexternalPosts');
//CRUD ROUTE API
Route::get('/v1/books', 'BookController@index');
Route::get('/v1/books/{book}', 'BookController@show');
Route::post('/v1/books', 'BookController@create');
Route::patch('/v1/books/{book}', 'BookController@update');
Route::delete('/v1/books/{book}', 'BookController@delete');
