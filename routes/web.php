<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;

// Route::view("/", "index");
// Route::view("/movie", "show");

Route::get("/", [MoviesController::class, "index"])->name('movies.index');
Route::get("/movies/{movie}", [MoviesController::class, "show"])->name("movies.show");
