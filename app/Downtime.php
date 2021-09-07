<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downtime extends Model
{

	protected $table = 'downtime';

	protected $guarded = [];

	protected $dates = ['start_date', 'end_date'];



	public function unit () 
	{
		return $this->belongsTo('App\Unit');
	}
	
	public function downtime_flat() {
		return $this->hasMany('App\DowntimeFlatData');
	}

}
