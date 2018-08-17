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


Auth::routes();

Route::get('/system','SystemManagementController@index')->name('system');


Route::view('/lead', 'layouts.lead.add');

Route::post('/numberCheck','LeadController@numberCheck')->name('numberCheck');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/highPossibility', 'HomeController@highPossibility')->name('highPossibility');
Route::get('/called', 'HomeController@call')->name('called');
Route::get('/contact','HomeController@contact')->name('contact');
Route::get('/mine', 'HomeController@mine')->name('mine');




/**/

Route::resource('notice', 'NoticeController');
Route::post('notice/search', 'NoticeController@search')->name('notice.search');

Route::resource('user-management', 'UserManagementController');
Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');

//Set Target
Route::post('user-management/setTarget','UserManagementController@setTarget')->name('setTarget');

//Route::post('lead/changepossibility','LeadController@changePossibility')->name('changePossibility');
Route::post('checkfollowup','FollowupController@followupCheck')->name('followupCheck');
Route::post('storeFollowupReport','FollowupController@storeFollowupReport')->name('storeFollowupReport');
Route::get('follow-up','FollowupController@index')->name('follow-up.index');
//Route::get('follow-up/search/{fromdate}/{todate}', 'FollowupController@search')->name('follow-up.search');
Route::post('follow-up/search', 'FollowupController@search')->name('follow-up.search');



//Route::resource('follow-up', 'FollowupController');


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


Route::resource('showchart', 'HighChartsController');
Route::post('showchart', 'HighChartsController@search')->name('showchart.search');

//Route::view('/user-management', 'user-management.index');

//Search bettween dates


//Lead
Route::get('/lead/add', 'LeadController@add')->name('addLead');
Route::post('lead/add', 'LeadController@store')->name('storeLead');
Route::post('lead/storeLeadAdmin', 'LeadController@storeLeadAdmin')->name('storeLeadAdmin');

Route::post('lead/all','LeadController@allLeads')->name('allLeads');

Route::get('lead/assign','LeadController@assignShow')->name('assignShow');
Route::post('lead/getAssignLeadData','LeadController@getAssignLeadData')->name('getAssignLeadData');  //Get Data using Data Table
Route::post('lead/assign','LeadController@assignStore')->name('assignStore');


Route::delete('lead/{id}','LeadController@destroy')->name('deleteLead');
Route::get('lead/filter','LeadController@filter')->name('filterLeads');
Route::post('lead/filter','LeadController@getFilterLeads')->name('filterLeadData');

Route::get('lead/temp','LeadController@tempLeads')->name('tempLeads');

Route::post('lead/tempdata','LeadController@tempData')->name('tempData');

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
//Route::get('lead/leave/{id}','LeadController@leaveLead')->name('leaveLead');
Route::post('lead/leave','LeadController@leaveLead')->name('leaveLead');


//testList
Route::get('/testlist', 'LeadController@testLeads')->name('testlist');
Route::get('/closelist', 'LeadController@closeLeads')->name('closelist');
Route::get('/rejectlist', 'LeadController@rejectlist')->name('rejectlist');





//Star Lead
Route::get('lead/starleads', 'LeadController@starLeads')->name('starLeads');

//Contacted Lead
Route::get('/contacted', 'LeadController@contacted')->name('contacted');
Route::post('/contacted','LeadController@addContacted')->name('addContacted');
Route::post('/addContactedTemp','LeadController@addContactedTemp')->name('addContactedTemp');
Route::post('/getContacedData','LeadController@getContacedData')->name('getContacedData');
Route::post('/editcontactmodalshow','LeadController@editcontactmodalshow')->name('editcontactmodalshow');

//Reject Leads rejectedLeads
Route::get('leads/rejected','LeadController@rejectedLeads')->name('rejectedLeads');
Route::post('rejectlead','LeadController@rejectData')->name('rejectData');

Route::post('/lead/reject','LeadController@rejectStore')->name('rejectStore');


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
Route::get('/reportTable','ReportController@reportTable')->name('reportTable');
Route::get('/reportTableForUser','ReportController@reportTableForUser')->name('reportTableForUser');


