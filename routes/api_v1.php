<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\TicketController;


Route::middleware('auth:sanctum')->apiResource('tickets', TicketController::class);
Route::middleware('auth:sanctum')->apiResource('users', UserController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



