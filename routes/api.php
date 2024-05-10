<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

});


Route::group([
    'middleware' => 'api',
    'prefix' => 'lms'
], function ($router) {
    //-----------------------------------authors Routes-----------------------------------//
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    //-----------------------------------books Routes-----------------------------------//

    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);


      //-----------------------------------Review Routes-----------------------------------//

      Route::get('/reviews', [ReviewController::class, 'index']);
      Route::post('/reviews', [ReviewController::class, 'store']);
      Route::get('/reviews/{review}', [ReviewController::class, 'show']);
      Route::put('/reviews/{review}', [ReviewController::class, 'update']);
      Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});

