<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::middleware('throttle:books')->group(function () {
    
});

Route::resource('books', BookController::class)
->only(['index', 'show']);

// Rate limit request 
// Route::middleware('throttle:reviews')->group(function () {
//     Route::resource('books.reviews', ReviewController::class)
//     ->scoped(['review' => 'book'])
//     ->only(['create', 'store']);
// });

Route::resource('books.reviews', ReviewController::class)
->scoped(['review' => 'book'])
->only(['create', 'store']);