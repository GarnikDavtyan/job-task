<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonController;

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

Route::get('/', function () {
    return to_route('jsons.index');
});

Route::controller(JsonController::class)->group(function () {
    Route::get('jsons/edit', 'edit')->name('jsons.edit');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::middleware(['performance'])->match(['GET', 'POST'], 'jsons/store', 'store');
        Route::match(['GET', 'POST'], 'jsons/update', 'update');
    });
});

Route::resource('jsons', JsonController::class)->except(['edit', 'store', 'update']);