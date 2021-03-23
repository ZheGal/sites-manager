<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/hostiq/callback', [\App\Http\Controllers\HostiqController::class, 'callback'])->name('hostiq.callback');
Route::get('/sites_list', [\App\Http\Controllers\SiteController::class, 'api_list'])->name('sites.api_list');
Route::post('/sites_test', [\App\Http\Controllers\SiteController::class, 'api_testback'])->name('sites.api_testback');
Route::post('/sites_test/available', [\App\Http\Controllers\SiteController::class, 'api_available'])->name('sites.api_available');