<?php

namespace App\Http\Controllers\API;
use App\Models\Routeinfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteinfoController extends Controller
{
    public function index()
    {
        return Routeinfo::all();
    }
}