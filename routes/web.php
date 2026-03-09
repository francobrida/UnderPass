<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\VibeCheckController;

require __DIR__.'/auth.php';

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events', [EventController::class, 'index']);

// clubbers
Route::middleware('auth')->group(function () {
    Route::resource('events', EventController::class)->except(['index', 'show']); 
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my'); 

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/my-stamps', [StampController::class, 'stamps'])->name('user.stamps');
Route::get('/stamps/claim/{token}', [StampController::class, 'claim'])->name('events.stamp.claim');

// ADMIN
Route::get('/panel-admin', [AdminEventController::class, 'index'])->name('admin.index')->middleware('auth');
Route::delete('/admin/eventos/{event}', [EventController::class, 'destroy'])->name('admin.destroy')->middleware('auth');
// User creation
Route::get('/admin/create', [UserController::class, 'create'])->name('users.create')->middleware('auth');
Route::patch('/admin/store', [UserController::class, 'store'])->name('admin.users.store')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    
    // WAITING ROOM
    Route::get('/waiting-room', [EventController::class, 'waitingRoom'])->name('events.waiting-room');

    // VOUCH
    Route::post('/events/{event}/vouch', [EventController::class, 'vouch'])->name('events.vouch');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/vibecheck/{event}', [VibeCheckController::class, 'create'])->name('events.vibecheck');
    Route::post('/vibecheck/{event}', [VibeCheckController::class, 'store'])->name('events.vibecheck.store');
});

// Rutas dinámicas SIEMPRE al final
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// DYNAMIC ROUTES (ALWAYS AT THE END)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('auth');
