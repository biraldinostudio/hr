<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
//custom choy
use App\Notifications\ResetPasswordNotification;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Untuk custom email notification    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function poh(){
        return $this->belongsTo(Poh::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function dayof(){
        return $this->hasMany(DayOf::class);
    }

    public function bigleaveclaim(){
        return $this->hasMany(BigLeaveClaim::class);
    } 

    //Perlu dicek
    public function approvalrecord(){
        return $this->hasMany(ApprovalRecord::class);
    }

    public function permission(){
        return $this->hasMany(Permission::class);
    }

    public function assignment(){
        return $this->hasMany(Assignment::class);
    }

    public function permissiondebt(){
        return $this->hasMany(PermissionDebt::class);
    }
}
