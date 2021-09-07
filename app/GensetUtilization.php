<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GensetUtilization extends Model
{


	protected $table = 'genset_utilization';
	protected $guarded = [];
	protected $dates = ['start_date', 'end_date'];


	public function unit() {
		return $this->belongsTo('App\Unit');
	}

	public function genset_flatdata() {
		return $this->hasMany('App\GensetUtilizationFlatdata');
	}

}
