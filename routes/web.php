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

// Route::get('/', function () {
//     if (\Auth::user()) {
//         return redirect('/dashboard');
//     }
//     return redirect('/login');
// });

Route::get('/login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login')->name('login'); // login submit

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('logout', 'LoginController@logout')->name('logout');

    // return view('auth.passwords.change', compact('id'));

    Route::patch('/change-password', 'HomeController@updatePassword');
    Route::get('dashboard', 'HomeController@index')->name('home');
    Route::get('downtime-list', 'HomeController@downtimeList')->name('downtime-list');
    Route::get('genset', 'HomeController@genset')->name('genset');
    Route::get('assets', 'HomeController@assets')->name('assets');

    Route::get('genset-list', 'GensetController@gensetList')->name('genset-list');
    Route::get('/rpt_genset_utilization', 'GensetController@gensetReport');
    Route::get('/genset/{id}', 'GensetController@editGenset');
    Route::post('/genset', 'GensetController@store');
    Route::patch('/genset/{id}', 'GensetController@updateGenset');
    Route::delete('/genset/{id}', 'GensetController@deleteGenset');

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
    // Route::get('/change-password', function () {
    //     $id = \Auth::user()->id;
    //     return view('auth.passwords.change', compact('id'));
    // });
    Route::patch('/change-password', 'HomeController@updatePassword');
    Route::post('units', 'UnitsController@store')->name('units');
    Route::post('downtime', 'DowntimeController@store')->name('downtime');
    Route::post('/genset', 'GensetController@store');
    Route::post('/asset', 'AssetController@store');
    Route::patch('/downtime/{id}', 'DowntimeController@updateDowntime');
    Route::patch('/unit/{id}', 'UnitsController@updateUnit');
    Route::patch('/genset/{id}', 'GensetController@updateGenset');
    Route::get('/asset/new', 'AssetController@newAsset');
    Route::get('/asset/{id}', 'AssetController@editAsset');
    Route::post('/asset', 'AssetController@store');
    Route::patch('/asset/{id}', 'AssetController@updateAsset');
    Route::delete('/asset/{id}', 'AssetController@deleteAsset');

    Route::get('/unit/{id}', 'UnitsController@editUnit');
    Route::post('units', 'UnitsController@store')->name('units');
    Route::patch('/unit/{id}', 'UnitsController@updateUnit');

    Route::delete('/downtime/{id}', 'DowntimeController@deleteDowntime');
    Route::delete('/genset/{id}', 'GensetController@deleteGenset');
    Route::delete('/asset/{id}', 'AssetController@deleteAsset');

    Route::group(['namespace' => 'Admin'], function () {
        // User routes
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index')->name('admin.users');
            Route::post('store', 'UserController@store')->name('admin.users.store');
            Route::any('search', 'UserController@search')->name('admin.users.search');
            Route::post('/edit', 'UserController@edit')->name('admin.users.edit');
            Route::put('update', 'UserController@update')->name('admin.users.update');
        });
        // Roles routes
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'RoleController@index')->name('admin.roles');
            Route::post('store', 'RoleController@store')->name('admin.roles.store');
            Route::any('search', 'RoleController@search')->name('admin.roles.search');
            Route::post('/edit', 'RoleController@edit')->name('admin.roles.edit');
            Route::put('update', 'RoleController@update')->name('admin.roles.update');
        });
        // Permission routes
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', 'PermissionController@index')->name('admin.permissions');
            Route::post('store', 'PermissionController@store')->name('admin.permissions.store');
            Route::any('search', 'PermissionController@search')->name('admin.permissions.search');
            Route::post('/edit', 'PermissionController@edit')->name('admin.permissions.edit');
            Route::put('update', 'PermissionController@update')->name('admin.permissions.update');
        });
        // //Role Access right routes
        // Route::group(['prefix' => 'roleaccessrights'], function () {
        //     Route::get('/', 'RoleRightController@index')->name('admin.roleaccessrights');
        //     Route::post('store', 'RoleRightController@store')->name('admin.roleaccessrights.store');
        //     Route::get('store', 'RoleRightController@store')->name('admin.roleaccessrights.store');
        // });        
    });
});
