<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');
Route::get('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
