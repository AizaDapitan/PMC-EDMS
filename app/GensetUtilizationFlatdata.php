<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class GensetUtilizationFlatdata extends Model  implements AuditableContract
{
    use Auditable;
	protected $auditInclude = [
        'date', 
        'mins', 
        'unit_id',
		'fuel',
		'kwh',
		'downtime_id',
		'remarks',
		'run_start',
		'run_stop'
    ];


	protected $table = 'genset_utilization_flatdata';
	protected $guarded = [];


	public function genset() {
		return $this->belongsTo('App\GensetUtilization');
	}

	public function unit() {
		return $this->belongsTo('App\Unit');
	}

}