Route::post('/searchGraphByDate','ReportController@searchGraphByDate')->name('searchGraphByDate');
Route::post('/searchTableByDate','ReportController@searchTableByDate')->name('searchTableByDate');
Route::post('/searchTableByDateForUser','ReportController@searchTableByDateForUser')->name('searchTableByDateForUser');

//Report Individual from Report Table
Route::post('/getHighPossibilityIndividual','GetIndividualReportController@getHighPossibilityIndividual')->name('getHighPossibilityIndividual');
Route::post('/getHighPossibilityUnIndividual','GetIndividualReportController@getHighPossibilityUnIndividual')->name('getHighPossibilityUnIndividual');
Route::post('/getCallIndividual','GetIndividualReportController@getCallIndividual')->name('getCallIndividual');
Route::post('/getMineIndividual','GetIndividualReportController@getMineIndividual')->name('getMineIndividual');
Route::post('/getAssignedLeadIndividual','GetIndividualReportController@getAssignedLeadIndividual')->name('getAssignedLeadIndividual');
Route::post('/getTestIndividual','GetIndividualReportController@getTestIndividual')->name('getTestIndividual');
Route::post('/getClosingIndividual','GetIndividualReportController@getClosingIndividual')->name('getClosingIndividual');
Route::post('/getFollowupIndividual','GetIndividualReportController@getFollowupIndividual')->name('getFollowupIndividual');
Route::post('/getContactedIndividual','GetIndividualReportController@getContactedIndividual')->name('getContactedIndividual');
Route::post('/getContactedUsaIndividual','GetIndividualReportController@getContactedUsaIndividual')->name('getContactedUsaIndividual');
Route::post('/approval','GetIndividualReportController@approval')->name('approval');


//Graph
Route::post('graph/user','ReportController@getUserGraph')->name('getUserGraph');


Route::get('/test','TestController@getTable');
Route::post('/test','TestController@searchTableByDate')->name('test.searchTableByDate');


/* --------------------- LOCAL MARKETING ------------------ */

Route::get('local/lead/', 'LocalLeadController@all')->name('local.allLead');
Route::post('local/lead/', 'LocalLeadController@getLeadData')->name('local.getLeadData');
Route::post('local/lead/storeLead', 'LocalLeadController@storeLead')->name('local.storeLead');

Route::get('local/lead/my-lead', 'LocalLeadController@myLead')->name('local.myLead');
Route::post('local/lead/my-lead', 'LocalLeadController@getMyLead')->name('local.getMyLead');
Route::post('local/lead/getEditModal', 'LocalLeadController@getEditModal')->name('local.getEditModal');
Route::get('local/lead/assignLead', 'LocalLeadController@assignLead')->name('local.assignLead');
Route::post('local/lead/assignLead', 'LocalLeadController@getAssignLead')->name('local.getAssignLead');

//Job Assign
Route::post('local/lead/insertAssign','LocalLeadController@insertAssign')->name('local.insertAssign');
Route::post('local/lead/getAssignedUsers', 'LocalLeadController@getAssignedUsers')->name('local.getAssignedUsers');

//Follow up
Route::post('local/lead/getFollowupModal','LocalLeadController@getFollowupModal')->name('local.getFollowupModal');
Route::post('local/lead/insertCallReport','LocalLeadController@insertCallReport')->name('local.insertCallReport');
Route::get('local/followup/today','LocalLeadController@todaysFollowup')->name('local.todaysFollowup');

//Local Sales
Route::get('local/sales','LocalSalesController@index')->name('local.sales');
Route::post('local/sales','LocalSalesController@getLeads')->name('local.getSalesLead');
Route::post('local/getPaymentInfo','LocalSalesController@getPaymentInfo')->name('local.getPaymentInfo');
Route::post('local/insertPayment','LocalSalesController@insertPayment')->name('local.insertPayment');


//Local Company
Route::get('local/company','LocalCompanyController@index')->name('local.company');
Route::post('local/company/add','LocalCompanyController@addCompany')->name('local.addCompany');
Route::post('local/company/getCompanyModal','LocalCompanyController@getCompanyModal')->name('local.getCompanyModal');




