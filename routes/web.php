<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;

Route::get('/', [HomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/home', [AdminController::class, 'index']);
Route::get('/category_page', [AdminController::class, 'category_page'])->middleware(['auth', Admin::class]);
Route::post('/add_category', [AdminController::class, 'add_category'])->middleware(['auth', Admin::class]);
Route::get('/category_delete/{id}', [AdminController::class, 'category_delete'])->middleware(['auth', Admin::class]);
Route::get('/edit_category/{id}', [AdminController::class, 'edit_category'])->middleware(['auth', Admin::class]);
Route::post('/update_category/{id}', [AdminController::class, 'update_category'])->middleware(['auth', Admin::class]);

Route::get('/add_book', [AdminController::class, 'add_book'])->middleware(['auth', Admin::class]);
Route::post('/store_book', [AdminController::class, 'store_book'])->middleware(['auth', Admin::class]);

Route::get('/show_book', [AdminController::class, 'show_book'])->middleware(['auth', Admin::class]);
Route::get('/book_delete/{id}', [AdminController::class, 'book_delete'])->middleware(['auth', Admin::class]);

Route::get('/edit_book/{id}', [AdminController::class, 'edit_book'])->middleware(['auth', Admin::class]);
Route::post('/update_book/{id}', [AdminController::class, 'update_book'])->middleware(['auth', Admin::class]);

Route::get('/borrow_books/{id}', [HomeController::class, 'borrow_books']);

Route::get('/borrow_request', [AdminController::class, 'borrow_request'])->middleware(['auth', Admin::class]);
Route::get('/approve_book/{id}', [AdminController::class, 'approve_book'])->middleware(['auth', Admin::class]);
Route::get('/return_book/{id}', [AdminController::class, 'return_book'])->middleware(['auth', Admin::class]);
Route::get('/rejected_book/{id}', [AdminController::class, 'rejected_book'])->middleware(['auth', Admin::class]);

Route::get('/book_history', [HomeController::class, 'book_history']);
Route::get('/cancel_request/{id}', [HomeController::class, 'cancel_request']);

Route::get('/explore', [HomeController::class, 'explore']);

Route::get('/search', [HomeController::class, 'search']);
Route::get('/cat_search/{id}', [HomeController::class, 'cat_search']);

Route::get('/payment/{id}', [HomeController::class, 'payment']);

Route::post('/process_payment/JazzCash', [HomeController::class, 'payment_jazzcash']);
Route::post('/process_payment/JazzCash', [HomeController::class, 'payment_easypaisa']);