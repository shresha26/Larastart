<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    // use HasFactory;
    protected$fillable = [
        'id',
        'code',
        'amount',
        'status',
    ];
    const UTILIZED = 1;
    const UNUTILIZED = 0;
}
