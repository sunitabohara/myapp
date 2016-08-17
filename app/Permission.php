<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

	public function roles()
	{
		
     return $this->belongsTo('App\Role');
	}
}
