<?php

use Modules\ManageInstitusi\Http\Controllers\ManageInstitusiController;
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

// Route::prefix('institusi')->middleware('auth')->group(function() {
//     Route::get('/', 'ManageInstitusiController@index')->name('manageinstitusi');
// });

Route::prefix('institusi')->middleware('auth')->group(function () {
    Route::resource('manageinstitusi', ManageInstitusiController::class)->names([
        'index' => 'manageinstitusi.index',
        'create' => 'manageinstitusi.create',
        'store' => 'manageinstitusi.store',
        'show' => 'manageinstitusi.show',
        'edit' => 'manageinstitusi.edit',
        'update' => 'manageinstitusi.update',
        'destroy' => 'manageinstitusi.destroy',
    ]);
    Route::get('manageinstitusi/detail/{id_institusi}', 'ManageInstitusiController@detail')->name('manageinstitusi.detail');
});
