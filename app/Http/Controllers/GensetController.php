<?php

namespace App\Http\Controllers;

use Session;
use App\Unit;
use Carbon\Carbon;
use App\GensetUtilization;
use Illuminate\Http\Request;
use App\GensetUtilizationFlatdata;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\RoleRightService;

class GensetController extends Controller
{
	public function __construct(
        RoleRightService $roleRightService
    ) {
        // $this->middleware('auth');
        $this->roleRightService = $roleRightService;
    }

	public function store(Request $request) {

		$data = $request->validate([
			'unit_id' 		=> 'required',
			'start_date'	=> 'required|before_or_equal:end_date',
			'end_date'		=> 'required|after_or_equal:start_date',
			'remarks'		=> 'required',
			'fuel'			=> 'required',
			'kwh'			=> 'required',
			'run_start'		=> 'required',
			'run_stop'		=> 'required',
			'added_by'		=> \Auth::user()->name
		]);

		$existing_genset_runtime = GensetUtilization::where('unit_id', $data['unit_id'])
			->where(function($query) use ($data) {
				$query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
					->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
			})
			->first();

		if( $existing_genset_runtime ) {
			Session::flash('error_message', 'Unit is already scheduled for the selected date.'); 
			return back();
		}

		$genset = GensetUtilization::create($data);
		$data['genset_id'] = $genset->id;

		$this->createGensetFlatData($data);

		// $start_date = Carbon::parse($data['start_date']);
		// $end_date	= Carbon::parse($data['end_date']);
		// $time_diff = $start_date->diffInDays($end_date);

		// if( $time_diff > 0 ) {

		// 	while( $start_date->lte($end_date) ) {

		// 		$a = new Carbon($start_date);
		// 		$b = new Carbon($end_date);

		// 		$Sday = $a->format('Y-m-d');
		// 		$Eday = $b->format('Y-m-d');
		// 		$hour = $a->hour;
		// 		$mins = $a->minute;

		// 		if( $Sday == $Eday ) {
		// 			$total_mins = ( $hour * 60 ) + $mins;
		// 		} else {
		// 			$total_mins = 1440;
		// 		}

		// 		GensetUtilizationFlatdata::create([
		// 			'unit_id'		=> $data['unit_id'] ,
		// 			'mins'			=> $total_mins , 
		// 			'fuel'			=> $data['fuel'] ,
		// 			'remarks'		=> $data['remarks'] ,
		// 			'kwh'			=> $data['kwh'],
		// 			'run_start'		=> $data['run_start'],
		// 			'run_stop'		=> $data['run_stop'],
		// 			'downtime_id'	=> $genset->id,					
		// 			'date'			=> $a->format('Y-m-d')
		// 		]);

		// 		$start_date->addDay();

		// 	}

		// } else {

		// 	$total_mins = $start_date->diffInMinutes($end_date);

		// 	DowntimeFlatData::create([
		// 		'unit_id'		=> $data['unit_id'] ,
		// 		'downtime_id'	=> $downtime->id ,
		// 		'mins'			=> $total_mins , 
		// 		'remarks'		=> $data['remarks'] ,
		// 		'is_scheduled'	=> $data['is_scheduled'],
		// 		'date'			=> $start_date->format('Y-m-d')
		// 	]);

		// }

		Session::flash('message', 'Genset has been addedd!!');

		return back();

	}


	public function editGenset($id, Request $request) {

		$genset = GensetUtilization::findOrFail($id);

		$units = Unit::all();

		return view('pages.genset.edit', compact('genset','units'));

	}

	public function updateGenset($id, Request $request) {

		$data = $request->validate([
			'unit_id' 		=> 'required',
			'start_date'	=> 'required|before_or_equal:end_date',
			'end_date'		=> 'required|after_or_equal:start_date',
			'remarks'		=> 'required',
			'fuel'			=> 'required',
			'kwh'			=> 'required',
		]);

		$genset = GensetUtilization::findOrFail($id);

		$existing_genset_runtime = GensetUtilization::where('unit_id', $data['unit_id'])
			->where(function($query) use ($data) {
				$query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
					->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
			})
			->first();

		if( $existing_genset_runtime && $existing_genset_runtime->id != $genset->id ) {
			Session::flash('error_message', 'Unit is already scheduled for the selected date.'); 
			return back();
		}

		// delete genset flatdata
		$genset_flatdata = GensetUtilizationFlatdata::where('downtime_id', $genset->id)
			->delete();

		$genset->update($data);

		$data['genset_id'] = $genset->id;
		$data['run_start'] = $genset->run_start;
		$data['run_stop']  = $genset->run_stop;
		$data['unit_id']   = $genset->unit_id;

		$this->createGensetFlatData($data);

		Session::flash('message', 'Genset schedule was successfully updated!');

		return back();


	}

