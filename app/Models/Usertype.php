<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    protected$fillable = [
        'id',
        'username',
            ];
        public function users(){
            return $this->hasMany(User::class,"type");
        }
        }
