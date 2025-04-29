<?php

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

Route::get('/cards', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
})->name("login");
Route::get('/register', function () {
    return view('register');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/decks', function () {
    return view('decks');
});
Route::get('/cards/{id}', function () {
    return view('card');
});
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/decks', function () {
        return view('decks');
    });
    Route::get('/decks/{id}', function ($id) {
        return view('deck', ['id' => $id]);
    })->name('decks.show');
    });
