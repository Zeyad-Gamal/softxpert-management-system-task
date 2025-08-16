<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum' , 'role:manager'])->group(function () {
//    Route::post('/tasks', [TaskController::class, 'store']);
});




Route::middleware(['auth:sanctum' , 'role:user'])->group(function () {
//    Route::post('/my-tasks', [TaskController::class, 'myTasks']);
});
