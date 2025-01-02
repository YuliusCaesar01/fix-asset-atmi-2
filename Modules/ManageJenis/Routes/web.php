<?php

use Illuminate\Support\Facades\Route;
use Modules\ManageJenis\Http\Controllers\ManageJenisController;

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

Route::prefix('jenis')->middleware('auth')->group(function () {
    Route::resource('managejenis', ManageJenisController::class)->names([
        'index' => 'managejenis.index',
        'create' => 'managejenis.create',
        'store' => 'managejenis.store',
        'show' => 'managejenis.show',
        'edit' => 'managejenis.edit',
        'update' => 'managejenis.update',
        'destroy' => 'managejenis.destroy',
    ]);
    Route::get('managejenis/detail/{id_jenis}', 'ManagejenisController@detail')->name('managejenis.detail');
});
