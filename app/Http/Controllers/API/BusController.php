<?php

namespace App\Http\Controllers\API;
use App\Models\Bus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return Bus::all();
    }
}