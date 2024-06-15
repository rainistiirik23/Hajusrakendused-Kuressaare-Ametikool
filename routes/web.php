<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\weatherApiController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/weather', [weatherApiController::class, 'getWeatherData']);
Route::get('/Map', [MapController::class, 'index'])->name('map-index');
Route::post('/Map-marker-submit', [MapController::class, 'store'])->name('map-marker-submit');
Route::delete('/Map-marker-delete', [MapController::class, 'destroy'])->name('map-marker-delete');
Route::patch('/Map-marker-edit', [MapController::class, 'update'])->name('map-marker-edit');
Route::get('/Blogs', [BlogController::class, 'render'])->name('blogs');
Route::middleware('auth')->group(function () {
    Route::get('/Blogs-Create', [BlogController::class, 'create'])->middleware(['auth'])->name('blog-create');
    Route::post('/Blog-Submit', [BlogController::class, 'store'])->middleware(['auth'])->name('blog-submit');
    Route::get('/User-Blogs', [BlogController::class, 'showUsersBlogs'])->middleware(['auth'])->name('users-blogs');
    Route::delete('/Blog-Delete', [BlogController::class, 'destroy'])->middleware(['auth'])->name('blog-delete');
    Route::patch('/Blog-update', [BlogController::class, 'update'])->middleware(['auth'])->name('blog-update');

    Route::post('/Blog-Comment-Submit', [CommentController::class, 'store'])->middleware(['auth'])->name('comment-submit');
    Route::delete('/Blog-Comment-Delete', [CommentController::class, 'destroy'])->middleware(['auth'])->name('blog-comment-delete');

    Route::get('/Blog-Admin-Edit', [BlogController::class, 'showAdminBlogEditView'])->middleware(['auth'])->name('blog-admin-edit-view');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
