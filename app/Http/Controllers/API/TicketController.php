<?php

namespace App\Http\Controllers\API;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Ticketcontroller extends Controller
{
    public function index()
    {
        return Ticket::all();
    }
}