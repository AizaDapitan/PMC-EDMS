<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Asset extends Model implements AuditableContract
{
    use Auditable;

	protected $guarded = [];
	protected $dates = ['commmissioning_date'];
	protected $auditInclude = [
        'tag', 
        'asset_type', 
        'description',
		'manufacturer',
		'model',
		'serial',
		'year_manufactured',
		'commissioning_date',
		'site',
		'location',
		'condition',
		'status',
		'vendor',
		'po_reference',
		'po_value',
		'is_deleted'
    ];


	public function locations() {

		return ["69 KV SUBSTATION", "69 KV SUBSTATION", "ADMIN", "AGSAO SHAFT", "ASSAY",
		"BAGUIO SHAFT", "BMEA", "COFFER DAM", "COMPRESSOR HOUSE", "DAM 1", "DAM 2",
		"DAM 3", "DAM 4", "DAM 5", "DAVAO OFFICE", "DOMINION SUBSTATION", "E15 SHAFT",
		"ECS COMPOUND", "ENVI. SUBSTATION", "GUEST HOUSE", "HOSPITAL", "JR. STAFFHOUSE",
		"LEVEL 8 SHAFT", "MCC100", "MCC500", "MCD", "MECHANICAL SHOP", "MILL-MINE HAUL ROAD",
		"PADIGUSAN", "PHSFI", "PINAYONGAN", "POWER HOUSE", "REPEATER STATION", "SAG MILL AREA",
		"SOUTH AGSAO", "SR. STAFFHOUSE", "TINAGO", "WATER DAM", "WEIGH BRIDGE"];

	}


	public function conditions() {

		return ["EXCELLENT", "GOOD", "POOR"];

	}


	public function statuses() {

		return ["OPERATIONAL", "NO OPERATIONAL", "STANDBY SPARE", "FOR REPAIR", "FOR DISPOSAL"];

	}


	public function siteOptions() {

		return ["MILL", "MINE", "EXPLORATION", "DAVAO", "OTHER"];

	}


}
