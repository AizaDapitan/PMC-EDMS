<?php

namespace App\Http\Controllers;

use Session;
use App\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{

	public function store (Request $request) 
	{

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

		$unit_selected = Unit::findOrFail($id);

		$units = Unit::all();

		return view('pages.unit.edit', compact('unit_selected','units'));

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
