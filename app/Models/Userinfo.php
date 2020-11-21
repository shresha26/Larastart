<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected$fillable = [
        'id',
        'username',
        'password',
        'address',
        'phoneno.', 
            ];  
}