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
    return view('welcome');
});

Route::get('/save-json-view', function () {
    return view('save_json');
});

Route::get('/update-json-view', function () {
    return view('update_json');
});

Route::middleware(['auth:sanctum', 'performance'])->match(['GET', 'POST'], 'save-json', [JsonController::class, 'createJson']);
Route::middleware(['auth:sanctum'])->match(['GET', 'POST'], 'update-json', [JsonController::class, 'updateJson']);