<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProfileController;

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
    return Inertia::render('Auth/Login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// contacts controller
Route::resource('contacts', ContactsController::class)->middleware('auth');

// notifications controller
Route::resource('notifications', NotificationsController::class)->middleware('auth');
Route::post('update_status', [NotificationsController::class, 'updateStatus'])->middleware('auth')->name('notifications.update_status');

// profile controller
Route::resource('profile', ProfileController::class)->middleware('auth');
require __DIR__.'/auth.php';
