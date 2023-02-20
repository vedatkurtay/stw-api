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
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // People Routes
    Route::prefix('people')->group(function () {
        Route::get('/', [PeopleController::class, 'index']);
        Route::get('/{people}', [PeopleController::class, 'show']);
    });

    // Planet Routes
    Route::prefix('planet')->group(function () {
        Route::get('/', [PlanetController::class, 'index']);
        Route::get('/{planet}', [PlanetController::class, 'show']);
    });

    // Vehicle Routes
    Route::prefix('vehicle')->group(function () {
        Route::get('/', [VehicleController::class, 'index']);
        Route::get('/{vehicle}', [VehicleController::class, 'show']);
    });
});
