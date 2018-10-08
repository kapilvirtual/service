<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roles extends Model
{
    public $guarded = ['id'];
	protected $table = 'roles';
	
	//use SoftDeletes;

    /**
     * A permission can be applied to roles.
     */
    public function permissions(){
        return $this->belongsToMany('App\Model\Permission', 'role_has_permissions', 'role_id', 'permission_id');
    }


}
