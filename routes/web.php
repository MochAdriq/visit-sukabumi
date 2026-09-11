<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\VisitorAuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/kategori/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

Route::get('/place', [PlaceController::class, 'index'])->name('place.index');
Route::get('/place/{place:slug}', [PlaceController::class, 'show'])->name('place.show');
Route::get('/search', function (\Illuminate\Http\Request $request) {
    return redirect()->route('place.index', $request->query());
})->name('search');

Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show');

// Tag-based listing routes
Route::get('/aktivitas', [TagController::class, 'indexActivity'])->name('tag.index.activity');
Route::get('/aktivitas/{tag:slug}', [TagController::class, 'show'])->name('tag.show.activity');

Route::get('/wisata', [TagController::class, 'indexWisata'])->name('tag.index.wisata');
Route::get('/wisata/{tag:slug}', [TagController::class, 'show'])->name('tag.show.wisata');

// Tempat Menginap (filter has_accommodation dari place index)
Route::get('/penginapan', function () {
    return redirect()->route('place.index', ['type' => 'penginapan']);
})->name('penginapan.index');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

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
