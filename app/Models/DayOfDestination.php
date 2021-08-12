<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOfDestination extends Model
{
    use HasFactory;

    public function dayof(){
        return $this->belongsTo(DayOf::class);
    }

    public function destination(){
        return $this->belongsTo(Destination::class,'id');
    }
}
