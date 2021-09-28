<?php

namespace App\Http\Controllers;

use Session;
use App\Unit;
use App\Downtime;
use Carbon\Carbon;
use App\DowntimeFlatData;
use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Services\RoleRightService;

class DowntimeController extends Controller
{
	public function __construct(
		RoleRightService $roleRightService,
		ReportService $reportService
	) {
		$this->reportService = $reportService;
		$this->roleRightService = $roleRightService;
	}
	public function store(Request $request)
	{

		$rolesPermissions = $this->roleRightService->hasPermissions("Downtime List");
        if (!$rolesPermissions['create']) {
            abort(401);
        }
		$data = [
			'unit_id' 		=> $request->unit,
			'added_by'		=> \Auth::user()->name,
			'remarks'		=> $request->remarks,
			'is_scheduled'	=> $request->isscheduled,
			'start_date'	=> $request->startd,
			'end_date'		=> $request->endd
		];

		$existing_downtime = Downtime::where('unit_id', $data['unit_id'])
			->where(function ($query) use ($data) {
				$query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
					->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
			})
			->first();

		if ($existing_downtime) {
			Session::flash('error_message', 'Unit is already scheduled for the selected date.');
			return back();
		}

		$downtime = Downtime::create($data);

		$data['downtime_id'] = $downtime->id;

		$this->generateDowntimeFlatdata($data);
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

		// 		DowntimeFlatData::create([
		// 			'unit_id'		=> $data['unit_id'] ,
		// 			'downtime_id'	=> $downtime->id ,
		// 			'mins'			=> $total_mins , 
		// 			'remarks'		=> $data['remarks'] ,
		// 			'is_scheduled'	=> $data['is_scheduled'],
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

		Session::flash('message', 'Downtime has been added!!');

		return back();
	}


	public function editDowntime($id)
	{

        $rolesPermissions = $this->roleRightService->hasPermissions("Downtime");
        if (!$rolesPermissions['edit']) {
            abort(401);
        }
		$downtime = Downtime::findOrFail($id);

		$units = Unit::all();

		return view('pages.downtime.edit', compact('downtime', 'units'));
	}


	public function updateDowntime($id, Request $request)
	{

		$downtime = Downtime::findOrFail($id);

		$request->validate([
			'unit_id'		=> 'required',
			'remarks'		=> 'required',
			'startd'		=> 'required|date|before_or_equal:endd',
			'endd'			=> 'required|date|after_or_equal:startd'
		]);

		$data = [
			'unit_id' 		=> $request->unit_id,
			'remarks'		=> $request->remarks,
			'start_date'	=> $request->startd,
			'end_date'		=> $request->endd
		];


		// check if there is scheduled down on the selected date
		$existing_downtime = Downtime::where('unit_id', $data['unit_id'])
			->where(function ($query) use ($data) {
				$query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
					->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
			})
			->first();

		if ($existing_downtime && $existing_downtime->id != $downtime->id) {
			Session::flash('error_message', 'Unit is already scheduled for the selected date.');
			return back();
		}

		$downtime_flatdata = DowntimeFlatData::where('downtime_id', $downtime->id)
			->delete();

		$downtime->update($data);

		$data['downtime_id'] = $downtime->id;
		$data['is_scheduled'] = $downtime->is_scheduled;
		$data['unit_id']	= $downtime->unit_id;

		$this->generateDowntimeFlatdata($data);

		Session::flash('message', 'Downtime has been updated!!');

		return back();
	}


	public function downtimeReport(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Input List");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$downtime = Downtime::latest()->limit(20)->get();

		$saveLogs = $this->reportService->create("Input List", $request);
		return view('pages.downtime.report', compact('downtime'));
	}

