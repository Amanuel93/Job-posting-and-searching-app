<?php
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

//Show all listings
Route::get('/', [ListingController::class,'index']);

//Show form to create new listing
Route::get('/listing/create',[ListingController::class,'create']) -> middleware('auth');
  
//update listing
Route::put('/listing/{listing}',[ListingController::class,'update']) -> middleware('auth');

// Store new listing
Route::post('/listings',[ListingController::class,'store']) -> middleware('auth');

//show form for editing
Route::get('/listing/{listing}/edit',[ListingController::class,'edit']) -> middleware('auth');

// Update Listing
// Route::put('/listings/{listing}', [ListingController::class, 'update']);

//manage listing
Route::get('/listing/manage',[ Listingcontroller::class,'manage']);

// Show single listing
Route::get('/listing/{listing}',[ListingController::class,'show'])-> middleware('auth');


// Delete Listing
Route::delete('/listing/{listing}',[ListingController::class,'destroy']);


// Register users
Route::get('/register',[ Usercontroller::class,'create']) -> middleware('guest');

//create a new user
Route::post('/users',[ Usercontroller::class,'store']);


// Show login form
Route::get('/login',[ Usercontroller::class,'login'])->name('login')->middleware('guest');

//Logout users
Route::post('/logout',[ Usercontroller::class,'logout']);

//Authenticate users
Route::post('/users/authenthicate',[ Usercontroller::class,'authenticate']);







