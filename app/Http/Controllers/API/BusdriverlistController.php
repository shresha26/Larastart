<?php

namespace App\Http\Controllers\API;
use App\Models\Busdriverlist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusdriverlistController extends Controller
{
    public function index()
    {
        return Busdriverlist::all();
    }
}