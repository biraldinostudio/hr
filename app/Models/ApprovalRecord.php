<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalRecord extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function dayof(){
        return $this->belongsTo(DayOf::class);
    }

    public function permission(){
        return $this->belongsTo(Permission::class);
    }

    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }
}
