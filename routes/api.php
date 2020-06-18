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

Route::apiResource('atividadeMaquinas', 'Api\AtividadeMaquinasController');
Route::apiResource('InstanciaContainers', 'Api\InstanciaContainerController')->except(['create', 'index', 'show']);
Route::get('InstanciaContainers/stop/{containerId}', 'Api\InstanciaContainerController@playStop')->name('instance.playStop');
Route::post('InstanciaContainers/exec-in-terminal/{containerId}', 'Api\InstanciaContainerController@execInTerminal')->name('instance.execInTerminal');