	public function generateDowntimeFlatdata($data)
	{

		$start_date = Carbon::parse($data['start_date']);
		$end_date	= Carbon::parse($data['end_date']);
		$time_diff = $start_date->diffInDays($end_date);

		if ($time_diff > 0) {

			while ($start_date->lte($end_date)) {

				$a = new Carbon($start_date);
				$b = new Carbon($end_date);

				$Sday = $a->format('Y-m-d');
				$Eday = $b->format('Y-m-d');
				$hour = $a->hour;
				$mins = $a->minute;

				if ($Sday == $Eday) {
					$total_mins = ($hour * 60) + $mins;
				} else {
					$total_mins = 1440;
				}

				DowntimeFlatData::create([
					'unit_id'		=> $data['unit_id'],
					'downtime_id'	=> $data['downtime_id'],
					'mins'			=> $total_mins,
					'remarks'		=> $data['remarks'],
					'is_scheduled'	=> $data['is_scheduled'],
					'date'			=> $a->format('Y-m-d')
				]);

				$start_date->addDay();
			}
		} else {

			$total_mins = $start_date->diffInMinutes($end_date);

			DowntimeFlatData::create([
				'unit_id'		=> $data['unit_id'],
				'downtime_id'	=> $data['downtime_id'],
				'mins'			=> $total_mins,
				'remarks'		=> $data['remarks'],
				'is_scheduled'	=> $data['is_scheduled'],
				'date'			=> $start_date->format('Y-m-d')
			]);
		}

		return true;
	}


	public function downtimeReportFlatdata(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Downtime Report");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$endDate        = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
		$startDate      = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();
		$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->is_scheduled) : "null";

		$units = Unit::where('name', '!=', '')->get();

		$displayData = [];

		foreach ($units as $unit) {

			$sum = DowntimeFlatData::where('unit_id', $unit->id)
				->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
				->where(function ($query) use ($s_scheduled) {
					if ($s_scheduled != "3" && $s_scheduled != 'null') {
						$query->where('is_scheduled', $s_scheduled);
					}
				})
				->sum('mins');

			if ($sum > 0) {

				if ($startDate->diffInMinutes($endDate) == 0) {
					$t_mins = 1440;
				} else {
					$t_mins = $startDate->diffInMinutes($endDate);
				}
				$displayData[$unit->name] = [
					'unit' 				=> $unit->name,
					'mins'				=> $sum,
					'availability'		=> ($sum / $t_mins) * 100
				];
			}
		}

