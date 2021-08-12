<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    public function dayofdestination(){
        return $this->hasMany(DayOfDestination::class,'from_id','to_id');
    }

    public function assignmentdestination(){
        return $this->hasMany(AssignmentDestination::class,'from_id','to_id');
    }
}
