<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Assignment extends Model
{
    use HasFactory;

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function approvalrecord(){
        return $this->hasMany(ApprovalRecord::class);
    }

    public function scopeSAssignmentWhere($query,$qry,$siteCheck,$departmentCheck){
        if(Auth::user()->level=='administrator'){
            return $query->where('assignments.active',$qry);
        }elseif(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
            return $query->where('assignments.site_id',$siteCheck)        
            ->where('assignments.active',$qry)
            ->where('c.department_id',$departmentCheck);
        }elseif(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1'){
            return $query->where('assignments.site_id',$siteCheck)        
            ->where('assignments.active',$qry);
        }elseif(Auth::user()->hr_head=='1'){
            return $query->where('assignments.site_id',$siteCheck)        
            ->where('assignments.active',$qry);
        }else{
            return $query->where('assignments.site_id',$siteCheck)        
            ->where('assignments.active',$qry);
        }
    }
}
