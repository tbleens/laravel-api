<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BeatController;
use App\Http\Controllers\Api\KanbanController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('posts', PostController::class);

Route::apiResource('beats', BeatController::class);

Route::post('/posts/{id}/like', [LikeController::class, 'likePost'])->middleware('auth:sanctum');

Route::post('/beats/{id}/like', [LikeController::class, 'likeBeat']);

Route::post('/auth/register', [AuthController::class, 'createUser']);

Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::post('/users/changePassword', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');

Route::post('/users/delete/{id}', [AuthController::class, 'deleteUser'])->middleware('auth:sanctum');
