<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Downtime extends Model implements AuditableContract
{
    use Auditable;

	protected $table = 'downtime';

	protected $guarded = [];

	protected $dates = ['start_date', 'end_date'];

	protected $auditInclude = [
        'unit_id', 
        'remarks', 
        'added_by',
		'is_scheduled',
		'start_date',
		'end_date'
    ];


	public function unit () 
	{
		return $this->belongsTo('App\Unit');
	}
	
	public function downtime_flat() {
		return $this->hasMany('App\DowntimeFlatData');
	}

}
