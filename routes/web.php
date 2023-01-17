<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MembershipController;

// Display All Communities
Route::get('/', [CommunityController::class, 'index']);

// Display a Single Community
Route::get('/c/{community}', [CommunityController::class, 'show']);

Route::get('/search/', [CommunityController::class, 'search'])->name('search');

/* COMMUNITY CRUD */
// Store Community
Route::post('/communities', [CommunityController::class, 'storeCmty'])->middleware('auth');

// Update Community
Route::put('/c/{community}', [CommunityController::class, 'updateCmty'])->middleware('auth');

// Delete Community
Route::delete('/c/{community}', [CommunityController::class, 'destroyCmty'])->middleware('auth');

// Leave Community
Route::delete('/c/{community}/leave', [MembershipController::class, 'leaveCmty'])->middleware('auth');

// Join Community
Route::post('/c/{community}/join', [MembershipController::class, 'joinCmty'])->middleware('auth');

/* POST CRUD */
// Create Post
Route::get('/c/{community}/create', [PostController::class, 'createPost'])->middleware('auth');
Route::get('/create/post', [PostController::class, 'createPost'])->middleware('auth');

// Store Post
Route::post('/posts', [PostController::class, 'storePost'])->middleware('auth');

// Edit Post
Route::get('/c/{community}/{post}/edit', [PostController::class, 'editPost'])->middleware('auth');

// Update Post
Route::put('/c/{community}/{post}', [PostController::class, 'updatePost'])->middleware('auth');

// Delete Post
Route::delete('/c/{community}/{post}', [PostController::class, 'destroyPost'])->middleware('auth');

// Manage Posts
Route::get('/manage/posts', [PostController::class, 'managePosts'])->middleware('auth');

// Like Post
Route::get('/{post}/like', [LikeController::class, 'likePost'])->middleware('auth');

// Dislike Post
Route::get('/{post}/dislike', [LikeController::class, 'dislikePost'])->middleware('auth');

/* USER CRUD */
// Opens Signup Modal
Route::get('/register', [UserController::class, 'register'])->name('register')->middleware('guest');
Route::get('/signup', [UserController::class, 'register'])->name('register')->middleware('guest');

// Open Login Modal
Route::get('/login', [UserController::class, 'register'])->name('register')->middleware('guest');

// User Registeration
Route::post('/register', [UserController::class, 'storeUser']);

// User Login
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// User Logout
Route::post('/logout', [UserController::class, 'logoutUser'])->middleware('auth');

// Any other route, produce a 404 error
Route::fallback(function () {
    abort(403, 'Unauthorized action.');
});