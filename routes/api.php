<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserAPIController;

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

Route::prefix('v1')->group(
    function () {
        Route::post('login', [AuthApiController::class, 'login']);
        Route::post('register', [AuthApiController::class, 'register']);

        // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        //     return $request->user();
        // });
        Route::middleware('jwt')->group(function () {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
            Route::get('/users/{id}', [UserAPIController::class, 'getUser']);

            Route::middleware('check.admin')->group(function () {
                Route::get('/users', [UserAPIController::class, 'getAllUsers']);
                Route::post('/users', [UserAPIController::class, 'createUser']);
                Route::put('/users/{id}', [UserAPIController::class, 'updateUser']);
                Route::delete('/users/{id}', [UserAPIController::class, 'deleteUser']);
            });
        });
    }
);
