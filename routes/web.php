<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\VisitorAuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlaceClaimController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/kategori/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

Route::get('/place', [PlaceController::class, 'index'])->name('place.index');
Route::get('/place/{place:slug}', [PlaceController::class, 'show'])->name('place.show');
Route::get('/search', function (\Illuminate\Http\Request $request) {
    return redirect()->route('place.index', $request->query());
})->name('search');
Route::get('/api/places/nearby', [PlaceController::class, 'nearby'])->name('api.places.nearby');

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
Route::post('/blog/{post:slug}/comment', [\App\Http\Controllers\BlogCommentController::class, 'store'])->name('blog.comment.store');

// Static & Legal Pages
Route::view('/information', 'information.index')->name('information.index');
Route::get('/panduan-wisata', function () {
    $guidePosts = \App\Models\BlogPost::published()
        ->where(function ($q) {
            $q->where('category', 'like', '%panduan%')
              ->orWhere('category', 'like', '%tips%')
              ->orWhere('title', 'like', '%panduan%')
              ->orWhere('title', 'like', '%tips%');
        })
        ->latest('published_at')
        ->take(3)
        ->get();

    if ($guidePosts->isEmpty()) {
        $guidePosts = \App\Models\BlogPost::published()->latest('published_at')->take(3)->get();
    }

    return view('guide.index', compact('guidePosts'));
})->name('guide.index');
Route::get('/pusat-informasi/{tab?}', [\App\Http\Controllers\LegalController::class, 'show'])->name('legal.show');
Route::get('/tentang-kami', fn() => redirect()->route('legal.show', 'tentang-kami'));
Route::get('/kebijakan-privasi', fn() => redirect()->route('legal.show', 'kebijakan-privasi'));
Route::get('/syarat-ketentuan', fn() => redirect()->route('legal.show', 'syarat-ketentuan'));
Route::get('/aksesibilitas', fn() => redirect()->route('legal.show', 'aksesibilitas'));
Route::get('/hubungi-kami', fn() => redirect()->route('legal.show', 'hubungi-kami'));

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

// Routes yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profil Pengguna
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Klaim Destinasi
    Route::get('/klaim/{place:slug}', [PlaceClaimController::class, 'create'])->name('claim.create');
    Route::post('/klaim', [PlaceClaimController::class, 'store'])->name('claim.store');
    Route::delete('/klaim/{claim}', [PlaceClaimController::class, 'destroy'])->name('claim.destroy');

    // Wishlist
    Route::get('/my-wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/place/{place}/wishlist', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

