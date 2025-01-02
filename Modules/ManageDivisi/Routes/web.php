<?php

use Illuminate\Support\Facades\Route;
use Modules\ManageDivisi\Http\Controllers\ManageDivisiController;

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

Route::prefix('divisi')->middleware('auth')->group(function () {
    Route::resource('managedivisi', ManageDivisiController::class)->names([
        'index' => 'managedivisi.index',
        'create' => 'managedivisi.create',
        'store' => 'managedivisi.store',
        'show' => 'managedivisi.show',
        'edit' => 'managedivisi.edit',
        'update' => 'managedivisi.update',
        'destroy' => 'managedivisi.destroy',
    ]);
    Route::get('managedivisi/detail/{id_divisi}', 'ManageDivisiController@detail')->name('managedivisi.detail');
});
