<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListingController::class, 'index']);

Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');


Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');;

Route::get('/listings/{listing}', [ListingController::class, 'show']);


// Show the edit form 
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Submit the Edit updated value 
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

Route::delete('/listings/{listing}/delete', [ListingController::class, 'destroy'])->middleware('auth');


// Authentication form 
Route::get('/register', [UserController::class, 'create'])->middleware('guest');;

// Store the new User 
Route::post('/users', [UserController::class, 'store'])->middleware('guest');;

// Log the User out 
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show the login Form 
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');;

// Login the user
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');
