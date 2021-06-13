<?php


use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/books/{id}/attachment', [BookController::class, 'attachment'])->name('books.attachment');

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::get('/home', function () {
    return redirect()->route('books.index');
});

Route::resource('genres', GenreController::class);
Route::post('/genres/create', [GenreController::class, 'store'])->name('store');

Route::resource('borrows', BorrowController::class);
//Route::post('/borrows/store', [BorrowController::class, 'store'])->name('store');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('books', BookController::class);
Route::get('/books/{id}/borrow', [BookController::class, 'borrow'])->name('borrow');

Route::resource('users', UserController::class);

Auth::routes();
