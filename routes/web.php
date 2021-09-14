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
Route::get('/gc12final', 'App\Http\Controllers\DashboardController@twelvefinal')->name('gc.twelve');
Route::post('/accessWhitelist', 'App\Http\Controllers\DashboardController@accessWhitelist')->name('access.whitelist');
Route::get('/gcrank/{txt?}/{gc?}', 'App\Http\Controllers\DashboardController@gcView')->name('show.gc'); 
Route::get('/gclist/{txt?}/{gc?}', 'App\Http\Controllers\DashboardController@getGcRank')->name('get.gc');
Route::get('/finala', 'App\Http\Controllers\DashboardController@getGcFinalA')->name('get.finala');
Route::get('/finalb', 'App\Http\Controllers\DashboardController@getGcFinalB')->name('get.finalb');

Route::get('/guild/{id?}/{type?}', 'App\Http\Controllers\DashboardController@logProfileOnly')->name('show.guild');

// Route::group(['middleware' => 'page-cache'], function(){
    Route::get('/log/{id}', 'App\Http\Controllers\DashboardController@log')->name('show.log');
    Route::get('/loggrid/{id}', 'App\Http\Controllers\DashboardController@logGridOnly')->name('show.gridonly');
    Route::get('/profile/{id}', 'App\Http\Controllers\DashboardController@showProfile')->name('show.profile');
    Route::get('/log/getlog/{id}','App\Http\Controllers\DashboardController@getLog')->name('show.getlog');
    Route::get('/log/getlogd/{id}','App\Http\Controllers\DashboardController@getLogD')->name('show.getlogd');
    Route::get('/log/getlog2/{id}/{idm}','App\Http\Controllers\DashboardController@getLogz')->name('show.getlog2');
    Route::get('/log/spec/{spec?}/{userid?}/{idmatch?}','App\Http\Controllers\DashboardController@statSpec')->name('spec.define');
    Route::get('/log/weapspec/{userid?}/{idmatch?}/{spec?}','App\Http\Controllers\DashboardController@statSpecWeap')->name('weapspec.define');
    Route::get('/log/showgrid/{userid}/{idmatch}','App\Http\Controllers\DashboardController@showGrid')->name('show.grid');
    Route::get('/log/showgridsino/{userid}/{idmatch}','App\Http\Controllers\DashboardController@showGridSino')->name('show.gridsino');

    Route::get('/log/showgridb/{userid}/{idmatch}','App\Http\Controllers\DashboardController@showGridB')->name('show.gridb');
    Route::get('/log/showbuff/{userid}/{idmatch}','App\Http\Controllers\DashboardController@getBuffSimp')->name('show.buff');

// });

