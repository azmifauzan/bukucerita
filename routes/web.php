<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/guide', [GuideController::class, 'index'])->name('guide');

// Authentication required routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Custom Profile Route (Override Jetstream default)
    Route::get('/user/profile', function () {
        return Inertia::render('Profile/CustomShow', [
            'sessions' => collect([]), // Empty for now, will be filled by Jetstream if needed
            'confirmsTwoFactorAuthentication' => false,
        ]);
    })->name('profile.show');

    // Book management - specific routes first, then dynamic routes
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/books', [AdminController::class, 'books'])->name('books');
        Route::post('/books/{book}/approve', [AdminController::class, 'approveBook'])->name('books.approve');
        Route::post('/books/{book}/reject', [AdminController::class, 'rejectBook'])->name('books.reject');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    });
});

// This route needs to be outside the middleware group for public access, but after /books/create to avoid conflicts
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
