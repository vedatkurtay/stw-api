<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\People\PeopleController;
use App\Http\Controllers\Planet\PlanetController;
use App\Http\Controllers\Vehicle\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Three resources: People, Planet, Vehicle route group
Route::middleware('auth:sanctum')->group(function () {
    // People Routes
    Route::prefix('people')->group(function () {
        Route::get('/', [PeopleController::class, 'index']);
        Route::get('/{id}', [PeopleController::class, 'show']);
    });

    // Planet Routes
    Route::prefix('planet')->group(function () {
        Route::get('/', [PlanetController::class, 'index']);
        Route::get('/{id}', [PlanetController::class, 'show']);
    });

    // Vehicle Routes
    Route::prefix('vehicle')->group(function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::get('/{id}', [VehicleController::class, 'show']);
    });
});
