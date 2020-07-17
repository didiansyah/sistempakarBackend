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

Route::prefix('v1')->group(function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::get('/logout', 'AuthController@logout')->middleware('auth:api');


    Route::prefix('users')->group(function () {
        Route::get('', 'UserController@index')->name('users.index');
        Route::post('create', 'UserController@store');
        Route::get('{user}', 'UserController@show')->name('users.show');
        Route::put('{user}/update', 'UserController@update')->name('users.update');
        Route::delete('{user}/destroy', 'UserController@destroy');
    });

    Route::prefix('penyakits')->group(function () {
        Route::get('', 'PenyakitController@index')->name('penyakits.index');
        Route::post('create', 'PenyakitController@store');
        Route::get('{penyakit}', 'PenyakitController@show')->name('penyakits.show');
        Route::put('{penyakit}/update', 'PenyakitController@update')->name('penyakits.update');
        Route::delete('{penyakit}/destroy', 'PenyakitController@destroy');
    });
    
    Route::prefix('gejalas')->group(function () {
        Route::get('', 'GejalaController@index')->name('gejalas.index');
        Route::post('create', 'GejalaController@store');
        Route::get('{gejala}', 'GejalaController@show')->name('gejalas.show');
        Route::put('{gejala}/update', 'GejalaController@update')->name('gejalas.update');
        Route::delete('{gejala}/destroy', 'GejalaController@destroy');
    });

    Route::prefix('rules')->group(function () {
        Route::get('', 'RuleController@index')->name('rules.index');
        Route::post('create', 'RuleController@store');
        Route::get('{rule}', 'RuleController@show')->name('rules.show');
        Route::put('{rule}/update', 'RuleController@update')->name('rules.update');
        Route::delete('{rule}/destroy', 'RuleController@destroy');
    });

    Route::post('hasil_diagnosas/create','HasilDiagnosaController@store');
});
