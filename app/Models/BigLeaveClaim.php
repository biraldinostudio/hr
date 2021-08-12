<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigLeaveClaim extends Model
{
    use HasFactory;

    public function bigleave(){
        return $this->hasOne(BigLeave::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
