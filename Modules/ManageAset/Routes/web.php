<?php

use Illuminate\Support\Facades\Route;
use Modules\ManageAset\Http\Controllers\ManageAsetController;

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

Route::prefix('aset')->middleware('auth')->group(function () {
    Route::resource('manageaset', ManageAsetController::class)->names([
        'index' => 'manageaset.index',
        'create' => 'manageaset.create',
        'store' => 'manageaset.store',
        'show' => 'manageaset.show',
        'edit' => 'manageaset.edit',
        'update' => 'manageaset.update',
        'destroy' => 'manageaset.destroy',
    ]);
    Route::get('manageaset/detail/{kode_fa}', 'ManageAsetController@detail')->name('manageaset.detail');
    Route::post('manageaset/validateAsset/{kode_fa}', 'ManageAsetController@validateAsset')->name('manageaset.valid_fa');
    Route::get('/getDivisi', [ManageAsetController::class, 'getDivisi'])->name('getDivisi');
    Route::get('/getKelompok', [ManageAsetController::class, 'getKelompok'])->name('getKelompok');
    Route::get('/getJenis', [ManageAsetController::class, 'getJenis'])->name('getJenis');
    Route::get('/getRuang', [ManageAsetController::class, 'getRuang'])->name('getRuang');
    Route::post('/upload-data', [ManageAsetController::class, 'upload'])->name('manageaset.uploadmasal');
});
