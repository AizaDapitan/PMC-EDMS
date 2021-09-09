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

Route::get('dashboard', 'HomeController@index')->name('home');
Route::get('downtime-list', 'HomeController@downtimeList')->name('downtime-list');
Route::get('genset-list', 'GensetController@gensetList')->name('genset-list');
Route::get('/rpt_genset_utilization', 'GensetController@gensetReport');
Route::get('rpt_downtimelist', 'DowntimeController@downtimeReport')->name('rpt_downtimelist');
Route::get('rpt_flatdata', 'DowntimeController@downtimeReportFlatdata')->name('rpt_flatdata');
Route::get('rpt_chart', 'DowntimeController@downtimeReportChart')->name('rpt_chart');
Route::get('rpt_masterlist', 'DowntimeController@downtimeReportMasterlist')->name('rpt_masterlist');
Route::get('rpt_rawdata', 'DowntimeController@downtimeReportRawData')->name('rpt_rawdata');
Route::get('rpt_daily', 'DowntimeController@downtimeReportDaily')->name('rpt_daily');
Route::get('/rpt_flatdata_print', 'DowntimeController@downtimeReportFlatdataPrint');
Route::get('/rpt_chart_print', 'DowntimeController@downtimeReportChartPrint');
Route::get('/rpt_masterlist_print', 'DowntimeController@downtimeReportMasterlistPrint');
Route::get('/rpt_rawdata_print', 'DowntimeController@downtimeReportRawDataPrint');
Route::get('/rpt_daily_print', 'DowntimeController@downtimeReportDailyPrint');
Route::get('genset', 'HomeController@genset')->name('genset');
Route::get('assets', 'HomeController@assets')->name('assets');
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

Route::post('units', 'UnitsController@store')->name('units');
Route::post('downtime', 'DowntimeController@store')->name('downtime');
Route::post('/genset', 'GensetController@store');
Route::post('/asset', 'AssetController@store');


Route::patch('/downtime/{id}', 'DowntimeController@updateDowntime');
Route::patch('/unit/{id}', 'UnitsController@updateUnit');
Route::patch('/genset/{id}', 'GensetController@updateGenset');
Route::patch('/asset/{id}', 'AssetController@updateAsset');


Route::delete('/downtime/{id}', 'DowntimeController@deleteDowntime');
Route::delete('/genset/{id}', 'GensetController@deleteGenset');
Route::delete('/asset/{id}', 'AssetController@deleteAsset');