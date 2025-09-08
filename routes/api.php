<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostViewController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;

// -------------------- AUTH --------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // -------------------- POSTS --------------------
    Route::prefix('posts')->group(function () {
        Route::get('/newsfeed', [PostController::class, 'newsfeed']); // chưa đọc
        Route::get('/', [PostController::class, 'feed']);             // tất cả
        Route::get('/{id}', [PostController::class, 'show']);         // chi tiết
        Route::post('/', [PostController::class, 'store']);           // tạo mới
        Route::put('/{id}', [PostController::class, 'update']);       // update
        Route::delete('/{id}', [PostController::class, 'destroy']);   // xóa

        // -------------------- POST VIEWS --------------------
        Route::post('/{id}/read', [PostViewController::class, 'markAsRead']);
        Route::get('/read/list', [PostViewController::class, 'getReadPosts']);
    });

    // -------------------- USER POSTS --------------------
    Route::get('/users/{userId}/posts', [PostController::class, 'userPosts']);

    // -------------------- CATEGORIES & TAGS (quản lý) --------------------
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/tags', [TagController::class, 'store']);
});

// -------------------- PUBLIC ROUTES --------------------
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
