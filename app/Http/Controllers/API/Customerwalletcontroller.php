<?php

namespace App\Http\Controllers\API;
use App\Models\Customerwallet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class customerwalletcontroller extends Controller
{
    public function index()
    {
        return customerwallet::all();
    }
}