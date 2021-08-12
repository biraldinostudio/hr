<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lumpsum extends Model
{
    use HasFactory;
    
    public function site(){
        return $this->belongsTo(Site::class);
    }
    
    public function poh(){
        return $this->belongsTo(Poh::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }    
}
