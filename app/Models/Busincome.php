<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busincome extends Model
{
    protected$fillable = [
        'id',
        'busid',
        'busdriverlistid',
        'customerrideinfoid',
        'balance',
            ];
}