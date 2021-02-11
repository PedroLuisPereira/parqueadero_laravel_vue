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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//mostrar usuarios ficticios
// Route::get('/users', function () {
//     //error sumulado
//     if (rand(1, 10) < 3) {
//         abort(500, 'We could not retrieve the users');
//     }
//     //datos
//     return factory('App\User', 10)->make();
// });

Route::namespace('Api')->group(function () {
    Route::get('/users', 'UsersController@index');
    Route::post('/users', 'UsersController@store');
    Route::get('/users/{user}', 'UsersController@show');
    Route::put('/users/{user}', 'UsersController@update');
    Route::delete('/users/{user}', 'UsersController@destroy');

    //clientes
    Route::get('/clientes', 'ClientesController@index');
    Route::get('/clientes_listar', 'ClientesController@listar');
    Route::post('/clientes', 'ClientesController@store');
    Route::get('/clientes/{cliente}', 'ClientesController@show');
    Route::put('/clientes/{cliente}', 'ClientesController@update');
    Route::delete('/clientes/{cliente}', 'ClientesController@destroy');

    //vehiculos
    Route::get('/vehiculos', 'VehiculosController@index');
    Route::post('/vehiculos', 'VehiculosController@store');
    Route::get('/vehiculos/{vehiculo}', 'VehiculosController@show');
    Route::get('/vehiculos_cliente/{cliente}', 'VehiculosController@show_cliente');
    Route::put('/vehiculos/{vehiculo}', 'VehiculosController@update');
    Route::delete('/vehiculos/{vehiculo}', 'VehiculosController@destroy');
});

