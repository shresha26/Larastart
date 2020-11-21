<?php

namespace App\Http\Controllers\API;
use App\Models\customerrideinfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Customerrideinfocontroller extends Controller
{
    public function index()
    {
        return Customerrideinfo::all();
    }
}