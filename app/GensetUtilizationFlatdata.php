<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GensetUtilizationFlatdata extends Model
{


	protected $table = 'genset_utilization_flatdata';
	protected $guarded = [];


	public function genset() {
		return $this->belongsTo('App\GensetUtilization');
	}

	public function unit() {
		return $this->belongsTo('App\Unit');
	}

}
