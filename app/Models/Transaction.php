<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected$fillable = [
        'id',
        'from_account',
        'to_account',
        'type',
        'remarks',
        'status',
        'amount'
            ];

            public function senderUser(){
                return $this->belongsTo(User::class,'from_account');
            }
            public function receiverUser(){
                return $this->belongsTo(User::class,'to_account');
            }
        }
