<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class DowntimeFlatData extends Model implements AuditableContract
{
    use Auditable;
	protected $auditInclude = [
        'unit_id', 
        'downtime_id', 
        'mins',
		'remarks',
		'is_scheduled',
		'date'
    ];

	protected $table = 'downtime_flatdata';

	protected $guarded = [];

	protected $dates = ['date'];

	public function downtime() {
		return $this->belongsTo('App\Downtime');
	}

}
