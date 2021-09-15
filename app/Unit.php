<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Unit extends Model implements AuditableContract
{
    use Auditable;

	protected $guarded = [];


    protected $auditInclude = [
        'name', 
        'type', 
        'location'
    ];

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
