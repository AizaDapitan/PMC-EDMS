<?php

namespace App\Http\Controllers;

use Session;
use App\Unit;
use Illuminate\Http\Request;
use App\Services\RoleRightService;

class UnitsController extends Controller
{
	public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
	public function store (Request $request) 
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Unit");
        if (!$rolesPermissions['create']) {
            abort(401);
        }
		$validate = $request->validate([
			'name'			=> 'required' ,
			'type'			=> 'required' ,
			'location'		=> 'required'
		]);

		Unit::create($validate);

		Session::flash('message', 'Unit has been added!!'); 

		return back();
		
	}


	public function editUnit($id) {

		$rolesPermissions = $this->roleRightService->hasPermissions("Units");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
		$edit = $rolesPermissions['edit'];
		$unit_selected = Unit::findOrFail($id);

		$units = Unit::all();

		return view('pages.unit.edit', compact('unit_selected','units','edit'));

	}


	public function updateUnit($id, Request $request) {

		$validate = $request->validate([
			'name'			=> 'required' ,
			'type'			=> 'required' ,
			'location'		=> 'required'
		]);

		$unit = Unit::findOrFail($id);

		$unit->update($validate);

		Session::flash('message', 'Unit has been updated!!'); 

		return back();

	} 
	


}
