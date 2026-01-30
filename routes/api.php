<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PocketController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/profile', [AuthController::class, 'profile'])->middleware('auth:api');
Route::post('/pockets', [PocketController::class, 'store'])->middleware('auth:api');
