<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route to get all products
Route::get('/products', [ProductController::class, 'index']);

// Route to display a single product
Route::get('/products/{id}', [ProductController::class, 'show']);

// Route to search for a product by name
Route::get('/products/search/{name}', [ProductController::class, 'search']);

// Route for user registration
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route for user login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route grouping protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    // Route to add a new product (only for authenticated users)
    Route::post('/products', [ProductController::class, 'store']);

    // Route to update a product (only for authenticated users)
    Route::put('/products/{id}', [ProductController::class, 'update']);

    // Route to delete a product (only for authenticated users)
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Route for user logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route to get information about the logged-in user
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});
