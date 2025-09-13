<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
//use App\Http\Controllers\PostViewController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostLikeController;

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
        //Route::post('/{id}/read', [PostViewController::class, 'markAsRead']);
        //::get('/read/list', [PostViewController::class, 'getReadPosts']);
    });

    // -------------------- USER POSTS --------------------
    Route::get('/users/{userId}/posts', [PostController::class, 'userPosts']);

    // -------------------- CATEGORIES & TAGS (quản lý) --------------------
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/tags', [TagController::class, 'store']);

    // -------------------- COMMENTS --------------------
    Route::get('/posts/{postId}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
    
    // -------------------- LIKES --------------------
    Route::post('/posts/{postId}/like', [PostLikeController::class, 'toggle']);
    Route::get('/posts/{postId}/likes', [PostLikeController::class, 'count']);
});

// -------------------- PUBLIC ROUTES --------------------
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
//test
Route::get('/users/{userId}/posts', [PostController::class, 'userPosts']);
Route::get('/testfeed', [PostController::class, 'feed']);     
Route::get('/posts/{postId}/comments', [CommentController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);  
Route::get('/posts/{postId}/likes', [PostLikeController::class, 'count']);