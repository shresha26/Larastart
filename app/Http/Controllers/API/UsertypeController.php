<?php

namespace App\Http\Controllers\API;
use App\Models\Usertype;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsertypeController extends Controller
{
    public function index()
    {
        return Usertype::all();
    }
}
