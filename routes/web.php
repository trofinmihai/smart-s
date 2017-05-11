<?php

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

Route::get('/', function () {
    return "ASd";
});
Route::get('/users', 'UserController@show');
Route::get('/users/{id}', 'UserController@find');
Route::post('/users', 'UserController@insert');

Route::get('/products', 'ProductController@show');
Route::post('/products', 'ProductController@checkProduct');

Route::get('/shopping/{id}', 'ShoppingController@show');