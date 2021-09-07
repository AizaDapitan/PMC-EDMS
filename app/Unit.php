<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

	protected $guarded = [];



	public function downtime () 
	{
		return $this->hasMany('App\Downtime');
	}
	
	public function genset() {
		return $this->hasMany('App\GensetUtilization');
	}

	public function genset_flat() {
		return $this->hasMany('App\GensetUtilizationFlatdata');
	}

}
