<?php

use Modules\ManageLokasi\Http\Controllers\ManageLokasiController;
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


Route::prefix('lokasi')->middleware('auth')->group(function () {
    Route::resource('managelokasi', ManageLokasiController::class)->names([
        'index' => 'managelokasi.index',
        'create' => 'managelokasi.create',
        'store' => 'managelokasi.store',
        'show' => 'managelokasi.show',
        'edit' => 'managelokasi.edit',
        'update' => 'managelokasi.update',
        'destroy' => 'managelokasi.destroy',
    ]);
    Route::get('managelokasi/detail/{id_lokasi}', 'ManageLokasiController@detail')->name('managelokasi.detail');
});
