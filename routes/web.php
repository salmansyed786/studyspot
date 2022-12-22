<?php

use App\Http\Controllers\CommunityController;
use Illuminate\Support\Facades\Route;

// All Communities
Route::get('/', [CommunityController::class, 'index']);

// Single Community
Route::get('/c/{community}', [CommunityController::class, 'show']);

// Create Post
Route::get('/c/{community}/create', [CommunityController::class, 'createPost']);
Route::get('/create/post', [CommunityController::class, 'createPost']);

// Store Post
Route::post('/posts', [CommunityController::class, 'storePost']);


