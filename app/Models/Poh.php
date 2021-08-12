<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poh extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasMany(User::class);
    }

    public function pohdayof(){
        return $this->hasMany(PohDayOf::class);
    }

    public function pohannualleave(){
        return $this->hasMany(PohAnnualLeave::class);
    }

    public function pohbigleave(){
        return $this->hasMany(PohBigLeave::class);
    } 

    public function lumpsum(){
        return $this->hasMany(Lumpsum::class);
    }
    
    public function dayof(){
        return $this->hasMany(DayOf::class);
    }

    public function annualleave(){
        return $this->hasMany(AnnualLeave::class);
    }

    public function bigleave(){
        return $this->hasMany(BigLeave::class);
    }
}
