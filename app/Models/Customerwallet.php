<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerwallet extends Model
{
    protected $table = 'customerwallet';
    protected $fillable = [
        'id',
        'customername',
        'email',
        'address',
        'phone no',
        'balance',
        'user_id',
         ];
        public function walletHolder(){
            return $this->belongsTo(User::class);
        }
}
