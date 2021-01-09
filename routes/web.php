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


Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('index');
Route::group(['middleware' => 'page-cache'], function(){
    Route::get('/log/{id}', 'App\Http\Controllers\DashboardController@log')->name('show.log');
    Route::get('/log/getlog/{id}','App\Http\Controllers\DashboardController@getLog')->name('show.getlog');
    Route::get('/log/getlog2/{id}/{idm}','App\Http\Controllers\DashboardController@getLogz')->name('show.getlog2');
    Route::get('/log/spec/{spec}/{userid}/{idmatch}','App\Http\Controllers\DashboardController@statSpec')->name('spec.define');

});

