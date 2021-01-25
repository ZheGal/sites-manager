<?php

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('sites.list');
    Route::get('/sites/create', [\App\Http\Controllers\SiteController::class, 'create'])->name('sites.create');
    Route::post('/sites/store', [\App\Http\Controllers\SiteController::class, 'store'])->name('sites.store');
    
    Route::get('/hosters', [\App\Http\Controllers\HosterController::class, 'index'])->name('hosters.list');
    Route::get('/hosters/create', [\App\Http\Controllers\HosterController::class, 'create'])->name('hosters.create');
    Route::post('/hosters/store', [\App\Http\Controllers\HosterController::class, 'store'])->name('hosters.store');
    Route::get('/hosters/{id}/edit', [\App\Http\Controllers\HosterController::class, 'edit'])->name('hosters.edit');
    Route::patch('/hosters/{id}', [\App\Http\Controllers\HosterController::class, 'update'])->name('hosters.update');
    Route::delete('/hosters/{id}', [\App\Http\Controllers\HosterController::class, 'destroy'])->name('hosters.destroy');

    Route::get('/campaigns', [\App\Http\Controllers\Controller::class, 'cleaned'])->name('campaigns.list');
    Route::get('/users', [\App\Http\Controllers\Controller::class, 'cleaned'])->name('users.list');
    Route::get('/metrika', [\App\Http\Controllers\Controller::class, 'cleaned'])->name('metrika.index');
    Route::get('/hostiq', [\App\Http\Controllers\Controller::class, 'cleaned'])->name('hostiq.index');

    Route::get('/test', function() {
        return 'test';
    });
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
