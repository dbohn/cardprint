<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'CardController@index');

Route::get('/plants', 'CardController@plants');

Route::get('plants/search', 'PlantController@search');

Route::post('cards/create', 'CardController@createCards');
