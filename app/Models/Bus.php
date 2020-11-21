<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected$fillable = [
        'id',
        'busno',
        'buscolor',
        'engineno',
        'mfddate',
        'companyname',
            ];
        }
