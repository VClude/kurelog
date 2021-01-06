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


Route::get('/', 'App\Http\Controllers\DashboardController@index');
Route::get('/log/{id}', 'App\Http\Controllers\DashboardController@log')->name('show.log');
Route::get('/log/getlog/{id}','App\Http\Controllers\DashboardController@getLog')->name('show.getlog');
Route::get('/log/showgrid/{userid}/{idmatch}','App\Http\Controllers\DashboardController@showGrid')->name('show.grid');
