<?php

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TicketController;


Route::apiResource('tickets', TicketController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



