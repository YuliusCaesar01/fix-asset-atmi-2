<?php

use Illuminate\Support\Facades\Route;
use Modules\ManageRuang\Http\Controllers\ManageRuangController;

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

Route::prefix('ruang')->middleware('auth')->group(function () {
    Route::resource('manageruang', ManageRuangController::class)->names([
        'index' => 'manageruang.index',
        'create' => 'manageruang.create',
        'store' => 'manageruang.store',
        'show' => 'manageruang.show',
        'edit' => 'manageruang.edit',
        'update' => 'manageruang.update',
        'destroy' => 'manageruang.destroy',
    ]);
    Route::get('manageruang/detail/{id_ruang}', 'ManageRuangController@detail')->name('manageruang.detail');
});
