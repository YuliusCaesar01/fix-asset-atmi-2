<?php

use Modules\ManageUser\Http\Controllers\ManageUserController;
use Illuminate\Support\Facades\Route;
use Modules\ManageUser\Http\Controllers\ProfileController;

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

// Route::prefix('manageuser')->group(function() {
//     Route::get('/', 'ManageUserController@index');
// });

Route::prefix('profile')->group(function () {
    Route::resource('myprofile', ProfileController::class);
});
