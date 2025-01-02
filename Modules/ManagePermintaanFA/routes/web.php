<?php

use Illuminate\Support\Facades\Route;
use Modules\ManagePermintaanFA\app\Http\Controllers\ManagePermintaanFAController;

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

Route::prefix('permintaanfa')->middleware('auth')->group(function () {
    Route::resource('managepermintaanfa', ManagePermintaanFAController::class)->names([
        'index' => 'managepermintaanfa.index',
        'create' => 'managepermintaanfa.create',
        'store' => 'managepermintaanfa.store',
        'show' => 'managepermintaanfa.show',
        'edit' => 'managepermintaanfa.edit',
        'update' => 'managepermintaanfa.update',
        'destroy' => 'managepermintaanfa.destroy',
    ]);
    Route::get('managepermintaanfa/detail/{id_permintaanfa}', 'ManagePermintaanFAController@detail')->name('managepermintaanfa.detail');
});
