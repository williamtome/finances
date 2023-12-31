<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RevenueController;
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

Route::resource('revenues', RevenueController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::resource('expenses', ExpenseController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
