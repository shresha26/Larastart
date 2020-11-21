<?php

namespace App\Http\Controllers;
use App\Models\Buslocation;
use App\Http\Controllers\Controller;   
use Illuminate\Http\Request;

class Buslocationcontroller extends Controller
{
    public function index()
    {
        return Buslocation::all();
    }
}