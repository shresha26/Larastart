<?php

namespace App\Http\Controllers\API;
use App\Models\Remainingamount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Remainingamountcontroller extends Controller
{
    public function index()
    {
        return Remainingamount::all();
    }
}