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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::namespace('Api')->group(function () {
    //clientes
    Route::get('/clientes', 'ClientesController@index');
    Route::post('/clientes', 'ClientesController@store');
    Route::get('/clientes/{cliente}', 'ClientesController@show');
    Route::put('/clientes/{cliente}', 'ClientesController@update');
    Route::delete('/clientes/{cliente}', 'ClientesController@destroy');
    Route::get('/clientes_listar', 'ClientesController@listar');
    
    //usuarios
    Route::get('/users', 'UsersController@index');
    Route::post('/users', 'UsersController@store');
    Route::get('/users/{user}', 'UsersController@show');
    Route::put('/users/{user}', 'UsersController@update');
    Route::delete('/users/{user}', 'UsersController@destroy');


    //vehiculos
    Route::get('/vehiculos', 'VehiculosController@index');
    Route::post('/vehiculos', 'VehiculosController@store');
    Route::get('/vehiculos/{vehiculo}', 'VehiculosController@show');
    Route::get('/vehiculos_cliente/{cliente}', 'VehiculosController@show_cliente');
    Route::put('/vehiculos/{vehiculo}', 'VehiculosController@update');
    Route::delete('/vehiculos/{vehiculo}', 'VehiculosController@destroy');
});

