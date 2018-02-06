<?php

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


Route::view('/main', 'layouts.index')->name('main');
Route::get('/', 'Auth\LoginController@mainLogin');





Route::view('/newinfo', 'layouts.newInfo');


Route::view('/leaves', 'layouts.leaves');

Route::view('/profile', 'layouts.profile');


Route::get('/user','UserController@index');


Route::view('/test', 'test');

Auth::routes();

Route::get('/system','SystemManagementController@index')->name('system');




Route::view('/lead', 'layouts.lead.add');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('home');


Route::get('/test', 'TestController@test');
Route::post('/tests', 'TestController@anyData')->name('test');

/**/

Route::resource('notice', 'NoticeController');
Route::post('notice/search', 'NoticeController@search')->name('notice.search');

Route::resource('user-management', 'UserManagementController');
Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');

//Set Target
Route::post('user-management/setTarget','UserManagementController@setTarget')->name('setTarget');

Route::resource('follow-up', 'FollowupController');

Route::resource('system-management/country', 'CountryController');
Route::post('system-management/country/search', 'CountryController@search')->name('country.search');


Route::resource('system-management/category', 'CategoryController');
Route::post('system-management/category/search', 'CategoryController@search')->name('category.search');

Route::resource('system-management/usertype', 'UsertypeController');
Route::post('system-management/usertype/search', 'UsertypeController@search')->name('usertype.search');

Route::resource('system-management/possibility', 'PossibilityController');
Route::post('system-management/possibility/search', 'PossibilityController@search')->name('possibility.search');

Route::resource('system-management/status', 'statusController');
Route::post('system-management/status/search', 'statusController@search')->name('status.search');

//Route::view('/user-management', 'user-management.index');

//Search bettween dates
Route::post('follow-up/search', 'FollowupController@search')->name('follow-up.search');


//Lead
Route::get('/lead/add', 'LeadController@add')->name('addLead');
Route::post('lead/add', 'LeadController@store')->name('storeLead');

Route::get('lead/assign','LeadController@assignShow')->name('assignShow');
Route::post('lead/getAssignLeadData','LeadController@getAssignLeadData')->name('getAssignLeadData');  //Get Data using Data Table
Route::post('lead/assign','LeadController@assignStore')->name('assignStore');


Route::delete('lead/{id}','LeadController@destroy')->name('deleteLead');
Route::get('lead/filter','LeadController@filter')->name('filterLeads');
Route::post('lead/filter','LeadController@getFilterLeads')->name('filterLeadData');

Route::get('lead/temp','LeadController@tempLeads')->name('tempLeads');

Route::post('lead/temp','LeadController@tempData')->name('tempData');

Route::post('lead/changepossibility','LeadController@changePossibility')->name('changePossibility');

Route::post('lead/update','LeadController@update')->name('leadUpdate');
Route::post('lead/testPost','LeadController@testPost')->name('testPost');
Route::post('lead/ajax','LeadController@ajax')->name('ajax');

//My List Lead
Route::get('lead/assignedleads', 'LeadController@assignedLeads')->name('assignedLeads');
//Route::get('lead/report/{id}', 'LeadController@report')->name('report');
Route::post('lead/report', 'LeadController@storeReport')->name('storeReport');
Route::post('lead/comments','LeadController@getComments')->name('getComments');


//Leave Lead
Route::get('lead/leave/{id}','LeadController@leaveLead')->name('leaveLead');


//testList
Route::get('/testlist', 'LeadController@testLeads')->name('testlist');
Route::get('/closelist', 'LeadController@closeLeads')->name('closelist');



Route::get('/modal', 'TestController@modal')->name('modal');


//Star Lead
Route::get('lead/starleads', 'LeadController@starLeads')->name('starLeads');

//Contacted Lead
Route::get('/contacted', 'LeadController@contacted')->name('contacted');
Route::post('/contacted','LeadController@addContacted')->name('addContacted');

//Reject Leads rejectedLeads
Route::get('leads/rejected','LeadController@rejectedLeads')->name('rejectedLeads');
Route::post('rejectlead','LeadController@rejectData')->name('rejectData');

Route::get('/lead/reject/{id}','LeadController@rejectStore');


//My Team
Route::get('/myteam', 'TeamController@myTeam')->name('myTeam');

//Add and edit team
Route::get('/team/add', 'TeamController@addTeam')->name('addTeam');
Route::post('/team/add', 'TeamController@insertTeam')->name('insertTeam');
Route::delete('/team/delete/{id}', 'TeamController@deleteTeam')->name('deleteTeam');
Route::put('/team/update','TeamController@teamUpdate')->name('teamUpdate');



//Assign member to the Team
Route::get('/teammanagement','TeamController@teamManagement')->name('teamManagement');
Route::post('/teammanagement','TeamController@teamAssign')->name('teamAssign');

//Remove From Team
Route::post('/teammanagement/removeuser','TeamController@removeUser')->name('removeUser');


//Account Setting
Route::get('/settings','UserManagementController@settings')->name('accountSetting');
Route::post('/settings','UserManagementController@changePass')->name('changePass');



//Detached Lead From Team Member
Route::get('/lead/detached','DetachedLeadController@index')->name('detached');
Route::post('/lead/detached','DetachedLeadController@detached')->name('detached.reject');

//Report
Route::get('/report','ReportController@index')->name('report');
Route::get('report/user/{id}','ReportController@individualCall');



//Graph
Route::post('graph/user','ReportController@getUserGraph')->name('getUserGraph');


