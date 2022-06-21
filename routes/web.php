<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

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


  //All listings
Route::get('/', [ListingController::class, 'index'])->name('home');

//Show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store form data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage Listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Display register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create new user
Route::post('/users', [UserController::class, 'store']);

//Logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Display login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Authenticate user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


// //Single Listing without route model binding
// Route::get('/listings/{id}', function ($id) {

//     $listing =  Listing::find($id);

//     if($listing){
//         return view('listing', [
//             'listing' => $listing
//         ]);
//     }else{
//         abort('404');
//     }

// });

// //Single Listing with route model binding
// Route::get('/listings/{listing}', function (Listing $listing) {
    // return view('listing', [
    //     'listing' => $listing
    // ]);
// });
