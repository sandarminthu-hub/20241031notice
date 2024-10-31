<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformationController;

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
Route::prefix('notice')
->controller(InformationController::class)
->name('notice.')
->group(function () {
    Route::get('/','index')->name('index');
    Route::get('/create','create')->name('create');
    Route::post('/create','create')->name('create');
    Route::post('/','store')->name('store');
    Route::get('/{id}/edit','edit')->name('edit');
    Route::post('/{id}/edit','edit')->name('edit');
    Route::post('/{id}/update','update')->name('update');
    Route::post('/{id}/destory','destory')->name('destory');
});