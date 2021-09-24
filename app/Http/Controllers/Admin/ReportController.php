<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \OwenIt\Auditing\Models\Audit;
use App\Services\ReportService;
use App\Services\UserService;
use App\Services\RoleRightService;
use App\Log;

class ReportController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService,
        ReportService $reportService,
        UserService $userService
    ) {
        $this->reportService = $reportService;
        $this->roleRightService = $roleRightService;
        $this->userService = $userService;
    }
    public function auditLogs(Request $request)
    {
        $dateFrom = now()->toDateString();
        $dateTo = now()->toDateString();
        $userid = 0;
        if (isset($request->dateFrom)) {
            $dateFrom = $request->dateFrom;
        }
        if (isset($request->dateTo)) {
            $dateTo = $request->dateTo;
        }
        if (isset($request->userid)) {
            $userid = $request->userid;
        }
        $rolesPermissions = $this->roleRightService->hasPermissions("Audit Logs");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $users =  $this->userService->all()->where('active', '1')->where('username', '<>', '')->sortBy('name');


        $audits =Audit::when(isset($dateTo), function($q) use($dateFrom, $dateTo){
            $q->whereBetween('created_at',  [$dateFrom.' 00:00:00', $dateTo.' 23:59:59']);
        })
       ->when(!isset($dateTo), function($q) use($dateFrom){
            $q->whereDate('created_at', $dateFrom);
        })
        ->when($userid != 0, function($q) use($userid){
            $q->where('user_id', $userid);
        })->get();

        $saveLogs = $this->reportService->create("Audit Logs", $request);
        return view('admin.reports.audits', [
            'audits' => $audits,
            'users' => $users
        ]);
    }
     public function errorLogs(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Error Logs");
        $dateFrom = now()->toDateString();
        $dateTo = now()->toDateString();
        if (isset($request->dateFrom)) {
            $dateFrom = $request->dateFrom;
        }
        if (isset($request->dateTo)) {
            $dateTo = $request->dateTo;
        }

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $errors = Log::when(isset($dateTo), function($q) use($dateFrom, $dateTo){
            $q->whereBetween('created_at', [$dateFrom.' 00:00:00', $dateTo.' 23:59:59']);
        })
       ->when(!isset($dateTo), function($q) use($dateFrom){
            $q->whereDate('created_at', $dateFrom);
        })
        ->get();
        $saveLogs = $this->reportService->create("Error Logs", $request);;
        return view('admin.reports.error', ['errors' => $errors]);
    }
}
