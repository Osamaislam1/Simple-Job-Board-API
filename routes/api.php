<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/jobs/search', [JobController::class, 'search']);

    Route::apiResource('jobs', JobController::class);

    Route::post('/applications', [JobApplicationController::class, 'store']);
    Route::get('/jobs/{job}/applications', [JobApplicationController::class, 'indexByJob']);
    Route::get('/user/applications', [JobApplicationController::class, 'indexByUser']);
});
