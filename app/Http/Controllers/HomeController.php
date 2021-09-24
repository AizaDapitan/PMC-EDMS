<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Asset;
use App\Downtime;
use Carbon\Carbon;
use App\DowntimeFlatData;
use App\GensetUtilization;
use Illuminate\Http\Request;
use App\GensetUtilizationFlatdata;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use App\Services\RoleRightService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Dashboard");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $rolesPermissionsDowntime = $this->roleRightService->hasPermissions("Downtime");

        $deleteDowntime = $rolesPermissionsDowntime['delete'];
        $editDowntime = $rolesPermissionsDowntime['edit'];
        $createDowntime = $rolesPermissionsDowntime['create'];

        $rolesPermissionsUnit = $this->roleRightService->hasPermissions("Units");
        
        $createUnit = $rolesPermissionsUnit['create'];

        $displayDate    = [];
        $displayData    = [];
        $endDate        = $request->has('endDate') ? Carbon::parse($request->endDate) : Carbon::now();
        $startDate      = $request->has('startDate') ? Carbon::parse($request->startDate) : Carbon::now()->subMonth();
        $type           = $request->has('type') ? $request->type : 'weekly';
        $s_location     = $request->has('s_location') ? urldecode($request->s_location) : "null";
        $s_type         = $request->has('s_type') ? urldecode($request->s_type) : "null";
        $s_name         = $request->has('s_name') ? urldecode($request->s_name) : "null";
        $x              = 0;
        $downtime       = Downtime::latest()->limit(10)->get();

        $u_type = Unit::all()->where('type', '!=', '')->groupBy('type');
        $u_location = Unit::all()->where('location', '!=', '')->groupBy('location');
        $u_name = Unit::distinct('name')->where('name', '!=', '')->get();

        $u_type_downtime_total = [];

        if ($type != 'daily') {
            $startDate->startOfweek(Carbon::MONDAY);
        }

        while (Carbon::parse($startDate)->lte($endDate)) {

            $a = new Carbon($startDate);
            $b = new Carbon($a);

            if ($type == 'daily') {

                $d = [
                    'start' => $a->format('M d'),
                    'end'   => $a->format('M d')
                ];

                $startDate->addDay();

                array_push($displayDate, $d);
            } elseif ($type == 'weekly') {

                if ($x == 0) {
                    $d = [
                        'start' => $a->format('M d'),
                        'end'   => $b->addWeek(1)->subDay()->format('M d')
                    ];
                } else {
                    $d = [
                        'start' => $a->format('M d'),
                        'end'   => $b->addWeek(1)->subDay()->format('M d')
                    ];
                }

                array_push($displayDate, $d);

                $startDate->addWeek();
            } else {

                $d = [
                    'start' => $a->format('M d'),
                    'end'   => $a->endOfMonth()->format('M d')
                ];

                array_push($displayDate, $d);

                $startDate = $a->endOfMonth()->addDay();
            }

            $x++;
        }

        foreach ($u_type as $key => $type1) {
            $u_type_downtime_total[$key] = 0;
        }

        $units = Unit::where('name', '!=', '')
            ->where(function ($query) use ($s_type) {
                if ($s_type != 'null') {
                    $query->where('type', $s_type);
                }
            })->where(function ($query) use ($s_name) {
                if ($s_name != 'null') {
                    $query->where('name', $s_name);
                }
            })->where(function ($query) use ($s_location) {
                if ($s_location != 'null') {
                    $query->where('location', $s_location);
                }
            })
            ->get();

        foreach ($units as $unit) {

            $data = [
                'unit'  => $unit->id,
                'downtime_data' => [],
            ];

            $total__time = 0;

            foreach ($displayDate as $key => $range_date) {

                $start_date = Carbon::parse($range_date['start']);
                $end_date = Carbon::parse($range_date['end']);
                $remarks = "";

                $flat_data = DowntimeFlatData::where('unit_id', $unit->id)
                    ->whereBetween('date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
                    ->get();

                $total_time = $flat_data->sum('mins');

                // dd($flat_data->downtime())
                // $d_time = Downtime::where('unit_id', $unit->id)
                //     ->where(function($query) use ($range_date) {
                //         $query->whereDate('start_date', "<=", Carbon::parse($range_date['start'])->format('Y-m-d'))
                //             ->orWhereDate('end_date', ">=", Carbon::parse($range_date['end'])->format('Y-m-d'));
                //     })
                //     ->get();

                if (count($flat_data)) {
                    $x = 0;
                    $d_ids = [];
                    foreach ($flat_data as $d) {
                        if (!in_array($d->downtime_id, $d_ids)) {
                            if (count($flat_data) < $x) {
                                $remarks .= $d->downtime->remarks . " | ";
                            } else {
                                $remarks .= $d->remarks . " ";
                            }
                            array_push($d_ids, $d->downtime_id);
                        }
                        $x++;
                    }
                }

                array_push($data['downtime_data'], [
                    'start_date'    => $start_date->format('Y-m-d'),
                    'end_date'      => $end_date->format('Y-m-d'),
                    'downtime'      => $total_time,
                    'total_time'    => $start_date->diffInMinutes($end_date->addDay()),
                    'remarks'       => $remarks
                ]);

                $total__time = $total__time + $total_time;
            }

            $u_type_downtime_total[$unit->type] = $u_type_downtime_total[$unit->type] + $total__time;

            array_push($displayData, $data);
        }

        // foreach( $u_type as $key => $type ) {

        //     $total_type_downtime = 0;

        //     foreach ($type as $value) {

        //         $unit_downtime = DowntimeFlatData::where('unit_id', $value->id)
        //             ->whereBetween('date'  , [Carbon::parse($request->startDate)->startOfweek(Carbon::MONDAY)->format('Y-m-d'), 
        //                 Carbon::parse($request->endDate)->format('Y-m-d')])
        //             ->sum('mins');

        //         $total_type_downtime = $total_type_downtime + $unit_downtime;

        //     }

        //     $u_type_downtime_total[$key] = $total_type_downtime;

        // }

        return view('dashboard', compact(
            'units',
            'displayDate',
            'displayData',
            'downtime',
            'u_name',
            'u_type',
            'u_location',
            'u_type_downtime_total',
            'deleteDowntime',
            'editDowntime',
            'createDowntime',
            'createUnit'
        ));
    }


    public function downtimeList(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Downtime List");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        $delete = $rolesPermissions['delete'];

        // Scheduled = 1 // Unscheduled = 0 // Grid Outgage = 2
        // $endDate        = $request->has('endDate') ? Carbon::parse($request->endDate) : Carbon::now();
        // $startDate      = $request->has('startDate') ? Carbon::parse($request->startDate) : Carbon::now()->subMonth();
        $type           = $request->has('type') ? $request->type : 'weekly';
        $s_location     = $request->has('s_location') ? urldecode($request->s_location) : "null";
        $s_type         = $request->has('s_type') ? urldecode($request->s_type) : "null";
        $s_name         = $request->has('s_name') ? urldecode($request->s_name) : "null";
        $s_scheduled    = $request->has('isplanned') ? urldecode($request->isplanned) : "null";
        $x              = 0;

        $u_type         = Unit::all()->where('type', '!=', '')->groupBy('type');
        $u_location     = Unit::all()->where('location', '!=', '')->groupBy('location');
        $u_name         = Unit::distinct('name')->where('name', '!=', '')->get();
        $downtime       = [];

        //if( $type != 'daily' ) { $startDate->startOfweek(Carbon::MONDAY); }

        if ($request->all()) {

            $units = Unit::where('name', '!=', '')
                ->where(function ($query) use ($s_type) {
                    if ($s_type != 'null') {
                        $query->where('type', $s_type);
                    }
                })->where(function ($query) use ($s_name) {
                    if ($s_name != 'null') {
                        $query->where('name', $s_name);
                    }
                })->where(function ($query) use ($s_location) {
                    if ($s_location != 'null') {
                        $query->where('location', $s_location);
                    }
                })
                ->get();

            foreach ($units as $unit) {

                $data = $unit->downtime()
                    // ->where(function($query) use ($startDate, $endDate){
                    //   $query->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    //         ->orWhereBetween('end_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]); 
                    // })
                    ->where(function ($query) use ($s_scheduled) {
                        if ($s_scheduled != "3" && $s_scheduled != 'null') {
                            $query->where('is_scheduled', $s_scheduled);
                        }
                    })
                    ->orderBy('start_date', 'DESC')
                    ->get();

                if ($data) {
                    foreach ($data as $downtime1) {
                        $downtime[] = $downtime1;
                    }
                }
            }
        } else {
            $downtime = Downtime::latest()->get();
        }

        return view('pages.downlist', compact(
            'downtime',
            'u_name',
            'u_type',
            'u_location',
            'create',
            'edit',
            'search',
            'print',
            'delete'
        ));
    }


    public function genset(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Genset Units");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $rolesPermissionsUnit = $this->roleRightService->hasPermissions("Units");
        
        $createUnit = $rolesPermissionsUnit['create'];

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        $delete = $rolesPermissions['delete'];


        $rolesPermissionsRuntime = $this->roleRightService->hasPermissions("Add Genset Run Time");
        $createRuntime = $rolesPermissionsRuntime['create'];


        $displayDate            = [];
        $displayData            = [];
        $endDate                = $request->has('endDate') ? Carbon::parse($request->endDate) : Carbon::now();
        $startDate              = $request->has('startDate') ? Carbon::parse($request->startDate) : Carbon::now()->subMonth();
        $type                   = $request->has('type') ? $request->type : 'weekly';
        $s_location             = $request->has('s_location') ? urldecode($request->s_location) : "null";
        $s_type                 = $request->has('s_type') ? urldecode($request->s_type) : "null";
        $s_name                 = $request->has('s_name') ? urldecode($request->s_name) : "null";
        $x                      = 0;
        $gensets                = GensetUtilization::latest()->limit(10)->get();

        //$u_type = Unit::all()->where('type','!=','')->groupBy('type');
        $u_location = Unit::all()->where('location', '!=', '')->where('type', 'GENSET UNITS AND GENSET BREAKERS')->groupBy('location');
        $u_name = Unit::distinct('name')->where('name', '!=', '')
            ->where('type', 'GENSET UNITS AND GENSET BREAKERS')->get();

        $u_type_genset_total = [];

        if ($type != 'daily') {
            $startDate->startOfweek(Carbon::MONDAY);
        }

        while (Carbon::parse($startDate)->lte($endDate)) {

            $a = new Carbon($startDate);
            $b = new Carbon($a);

            if ($type == 'daily') {

                $d = [
                    'start' => $a->toFormattedDateString(),
                    'end'   => $a->toFormattedDateString()
                ];

                $startDate->addDay();

                array_push($displayDate, $d);
            } elseif ($type == 'weekly') {

                if ($x == 0) {
                    $d = [
                        'start' => $a->toFormattedDateString(),
                        'end'   => $b->addWeek(1)->subDay()->toFormattedDateString()
                    ];
                } else {
                    $d = [
                        'start' => $a->toFormattedDateString(),
                        'end'   => $b->addWeek(1)->subDay()->toFormattedDateString()
                    ];
                }

                array_push($displayDate, $d);

                $startDate->addWeek();
            } else {

                $d = [
                    'start' => $a->toFormattedDateString(),
                    'end'   => $a->endOfMonth()->toFormattedDateString()
                ];

                array_push($displayDate, $d);

                $startDate = $a->endOfMonth()->addDay();
            }

            $x++;
        }

        $units = Unit::where('name', '!=', '')
            ->where('type', 'GENSET UNITS AND GENSET BREAKERS')
            ->where(function ($query) use ($s_name) {
                if ($s_name != 'null') {
                    $query->where('name', $s_name);
                }
            })->where(function ($query) use ($s_location) {
                if ($s_location != 'null') {
                    $query->where('location', $s_location);
                }
            })
            ->get();

        foreach ($units as $unit) {

            $data = [
                'unit'  => $unit->id,
                'genset_data' => [],
            ];

            $total__time = 0;

            foreach ($displayDate as $key => $range_date) {

                $start_date = Carbon::parse($range_date['start']);
                $end_date = Carbon::parse($range_date['end']);
                $remarks = "";

                // if( $type == 'daily' ) {
                //     $total_time = GensetUtilizationFlatdata::where('unit_id', $unit->id)
                //         ->whereDate('date','=',$start_date->format('Y-m-d'))
                //         ->sum('mins');                    
                // } else {

                $flat_data = GensetUtilizationFlatdata::where('unit_id', $unit->id)
                    ->whereBetween('date', [$start_date->format('Y-m-d'), $end_date->format('Y-m-d')])
                    ->get();

                $total_time = $flat_data->sum('mins');

                // dd($flat_data->downtime())
                // $d_time = Downtime::where('unit_id', $unit->id)
                //     ->where(function($query) use ($range_date) {
                //         $query->whereDate('start_date', "<=", Carbon::parse($range_date['start'])->format('Y-m-d'))
                //             ->orWhereDate('end_date', ">=", Carbon::parse($range_date['end'])->format('Y-m-d'));
                //     })
                //     ->get();

                if (count($flat_data)) {
                    $x = 0;
                    $d_ids = [];
                    foreach ($flat_data as $d) {
                        if (!in_array($d->genset_id, $d_ids)) {
                            if (count($flat_data) < $x) {
                                $remarks .= $d->genset->remarks . " | ";
                            } else {
                                $remarks .= $d->remarks . " ";
                            }
                            array_push($d_ids, $d->genset_id);
                        }
                        $x++;
                    }
                }

                array_push($data['genset_data'], [
                    'start_date'    => $start_date->format('Y-m-d'),
                    'end_date'      => $end_date->format('Y-m-d'),
                    'runtime'       => $total_time,
                    'total_time'    => $start_date->diffInMinutes($end_date->addDay()),
                    'remarks'       => $remarks
                ]);
            }

            array_push($displayData, $data);
        }

        return view('pages.genset', compact(
            'gensets',
            'displayDate',
            'displayData',
            'units',
            'u_name',
            'u_location',
            'create',
            'edit',
            'search',
            'print',
            'delete',
            'createRuntime',
            'createUnit'
        ));
    }


    public function assets(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Assets");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];


        $asset = new Asset;
        $locations = $asset->locations();
        $conditions = $asset->conditions();
        $site_options = $asset->siteOptions();
        $statuses = $asset->statuses();
        $asset_types = Asset::all()->groupBy('asset_type');

        //$assets = Asset::latest()->get();

        $assets = Asset::where(function ($query) use ($request) {
            if (!is_null($request->asset_type)) {
                $query->where('asset_type', $request->asset_type);
            }
        })->where(function ($query) use ($request) {
            if (!is_null($request->site)) {
                $query->where('site', $request->site);
            }
        })->where(function ($query) use ($request) {
            if (!is_null($request->location)) {
                $query->where('location', $request->location);
            }
        })->where(function ($query) use ($request) {
            if (!is_null($request->condition)) {
                $query->where('condition', $request->condition);
            }
        })->where(function ($query) use ($request) {
            if (!is_null($request->status)) {
                $query->where('status', $request->status);
            }
        })
            ->orderBy('id', 'DESC')
            ->get();


        return view('pages.assets', compact(
            'assets',
            'locations',
            'conditions',
            'site_options',
            'statuses',
            'asset_types',
            'create',
            'edit',
            'delete'
        ));
    }


    public function updatePassword(Request $request)
    {

        $user = \Auth::user();
        $hasher = app('hash');

        $validate = $request->validate([
            'current_password'      => 'required',
            'new_password'          => [
                'required', 'string', 'min:8', 'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&._]/'
            ],
            'new_confirm_password'  => 'same:new_password'
        ]);

        if ($hasher->check($request->current_password, $user->password)) {

            $user->update([
                'password'  => Hash::make($request->new_password)
            ]);

            \Auth::logout();
            return redirect('/login');
        }

        \Session::flash('error_message', 'Something is wrong while trying to change the password');

        return back();
    }
}
