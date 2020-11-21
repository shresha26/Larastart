<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerrideinfo extends Model
{
    protected$fillable = [
        'id',
        'customerid',
        'longitude',
        'latitude',
        'amount',
        'date',
        'time', 
            ];
}