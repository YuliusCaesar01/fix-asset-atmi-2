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

Route::prefix('kelompok')->middleware('auth')->group(function () {
    Route::resource('managekelompok', ManageKelompokController::class)->names([
        'index' => 'managekelompok.index',
        'create' => 'managekelompok.create',
        'store' => 'managekelompok.store',
        'show' => 'managekelompok.show',
        'edit' => 'managekelompok.edit',
        'update' => 'managekelompok.update',
        'destroy' => 'managekelompok.destroy',
    ]);
    Route::get('managekelompok/detail/{id_kelompok}', 'ManageKelompokController@detail')->name('managekelompok.detail');
});
