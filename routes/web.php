<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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


//Common Resource Route:

/*
index - show all items
show - show a single item
create - show form to create new listing
store - store new item
edit - show form to edit item
update - update item
destroy - delete item
*/

// Get all listings
Route::get('/', [ListingController::class, 'index']);

//Show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store listing (POST)
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Show manage listing page
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Get a single listing     (make sure this route is last)
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Show register/Create User form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create register/Create User
Route::post('/users', [UserController::class, 'store']);

//logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//post login
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
