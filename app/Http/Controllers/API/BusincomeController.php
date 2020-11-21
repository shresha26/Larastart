<?php

namespace App\Http\Controllers\API;
use App\Models\Busincome;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Busincomecontroller extends Controller
{
    public function index()
    {
        return Busincome::all();
    }
}