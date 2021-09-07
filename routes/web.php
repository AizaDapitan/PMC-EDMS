<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(\Auth::user()) {
    	return redirect('/dashboard');
    }
    return redirect('/login');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/downtime-list', 'HomeController@downtimeList');
Route::get('/genset-list', 'GensetController@gensetList');
Route::get('/rpt_genset_utilization', 'GensetController@gensetReport');
Route::get('/rpt_downtimelist', 'DowntimeController@downtimeReport');
Route::get('/rpt_flatdata', 'DowntimeController@downtimeReportFlatdata');
Route::get('/rpt_chart', 'DowntimeController@downtimeReportChart');
Route::get('/rpt_masterlist', 'DowntimeController@downtimeReportMasterlist');
Route::get('/rpt_rawdata', 'DowntimeController@downtimeReportRawData');
Route::get('/rpt_daily', 'DowntimeController@downtimeReportDaily');
Route::get('/rpt_flatdata_print', 'DowntimeController@downtimeReportFlatdataPrint');
Route::get('/rpt_chart_print', 'DowntimeController@downtimeReportChartPrint');
Route::get('/rpt_masterlist_print', 'DowntimeController@downtimeReportMasterlistPrint');
Route::get('/rpt_rawdata_print', 'DowntimeController@downtimeReportRawDataPrint');
Route::get('/rpt_daily_print', 'DowntimeController@downtimeReportDailyPrint');
Route::get('/genset', 'HomeController@genset');
Route::get('/assets', 'HomeController@assets');
Route::get('/asset/new', 'AssetController@newAsset');

Route::get('/downtime/{id}', 'DowntimeController@editDowntime');
Route::get('/unit/{id}', 'UnitsController@editUnit');
Route::get('/genset/{id}', 'GensetController@editGenset');
Route::get('/asset/{id}', 'AssetController@editAsset');


Route::get('/change-password', function() {

    $id = \Auth::user()->id;

    return view('auth.passwords.change', compact('id'));

});

Route::patch('/change-password', 'HomeController@updatePassword');

Route::post('/units', 'UnitsController@store');
Route::post('/downtime', 'DowntimeController@store');
Route::post('/genset', 'GensetController@store');
Route::post('/asset', 'AssetController@store');


Route::patch('/downtime/{id}', 'DowntimeController@updateDowntime');
Route::patch('/unit/{id}', 'UnitsController@updateUnit');
Route::patch('/genset/{id}', 'GensetController@updateGenset');
Route::patch('/asset/{id}', 'AssetController@updateAsset');


Route::delete('/downtime/{id}', 'DowntimeController@deleteDowntime');
Route::delete('/genset/{id}', 'GensetController@deleteGenset');
Route::delete('/asset/{id}', 'AssetController@deleteAsset');