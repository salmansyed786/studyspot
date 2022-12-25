<?php

use App\Http\Controllers\CommunityController;
use Illuminate\Support\Facades\Route;

// Display All Communities
Route::get('/', [CommunityController::class, 'index']);

// Display a Single Community
Route::get('/c/{community}', [CommunityController::class, 'show']);

// Create Post
Route::get('/c/{community}/create', [CommunityController::class, 'createPost']);
Route::get('/create/post', [CommunityController::class, 'createPost']);

/* COMMUNITY CRUD */
// Store Community
Route::post('/communities', [CommunityController::class, 'storeCmty']);

// Update Community
Route::put('/c/{community}', [CommunityController::class, 'updateCmty']);

// Delete Community
Route::delete('/c/{community}', [CommunityController::class, 'destroyCmty']);

/* POST CRUD */
// Store Post
Route::post('/posts', [CommunityController::class, 'storePost']);

// Edit Post
Route::get('/c/{community}/{post}/edit', [CommunityController::class, 'editPost']);

// Update Post
Route::put('/c/{community}/{post}', [CommunityController::class, 'updatePost']);

// Delete Post
Route::delete('/c/{community}/{post}', [CommunityController::class, 'destroyPost']);
