<?php

use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', TicketController::class)->except('update');
    Route::put('tickets/{ticket}/replace', [TicketController::class, 'replace']);

    Route::apiResource('authors', AuthorsController::class);
    Route::apiResource('authors.tickets', AuthorTicketsController::class)->except('update');
    Route::put('authors/{author}/tickets/{ticket}/replace', [AuthorTicketsController::class, 'replace']);
});
