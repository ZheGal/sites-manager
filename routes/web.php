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

Route::middleware(['auth:sanctum', 'verified', 'is_active'])->group(function () {
    Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('sites.list');
    Route::middleware(['is_admin'])->group(function() {
        Route::get('/sites/create', [\App\Http\Controllers\SiteController::class, 'create'])->name('sites.create');
        Route::get('/sites/create/group', [\App\Http\Controllers\SiteController::class, 'addGroup'])->name('sites.group');
        Route::post('/sites/store', [\App\Http\Controllers\SiteController::class, 'store'])->name('sites.store');
        Route::post('/sites/store/group', [\App\Http\Controllers\SiteController::class, 'storeGroup'])->name('sites.group_store');
        Route::get('/sites/{id}/edit', [\App\Http\Controllers\SiteController::class, 'edit'])->name('sites.edit');
        Route::get('/sites/{id}/update', [\App\Http\Controllers\SiteController::class, 'updateConnector'])->name('sites.update.functions');
        Route::patch('/sites/{id}', [\App\Http\Controllers\SiteController::class, 'update'])->name('sites.update');
        Route::delete('/sites/{id}', [\App\Http\Controllers\SiteController::class, 'destroy'])->name('sites.destroy');
        
        Route::get('/sites/{id}/edit/import', [\App\Http\Controllers\SiteController::class, 'importIndex'])->name('sites.importfrom');
        Route::post('/sites/{id}/edit/import', [\App\Http\Controllers\SiteController::class, 'importStore'])->name('sites.import');
        
        // тестирование
        Route::get('/sites/{id}/tests/run', [\App\Http\Controllers\SiteController::class, 'testrun'])->name('sites.testrun');
    });
    Route::post('/sites/transfer', [\App\Http\Controllers\SiteController::class, 'transfer'])->name('sites.transfer');
    
    Route::get('/hosters', [\App\Http\Controllers\HosterController::class, 'index'])->name('hosters.list');
    Route::middleware(['is_admin'])->group(function() {
        Route::get('/hosters/create', [\App\Http\Controllers\HosterController::class, 'create'])->name('hosters.create');
        Route::post('/hosters/store', [\App\Http\Controllers\HosterController::class, 'store'])->name('hosters.store');
        Route::get('/hosters/{id}/edit', [\App\Http\Controllers\HosterController::class, 'edit'])->name('hosters.edit');
        Route::patch('/hosters/{id}', [\App\Http\Controllers\HosterController::class, 'update'])->name('hosters.update');
        Route::delete('/hosters/{id}', [\App\Http\Controllers\HosterController::class, 'destroy'])->name('hosters.destroy');
    });

    Route::get('/campaigns', [\App\Http\Controllers\CampaignController::class, 'index'])->name('campaigns.list');
    Route::middleware(['is_admin'])->group(function() {
        Route::get('/campaigns/create', [\App\Http\Controllers\CampaignController::class, 'create'])->name('campaigns.create');
        Route::post('/campaigns/store', [\App\Http\Controllers\CampaignController::class, 'store'])->name('campaigns.store');
        Route::get('/campaigns/{id}/edit', [\App\Http\Controllers\CampaignController::class, 'edit'])->name('campaigns.edit');
        Route::patch('/campaigns/{id}', [\App\Http\Controllers\CampaignController::class, 'update'])->name('campaigns.update');
        Route::delete('/campaigns/{id}', [\App\Http\Controllers\CampaignController::class, 'destroy'])->name('campaigns.destroy');
    });

    Route::get('/offers', [\App\Http\Controllers\OfferController::class, 'index'])->name('offers.list');

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.list');
    Route::get('/users/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
    Route::middleware(['is_admin'])->group(function() {
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
    
    Route::get('/metrika', [\App\Http\Controllers\Controller::class, 'cleaned'])->name('metrika.index');
    Route::get('/hostiq', [\App\Http\Controllers\Controller::class, 'cleaned'])->name('hostiq.index');
    
    Route::middleware(['is_admin'])->group(function() {
        Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    });
});

Route::middleware(['auth:sanctum', 'verified', 'is_not_active'])->group(function () {
    Route::get('/unactive', [\App\Http\Controllers\Controller::class, 'unactive'])->name('unactive.index');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [\App\Http\Controllers\Controller::class, 'register'])->name('register');
});

// Route::get('/welcome', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