	public function gensetReport(Request $request) {

		$rolesPermissions = $this->roleRightService->hasPermissions("Daily Utilization Report");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$displayDate            = [];
        $displayData            = [];
        $endDate                = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
        $startDate              = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();

        $genset_units = Unit::where('type', 'GENSET UNITS AND GENSET BREAKERS')->get();

        if( $startDate->diffInDays($endDate) > 0 ) {

        	while ($startDate->lte($endDate) ) {

        		$a = new Carbon($startDate);
        		
        		array_push($displayDate, $startDate->toFormattedDateString());

        		foreach( $genset_units as $unit ) {

        			$genset_util = GensetUtilizationFlatdata::where('unit_id', $unit->id)
        				->whereDate('date', $startDate)
        				->first();

        			if( $genset_util ) {

        				$data = [
        					'name'		=> $unit->name ,
        					'runtime'	=> number_format($genset_util->mins / 60, 2) ,
        					'fuel'		=> number_format($genset_util->fuel) ,
        					'kwh'		=> number_format($genset_util->kwh) ,
        					'reading'	=> number_format($genset_util->run_stop - $genset_util->run_start)
        				];

        				$displayData[$unit->name][] = $data; 

        			} else {

        				$data = [
        					'name'		=> $unit->name ,
        					'runtime'	=> number_format(0,2),
        					'fuel'		=> number_format(0,2) ,
        					'kwh'		=> number_format(0,2) ,
        					'reading'	=> number_format(0,2)
        				];

        				$displayData[$unit->name][] = $data; 

        			}

        		}

        		if( $startDate->eq($endDate) ) { 

        			array_push($displayDate, "TOTAL"); 

        			foreach( $displayData as $key => $data ) {

        				$total = [
	        				'runtime'	=> number_format(0,2) ,
	        				'fuel'		=> number_format(0,2) ,
	        				'kwh'		=> number_format(0,2) ,
	        				'reading'	=> number_format(0,2)
	        			];

        				foreach( $data as $display ) {

        					$total['runtime'] = number_format($total['runtime'] + $display['runtime'], 2);
        					$total['fuel'] = number_format($total['fuel'] + $display['fuel'], 2);
        					$total['kwh'] = number_format($total['kwh'] + $display['kwh'], 2);
        					$total['reading'] = number_format($total['reading'] + $display['reading'], 2);

        				}

        				$displayData[$key][] = $total;

        			}


        		}
        		
        		$startDate = $a->addDay();

        	}

        } else {

        	array_push($displayDate, $startDate->toFormattedDateString(), "TOTAL");

        	foreach( $genset_units as $unit ) {

    			$genset_util = GensetUtilizationFlatdata::where('unit_id', $unit->id)
    				->whereDate('date', $startDate)
    				->first();

    			if( $genset_util ) {

    				$data = [
    					'name'		=> $unit->name ,
    					'runtime'	=> number_format($genset_util->mins / 60, 2) ,
    					'fuel'		=> number_format($genset_util->fuel, 2 ) ,
    					'kwh'		=> number_format($genset_util->kwh, 2) ,
    					'reading'	=> number_format($genset_util->run_stop - $genset_util->run_start)
    				];

    				//array_push($displayData, $data);
    				$displayData[$unit->name][] = $data;
    			} else {

    				$data = [
    					'name'		=> $unit->name ,
    					'runtime'	=> number_format(0,2) ,
    					'fuel'		=> number_format(0,2) ,
    					'kwh'		=> number_format(0,2) ,
    					'reading'	=> number_format(0,2)
    				];

    				$displayData[$unit->name][] = $data;

    			}

    		}

    		foreach( $displayData as $key => $data ) {

				$total = [
					'runtime'	=> number_format(0,2) ,
					'fuel'		=> number_format(0,2) ,
					'kwh'		=> number_format(0,2) ,
					'reading'	=> number_format(0,2)
				];

				foreach( $data as $display ) {

					$total['runtime'] = number_format($total['runtime'] + $display['runtime'] , 2);
					$total['fuel'] = number_format($total['fuel'] + (float)$display['fuel'], 2);
					$total['kwh'] = number_format($total['kwh'] + (float)$display['kwh'], 2);
					$total['reading'] = number_format($total['reading'] + $display['reading'], 2);

				}

				$displayData[$key][] = $total;

			}

        }

		return view('pages.genset.rpt_genset_utilization', compact('displayDate','displayData','genset_units'));

	}

