<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Permission extends Model
{
    use HasFactory;

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function permissioncategory(){
        return $this->belongsTo(PermissionCategory::class);
    }

    public function approvalrecord(){
        return $this->hasMany(ApprovalRecord::class);
    }

    public function permissiondebt(){
        return $this->hasOne(PermissionDebt::class);
    }

    public function scopeSPermissionWhere($query,$qry,$siteCheck,$departmentCheck){
        if(Auth::user()->level=='administrator'){
            return $query->where('permissions.active',$qry);
        }elseif(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
            return $query->where('permissions.site_id',$siteCheck)        
            ->where('permissions.active',$qry)
            ->where('c.department_id',$departmentCheck);
        }elseif(Auth::user()->hr_head=='1'){
            return $query->where('permissions.site_id',$siteCheck)        
            ->where('permissions.active',$qry);
        }else{
            return $query->where('permissions.site_id',$siteCheck)        
            ->where('permissions.active',$qry);
        }
    }
}
