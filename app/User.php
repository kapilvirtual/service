<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
   // protected $fillable = [
    //    'name', 'email', 'password'
    //];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   // protected $hidden = [
    //    'password', 'remember_token',
   // ];
	
	
	 /**
     * A permission can be applied to roles.
     */
    public function userroles(){
        return $this->belongsToMany('App\Model\Roles', 'user_has_roles', 'role_id', 'user_id');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
	
	
}
