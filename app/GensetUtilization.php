<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class GensetUtilization extends Model  implements AuditableContract
{
    use Auditable;
	protected $auditInclude = [
        'start_date', 
        'end_date', 
        'remarks',
		'added_by',
		'date_added',
		'unit_id',
		'fuel',
		'kwh',
		'run_start',
		'run_stop'
    ];


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
