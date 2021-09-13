<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
//use OwenIt\Auditing\Auditable;

class Role extends Model
{
    // use Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'description', 
        'active',
    ];

    // protected $auditInclude = [
    //     'name', 
    //     'description', 
    //     'active',
    // ];

    // public function permission()
    // {
    //     return $this->belongsToMany(Permission::class, 'roles_permissions');
    // }
}
