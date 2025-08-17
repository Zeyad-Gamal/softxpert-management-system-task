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



Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {


    Route::middleware('role:manager')->group(function () {
   Route::post('/tasks', [TaskController::class, 'store']);
   Route::put('/tasks/{id}', [TaskController::class, 'update']);
   Route::post('/tasks/{id}/dependencies', [TaskController::class, 'addDependencies']);
});


    // get all tasks
   Route::get('/tasks', [TaskController::class, 'index']);

   // get task details
   Route::get('/tasks/{id}', [TaskController::class, 'show']);



Route::middleware('role:user')->group(function () {

   Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus']);

});


});