	public function createGensetFlatData($data) {

		$start_date = Carbon::parse($data['start_date']);
		$end_date	= Carbon::parse($data['end_date']);
		$time_diff = $start_date->diffInDays($end_date);

		if( $time_diff > 0 ) {

			while( $start_date->lte($end_date) ) {

				$a = new Carbon($start_date);
				$b = new Carbon($end_date);

				$Sday = $a->format('Y-m-d');
				$Eday = $b->format('Y-m-d');
				$hour = $a->hour;
				$mins = $a->minute;

				if( $Sday == $Eday ) {
					$total_mins = ( $hour * 60 ) + $mins;
				} else {
					$total_mins = 1440;
				}

				GensetUtilizationFlatdata::create([
					'unit_id'		=> $data['unit_id'] ,
					'mins'			=> $total_mins , 
					'fuel'			=> $data['fuel'] ,
					'remarks'		=> $data['remarks'] ,
					'kwh'			=> $data['kwh'],
					'run_start'		=> $data['run_start'],
					'run_stop'		=> $data['run_stop'],
					'downtime_id'	=> $data['genset_id'],					
					'date'			=> $a->format('Y-m-d')
				]);

				$start_date->addDay();

			}

		} else {

			$total_mins = $start_date->diffInMinutes($end_date);

			GensetUtilizationFlatdata::create([
				'unit_id'		=> $data['unit_id'] ,
				'downtime_id'	=> $data['genset_id'] ,
				'mins'			=> $total_mins , 
				'remarks'		=> $data['remarks'] ,
				'date'			=> $start_date->format('Y-m-d')
			]);

		}

		return true;

	}

	public function gensetList(Request $request) {

        $rolesPermissions = $this->roleRightService->hasPermissions("Download Raw Data");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		// $endDate        = $request->has('endDate') ? Carbon::parse($request->endDate) : Carbon::now();
  //       $startDate      = $request->has('startDate') ? Carbon::parse($request->startDate) : Carbon::now()->subMonth();
        $type           = $request->has('type') ? $request->type : 'weekly'; 
        $s_location     = $request->has('s_location') ? urldecode($request->s_location) : "null";
        $s_type         = $request->has('s_type') ? urldecode($request->s_type) : "null";
        $s_name         = $request->has('s_name') ? urldecode($request->s_name) : "null";
        //$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->isplanned) : "null";
        $x              = 0;

        $u_type         = Unit::all()->where('type','!=','')->groupBy('type');
        $u_location     = Unit::all()->where('location','!=','')->groupBy('location');
        $u_name         = Unit::distinct('name')->where('name', '!=','')->get();
        $downtime       = [];

        //if( $type != 'daily' ) { $startDate->startOfweek(Carbon::MONDAY); }

        if( $request->all() ) {

            $units = Unit::where('name','!=', '')
                ->where(function($query) use ($s_type) {
                    if($s_type != 'null') {
                        $query->where('type', $s_type);
                    }
                })->where(function($query) use ($s_name) {
                    if($s_name != 'null') {
                        $query->where('name', $s_name);
                    }
                })->where(function($query) use ($s_location) {
                    if($s_location != 'null') {
                        $query->where('location', $s_location);
                    }
                })
                ->get();

            foreach( $units as $unit ) {
                
                $data = GensetUtilization::where('unit_id', $unit->id)
                    // ->where(function($query) use ($startDate, $endDate){
                    //   $query->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    //         ->orWhereBetween('end_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]); 
                    // })
                    // ->where(function($query) use ($s_scheduled) {
                    //     if($s_scheduled != "3" && $s_scheduled != 'null') {
                    //         $query->where('is_scheduled', $s_scheduled);
                    //     }
                    // })
                    ->orderBy('start_date', 'DESC')
                    ->get();

                if( $data ) {
                    foreach( $data as $downtime1 ) {
                        $downtime[] = $downtime1;                    
                    }
                }

            }

        } else {
            $downtime = GensetUtilization::latest()->get();
        }

        $collection = collect($downtime);
        $page = $request->page ? $request->page : 1;
        $perPage = 30; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        $downtime = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => url('/genset-list')]
        );

        return view('pages.genset.genset_list', compact('downtime', 'u_name', 'u_type','u_location'));

	}

	public function deleteGenset($id) {

		$genset = GensetUtilization::findOrFail($id);

		$flat_data = GensetUtilizationFlatdata::where('downtime_id', $genset->id)->delete();

		$genset->delete();

		return 'record successfully deleted';

	}

}
