<?php

use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/movies/NewMovie', [MovieController::class, 'store'])->name('movie-store');
Route::get('/movies/FetchMovies', [MovieController::class, 'show'])->name('movie-store');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
