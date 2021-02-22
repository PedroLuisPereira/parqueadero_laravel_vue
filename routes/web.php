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

// Route::get('/', function () {
//     return view('welcome');
// });

//autenticacion 
Route::get('/login', 'AuthController@formulario')->middleware('guest')->name('auth.formulario');
Route::post('/login', 'AuthController@login')->middleware('guest')->name('auth.login');
Route::get('/logout', 'AuthController@logout')->middleware('auth')->name('auth.logout');
Route::post('/logout', 'AuthController@logout')->middleware('auth')->name('auth.logout');

//rutas de la spa
Route::get('/{any}', 'SpaController@index')->where('any', '.*');