<?php

namespace App\Http\Controllers;

use Session;
use App\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{


	public function newAsset() {

		$assets = new Asset;

		$locations = $assets->locations();
		$conditions = $assets->conditions();
		$site_options = $assets->siteOptions();
		$statuses = $assets->statuses();

		return view('pages.asset.new', compact('locations', 'conditions', 'site_options', 'statuses'));

	}

	public function store(Request $request) {

		$validate = $request->validate([
			'tag'					=> 'required',
			'asset_type'			=> 'required',
			'description'			=> 'required',
			'manufacturer'			=> 'required',
			'model'					=> 'required',
			'serial'				=> 'required',
			'year_manufactured'		=> 'required',
			'commissioning_date'	=> 'required',
			'site'					=> 'required',
			'location'				=> 'required',
			'condition'				=> 'required',
			'status'				=> 'required'
		]);

		Asset::create([
			'tag'					=> $request->tag ,
			'asset_type'			=> $request->asset_type ,
			'description'			=> $request->description ,
			'manufacturer'			=> $request->manufacturer ,
			'model'					=> $request->model ,
			'serial'				=> $request->serial ,
			'year_manufactured'		=> $request->year_manufactured ,
			'commissioning_date'	=> $request->commissioning_date ,
			'site'					=> $request->site ,
			'location'				=> $request->location ,
			'condition'				=> $request->condition ,
			'status'				=> $request->status ,
			'vendor'				=> $request->vendor ,
			'po_reference'			=> $request->po_reference ,
			'po_value'				=> $request->po_value
		]);

		Session::flash('message', 'Asset has been Added!!');

		return back();


	}


	public function editAsset($id, Request $request) {

		$asset = Asset::findOrFail($id);

		$sites = Asset::all()->groupBy('site');

		$assets = new Asset;

		$locations = $assets->locations();
		$conditions = $assets->conditions();
		$site_options = $assets->siteOptions();
		$statuses = $assets->statuses();

		return view('pages.asset.edit', compact('asset', 'locations', 'conditions', 'site_options', 'statuses'));

	}


	public function updateAsset($id, Request $request) {

		$validate = $request->validate([
			'tag'					=> 'required',
			'asset_type'			=> 'required',
			'description'			=> 'required',
			'manufacturer'			=> 'required',
			'model'					=> 'required',
			'serial'				=> 'required',
			'year_manufactured'		=> 'required',
			'commissioning_date'	=> 'required',
			'site'					=> 'required',
			'location'				=> 'required',
			'condition'				=> 'required',
			'status'				=> 'required'
		]);
		
		$asset = Asset::findOrFail($id);

		$asset->update([
			'tag'					=> $request->tag ,
			'asset_type'			=> $request->asset_type ,
			'description'			=> $request->description ,
			'manufacturer'			=> $request->manufacturer ,
			'model'					=> $request->model ,
			'serial'				=> $request->serial ,
			'year_manufactured'		=> $request->year_manufactured ,
			'commissioning_date'	=> $request->commissioning_date ,
			'site'					=> $request->site ,
			'location'				=> $request->location ,
			'condition'				=> $request->condition ,
			'status'				=> $request->status ,
			'vendor'				=> $request->vendor ,
			'po_reference'			=> $request->po_reference ,
			'po_value'				=> $request->po_value
		]);

		Session::flash('message', 'Asset is successfully updated!!');

		return back();

	}


	public function deleteAsset($id) {

		$asset = Asset::findOrFail($id);

		$asset->delete();

		return 'Asset successfully deleted';


	}


}
