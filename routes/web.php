<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

// all listings 
Route::get('/', [ListingController::class, 'index']);
//show create form 
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
//store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
//show edit listing 
Route::get(
    '/listings/{listing}/edit',
    [ListingController::class, 'edit']
)->middleware('auth');
//update submit listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//show register / create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
//create new user
Route::post('/users', [UserController::class, 'store']);
//log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
//show login form 
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
//log in user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
