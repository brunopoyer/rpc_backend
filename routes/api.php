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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tags', [App\Http\Controllers\TagController::class, 'list']);
Route::get('/tag/{id}', [App\Http\Controllers\TagController::class, 'get']);
Route::post('/tag', [App\Http\Controllers\TagController::class, 'create']);
Route::put('/tag/{id}', [App\Http\Controllers\TagController::class, 'update']);
Route::delete('/tag/{id}', [App\Http\Controllers\TagController::class, 'delete']);


Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'list']);
Route::get('/task/{id}', [App\Http\Controllers\TaskController::class, 'get']);
Route::post('/task', [App\Http\Controllers\TaskController::class, 'create']);
Route::put('/task/{id}', [App\Http\Controllers\TaskController::class, 'update']);
Route::delete('/task/{id}', [App\Http\Controllers\TaskController::class, 'delete']);

