<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class DayOf extends Model
{
    use HasFactory;

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function poh(){
        return $this->belongsTo(Poh::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function dayofdestination(){
        return $this->hasMany(DayOfDestination::class);
    }

    public function approvalrecord(){
        return $this->hasMany(ApprovalRecord::class);
    }

    public function annualleave(){
        return $this->hasOne(AnnualLeave::class);
    }

    public function bigleave(){
        return $this->hasOne(BigLeave::class);
    }

    public function scopeSDayOfWhere($query,$qry,$siteCheck,$departmentCheck){
        if(Auth::user()->level=='administrator'){
            return $query->where('day_ofs.active',$qry);
        }elseif(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
            return $query->where('day_ofs.site_id',$siteCheck)        
            ->where('day_ofs.active',$qry)
            ->where('c.department_id',$departmentCheck);
        }elseif(Auth::user()->hr_head=='1'){
            return $query->where('day_ofs.site_id',$siteCheck)        
            ->where('day_ofs.active',$qry);
        }else{
            return $query->where('day_ofs.site_id',$siteCheck)        
            ->where('day_ofs.active',$qry);
        }
    }
}
