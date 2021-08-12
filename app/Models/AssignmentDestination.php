<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentDestination extends Model
{
    use HasFactory;

    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }

    public function destination(){
        return $this->belongsTo(Destination::class,'id');
    }
}
