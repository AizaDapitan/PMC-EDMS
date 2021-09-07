<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DowntimeFlatData extends Model
{

	protected $table = 'downtime_flatdata';

	protected $guarded = [];

	protected $dates = ['date'];

	public function downtime() {
		return $this->belongsTo('App\Downtime');
	}

}
