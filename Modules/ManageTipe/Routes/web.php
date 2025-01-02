<?php

use Illuminate\Support\Facades\Route;
use Modules\ManageTipe\Http\Controllers\ManageTipeController;

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

Route::prefix('tipe')->middleware('auth')->group(function () {
    Route::resource('managetipe', ManageTipeController::class)->names([
        'index' => 'managetipe.index',
        'create' => 'managetipe.create',
        'store' => 'managetipe.store',
        'show' => 'managetipe.show',
        'edit' => 'managetipe.edit',
        'update' => 'managetipe.update',
        'destroy' => 'managetipe.destroy',
    ]);
    Route::get('managetipe/detail/{id_tipe}', 'ManagetipeController@detail')->name('managetipe.detail');
});
