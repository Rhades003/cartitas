<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [App\Http\Controllers\UserController::class, 'user']);
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);

    Route::get('decks', [App\Http\Controllers\DeckController::class, "get"]);
    Route::post('decks', [App\Http\Controllers\DeckController::class, "create"]);
    Route::post('decks/{id}/cards', [App\Http\Controllers\DeckController::class, "addCard"]);
    Route::delete('decks/{id}/cards', [App\Http\Controllers\DeckController::class, "addCard"]);
    Route::get('decks/{id}', [App\Http\Controllers\DeckController::class, "getById"]);
    Route::put('decks/{id}', [App\Http\Controllers\DeckController::class, "delete"]);
    Route::delete('decks/{id}', [App\Http\Controllers\DeckController::class, "delete"]);
    
});

Route::apiResource('cards', CardController::class)->only(['index', 'show', 'update']);