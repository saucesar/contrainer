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

Route::get('/','Controller@login')->name('user.login');
Route::post('/','Controller@autenticar')->name('user.auth');
Route::get('/home','Controller@index')->name('home.index');
Route::resource('users','UsersController');
Route::resource('maquinas','MaquinasController');
Route::resource('containers','ContainersController');