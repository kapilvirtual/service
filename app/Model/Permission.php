<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Permission extends Model
{
    protected $guarded = [];
	protected $table = 'permission';
	
	// use SoftDeletes;
	 
	
}