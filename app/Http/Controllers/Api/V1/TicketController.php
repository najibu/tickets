<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TicketResource;
use App\Http\Requests\V1\UpdateTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TicketResource::collection(Ticket::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        //
    }

    /**
     * Display the specifiedπ resource.
     */
    public function show(Ticket $ticket)
    {
        // return TicketResource::make($ticket);
        return TicketResource::make(Ticket::first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