		$saveLogs = $this->reportService->create("Downtime Report", $request);
		return view('pages.downtime.rpt_flatdata', compact('displayData'));
	}


	public function downtimeReportFlatdataPrint(Request $request)
	{

		$endDate        = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
		$startDate      = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();
		$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->is_scheduled) : "null";

		$units = Unit::where('name', '!=', '')->get();

		$displayData = [];

		foreach ($units as $unit) {

			$sum = DowntimeFlatData::where('unit_id', $unit->id)
				->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
				->where(function ($query) use ($s_scheduled) {
					if ($s_scheduled != "3" && $s_scheduled != 'null') {
						$query->where('is_scheduled', $s_scheduled);
					}
				})
				->sum('mins');

			if ($sum > 0) {
				if ($startDate->diffInMinutes($endDate) == 0) {
					$t_mins = 1440;
				} else {
					$t_mins = $startDate->diffInMinutes($endDate);
				}
				$displayData[$unit->name] = [
					'unit' 				=> $unit->name,
					'mins'				=> $sum,
					'availability'		=> ($sum / $t_mins) * 100
				];
			}
		}

		$saveLogs = $this->reportService->create("Downtime Report Print", $request);
		return view('pages.downtime.rpt_flatdata_print', compact('displayData'));
	}


	public function downtimeReportChart(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Chart Report");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$endDate        = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
		$startDate      = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();
		$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->is_scheduled) : "null";

		$units = Unit::where('name', '!=', '')->get();

		$displayData = [];
		$d = [];
		$hasDowntime = false;

		$total_downtime = DowntimeFlatData::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
			->sum('mins');

		$commulative_mins = 0;
		$commulative_percentage = 0;
		foreach ($units as $unit) {

			$sum = DowntimeFlatData::where('unit_id', $unit->id)
				->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
				->where(function ($query) use ($s_scheduled) {
					if ($s_scheduled != "3" && $s_scheduled != 'null') {
						$query->where('is_scheduled', $s_scheduled);
					}
				})
				->sum('mins');

			if ($sum > 0) {

				$commulative_data = $sum + $commulative_mins;

				$displayData[$unit->name] = [
					'unit' 				=> $unit->name,
					'mins'				=> $sum,
					'downtime'			=> $commulative_data,
					'percentage'		=> number_format(($commulative_data / $total_downtime) * 100, 2) . '%'
				];

				$commulative_mins = $commulative_data;
				$hasDowntime = true;
			} else {

				$d[$unit->name] = [
					'unit' 				=> $unit->name,
					'mins'				=> '-',
					'downtime'			=> '-'
				];
			}
		}

		if ($hasDowntime) {
			$displayData = array_merge($displayData, $d);
		} else {
			$displayData = [];
		}

		$saveLogs = $this->reportService->create("Chart Report", $request);
		return view('pages.downtime.rpt_chart', compact('displayData'));
	}

	public function downtimeReportChartPrint(Request $request)
	{

		$endDate        = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
		$startDate      = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();
		$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->is_scheduled) : "null";

		$units = Unit::where('name', '!=', '')->get();

		$displayData = [];
		$d = [];
		$hasDowntime = false;

		$total_downtime = DowntimeFlatData::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
			->sum('mins');

		$commulative_mins = 0;
		$commulative_percentage = 0;
		foreach ($units as $unit) {

			$sum = DowntimeFlatData::where('unit_id', $unit->id)
				->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
				->where(function ($query) use ($s_scheduled) {
					if ($s_scheduled != "3" && $s_scheduled != 'null') {
						$query->where('is_scheduled', $s_scheduled);
					}
				})
				->sum('mins');

			if ($sum > 0) {

				$commulative_data = $sum + $commulative_mins;

				$displayData[$unit->name] = [
					'unit' 				=> $unit->name,
					'mins'				=> $sum,
					'downtime'			=> $commulative_data,
					'percentage'		=> number_format(($commulative_data / $total_downtime) * 100, 2) . '%'
				];

				$commulative_mins = $commulative_data;
				$hasDowntime = true;
			} else {

				$d[$unit->name] = [
					'unit' 				=> $unit->name,
					'mins'				=> '-',
					'downtime'			=> '-'
				];
			}
		}

		if ($hasDowntime) {
			$displayData = array_merge($displayData, $d);
		} else {
			$displayData = [];
		}

		$saveLogs = $this->reportService->create("Chart Report Print", $request);
		return view('pages.downtime.rpt_chart_print', compact('displayData'));
	}


	public function downtimeReportMasterlist(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Equipment Master List");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$locations = Unit::all()->where('name', '!=', '')->groupBy('location');
		$types = Unit::all()->where('name', '!=', '')->groupBy('type');

		$s_type = $request->has('type') ? $request->type : 'null';
		$s_location = $request->has('location') ? $request->location : 'null';

		$units = Unit::where('name', '!=', '')
			->where(function ($query) use ($s_type) {
				if (!is_null($s_type)) {
					$query->where('type', $s_type);
				}
			})
			->where(function ($query) use ($s_location) {
				if (!is_null($s_location)) {
					$query->where('location', $s_location);
				}
			})
			->get();

		$saveLogs = $this->reportService->create("Equipment Master List", $request);
		return view('pages.downtime.rpt_masterlist', compact('locations', 'types', 'units'));
	}

	public function downtimeReportMasterlistPrint(Request $request)
	{

		$locations = Unit::all()->where('name', '!=', '')->groupBy('location');
		$types = Unit::all()->where('name', '!=', '')->groupBy('type');

		$s_type = $request->has('type') ? $request->type : 'null';
		$s_location = $request->has('location') ? $request->location : 'null';

		$units = Unit::where('name', '!=', '')
			->where(function ($query) use ($s_type) {
				if (!is_null($s_type)) {
					$query->where('type', $s_type);
				}
			})
			->where(function ($query) use ($s_location) {
				if (!is_null($s_location)) {
					$query->where('location', $s_location);
				}
			})
			->get();

		$saveLogs = $this->reportService->create("Equipment Master List Print", $request);
		return view('pages.downtime.rpt_masterlist_print', compact('locations', 'types', 'units'));
	}

	public function downtimeReportRawData(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Raw Data");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$downtime = Downtime::latest()->get();

		$saveLogs = $this->reportService->create("Raw Data", $request);
		return view('pages.downtime.rpt_rawdata', compact('downtime'));
	}

	public function downtimeReportRawDataPrint(Request $request)
	{

		$downtime = Downtime::latest()->get();

		$saveLogs = $this->reportService->create("Raw Data Print", $request);
		return view('pages.downtime.rpt_rawdata_print', compact('downtime'));
	}

	public function downtimeReportDaily(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Daily Up-Time Report");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$endDate        = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
		$startDate      = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();
		$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->is_scheduled) : "null";
		$displayDate    = [];
		$displayData    = [];

		$units = Unit::latest()->where('name', '!=', '')->get();

		if ($startDate->diffInDays($endDate) > 0) {

			while ($startDate->lte($endDate)) {

				$a = new Carbon($startDate);

				array_push($displayDate, $startDate->toFormattedDateString());

				foreach ($units as $unit) {

					$sum = DowntimeFlatData::where('unit_id', $unit->id)
						->whereDate('date', $startDate)
						->sum('mins');

					if ($sum > 0) {

						$data = [
							'name'		=> $unit->name,
							'type'		=> $unit->type,
							'mins'		=> $sum
						];

						$displayData[$unit->name][] = $data;
					} else {

						$data = [
							'name'		=> $unit->name,
							'type'		=> $unit->type,
							'mins'		=> number_format(0, 2)
						];

						$displayData[$unit->name][] = $data;
					}
				}

				$startDate = $a->addDay();
			}
		} else {

			array_push($displayDate, $startDate->toFormattedDateString());

			foreach ($units as $unit) {

				$sum = DowntimeFlatData::where('unit_id', $unit->id)
					->whereDate('date', $startDate)
					->sum('mins');

				$data = [
					'name'		=> $unit->name,
					'type'		=> $unit->type,
					'mins'		=> number_format(0, 2)
				];

				$displayData[$unit->name][] = $data;
			}
		}

		$saveLogs = $this->reportService->create("Daily Up-Time Report", $request);
		return view('pages.downtime.rpt_daily', compact('displayData', 'displayDate'));
	}

	public function downtimeReportDailyPrint(Request $request)
	{

		$endDate        = $request->has('enddate') ? Carbon::parse($request->enddate) : Carbon::now();
		$startDate      = $request->has('startdate') ? Carbon::parse($request->startdate) : Carbon::now();
		$s_scheduled    = $request->has('is_scheduled') ? urldecode($request->is_scheduled) : "null";
		$displayDate    = [];
		$displayData    = [];

		$units = Unit::latest()->where('name', '!=', '')->get();

		if ($startDate->diffInDays($endDate) > 0) {

			while ($startDate->lte($endDate)) {

				$a = new Carbon($startDate);

				array_push($displayDate, $startDate->toFormattedDateString());

				foreach ($units as $unit) {

					$sum = DowntimeFlatData::where('unit_id', $unit->id)
						->whereDate('date', $startDate)
						->sum('mins');

					if ($sum > 0) {

						$data = [
							'name'		=> $unit->name,
							'type'		=> $unit->type,
							'mins'		=> $sum
						];

						$displayData[$unit->name][] = $data;
					} else {

						$data = [
							'name'		=> $unit->name,
							'type'		=> $unit->type,
							'mins'		=> number_format(0, 2)
						];

						$displayData[$unit->name][] = $data;
					}
				}

				$startDate = $a->addDay();
			}
		} else {

			array_push($displayDate, $startDate->toFormattedDateString());

			foreach ($units as $unit) {

				$sum = DowntimeFlatData::where('unit_id', $unit->id)
					->whereDate('date', $startDate)
					->sum('mins');

				$data = [
					'name'		=> $unit->name,
					'type'		=> $unit->type,
					'mins'		=> number_format(0, 2)
				];

				$displayData[$unit->name][] = $data;
			}
		}

		$saveLogs = $this->reportService->create("Daily Up-Time Report Print", $request);
		return view('pages.downtime.rpt_daily_print', compact('displayData', 'displayDate'));
	}

	public function deleteDowntime($id)
	{

		$downtime = Downtime::findOrFail($id);

		$downtime->downtime_flat()->delete();

		$downtime->delete();
		
		// return redirect()->back()->with('success', 'Record successfully deleted!');
		Session::flash('message', 'Record successfully deleted!!');
		return 'record successfully deleted';
	}
}
