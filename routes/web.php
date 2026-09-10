<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\VisitorAuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/kategori/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

Route::get('/place', [PlaceController::class, 'index'])->name('place.index');
Route::get('/place/{place:slug}', [PlaceController::class, 'show'])->name('place.show');

Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show');

// Static Pages
Route::view('/information', 'information.index')->name('information.index');

// Visitor Authentication Routes
Route::get('/login', [VisitorAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [VisitorAuthController::class, 'login']);
Route::get('/register', [VisitorAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [VisitorAuthController::class, 'register']);
Route::post('/logout', [VisitorAuthController::class, 'logout'])->name('logout');

// Review Route (Requires Auth)
Route::post('/place/{place}/review', [ReviewController::class, 'store'])->middleware('auth')->name('review.store');
Route::post('/event/{event}/review', [ReviewController::class, 'storeEvent'])->middleware('auth')->name('review.store.event');
Route::post('/review/{review}/like', [ReviewController::class, 'toggleLike'])->middleware('auth')->name('review.like');

// Wishlist Routes (Requires Auth)
Route::middleware('auth')->group(function () {
    Route::get('/my-wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/place/{place}/wishlist', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});
