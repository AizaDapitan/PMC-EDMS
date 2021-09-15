<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class ScheduledDate extends Model implements AuditableContract
{
    use Auditable;
    protected $auditInclude = [
        'date_scheduled', 
        'remarks'
    ];
}
