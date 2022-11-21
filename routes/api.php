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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//route cliente
Route::apiResource('cliente', 'App\Http\Controllers\ClienteController');

//route carro
Route::apiResource('carro', 'App\Http\Controllers\CarroController');

//route locação
Route::apiResource('locacao', 'App\Http\Controllers\LocacaoController');

//route marca
Route::apiResource('marca', 'App\Http\Controllers\MarcaController');

//modelo
Route::apiResource('modelo', 'App\Http\Controllers\ModeloController');
