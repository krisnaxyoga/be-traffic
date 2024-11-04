<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/level', [App\Http\Controllers\Api\LevelController::class, 'index']);
    Route::get('/question/{id}', [App\Http\Controllers\Api\QuestionController::class, 'index']);
    Route::post('/question-jawab/{id}', [App\Http\Controllers\Api\QuestionController::class, 'create']);
});
