<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Permission extends Model implements AuditableContract
{
    use Auditable;
    //protected $guarded = [];

    // use Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    

    protected $fillable = [
        'module_type', 
        'description', 
        'active',
    ];
    protected $auditInclude = [
        'module_type', 
        'description', 
        'active',
    ];
}
