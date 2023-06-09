<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
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

// ****************** Inscription et connexion ****************

// inscription 
Route::post('register', [App\Http\Controllers\API\UserController::class, 'store'])->name('register');

// connexion 
Route::post('login', [App\Http\Controllers\API\LoginController::class, 'login'])->name('login');


// route ressource users
Route::apiResource("users", UserController::class);

// route ressource posts
Route::apiResource("posts", PostController::class);

// route ressource comments
Route::apiResource("comments", CommentController::class);

