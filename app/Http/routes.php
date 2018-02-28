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


Route::get('prueba','MetricasController@prueba');

Route::get('/','MetricasController@index');
Route::get('/form','MetricasController@form');
Route::get('/getLabs', 'MetricasController@getLabs');
route::get('/getUsers', 'MetricasController@getUsers');
route::get('/eportexcel', 'MetricasController@exportExcel');