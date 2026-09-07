<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;

Route::get('/', function () {
    $mustSees = \App\Models\Place::with('category')->where('status', 'published')->inRandomOrder()->limit(4)->get();
    return view('home', compact('mustSees'));
});

Route::get('/place', [PlaceController::class, 'index'])->name('place.index');
Route::get('/place/{place:slug}', [PlaceController::class, 'show'])->name('place.show');
