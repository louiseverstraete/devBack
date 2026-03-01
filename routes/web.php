<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicEventController;

Route::get('/', function () {
    // return Event::class->organizer();
});

Route::get('/events', [PublicEventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [PublicEventController::class, 'register'])->name('events.register');
Route::get('/registrations/cancel/{registration}', [PublicEventController::class, 'cancel'])->name('registrations.cancel')->middleware('signed');
Route::get('/login', [PublicEventController::class, 'login'])->name('admin.login');
Route::post('/login', [PublicEventController::class, 'loginSubmit'])->name('admin.login.submit');

Route::post('/reviews', [PublicEventController::class, 'storeReview'])->name('reviews.store');
