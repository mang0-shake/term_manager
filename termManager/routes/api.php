<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
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
Route::resource('columns', 'ColumnController')->middleware(['auth:sanctum','can:TERMBASE_MANAGER']);
Route::get('/columns', [ColumnController::class, 'index']);

Route::resource('terms','TermController')->middleware(['auth:sanctum','can:TERM_MANAGER']);
Route::get('/terms', [TermController::class, 'index']);

Route::resource('users','UserController')->middleware(['auth:sanctum','can:USER_MANAGER']);
Route::get('/user/privileges', [UserController::class, 'getUserPrivileges']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/privileges', [PrivilegeController::class, 'getPrivileges']);
