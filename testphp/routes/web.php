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

Auth::routes();

Route::get('/', 'ClientsController@index')->name('home');

Route::get('/clients','ClientsController@index');

Route::get('/client/{id}','ClientsController@show');

Route::post('/client/create', 'ClientsController@create')->name('/client/create');

Route::post('/client/delete', 'ClientsController@delete')->name('/client/delete');