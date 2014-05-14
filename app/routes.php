<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('report_list');
// });

Route::get('/', 'ReportController@index');
Route::get('report/{id}/{mode}', 'ReportController@showReport');
Route::post('ajax/reportAdd', 'ReportController@ajaxReportAdd');
Route::post('ajax/projectAdd', 'ProjectController@ajaxProjectAdd');
Route::post('ajax/taskQuery/{action}', 'TaskController@ajaxTaskQuery');
Route::get('ajax/reportList', 'ReportController@ajaxReportList');
Route::get('ajax/reportTable/{id}', 'ReportController@ajaxReportTable');

?>
