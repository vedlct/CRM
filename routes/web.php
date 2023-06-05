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
Route::post('/websiteCheck','LeadController@websiteCheck')->name('websiteCheck');
Route::post('/comapanyNameCheck','LeadController@comapanyNameCheck')->name('comapanyNameCheck');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/highPossibility', 'HomeController@highPossibility')->name('highPossibility');
Route::get('/testLead', 'HomeController@testLead')->name('testLead');
Route::get('/called', 'HomeController@call')->name('called');
Route::get('/conversation', 'HomeController@conversation')->name('conversation');
Route::get('/closeLead', 'HomeController@closeLead')->name('closeLead');
Route::get('/followup', 'HomeController@followup')->name('followup');
Route::get('/contact','HomeController@contact')->name('contact');
Route::get('/contactUsa','HomeController@contactUsa')->name('contactUsa');
Route::get('/mine', 'HomeController@mine')->name('mine');
Route::get('/files', 'HomeController@newFile')->name('files');

Route::resource('notice', 'NoticeController');
Route::post('notice/search', 'NoticeController@search')->name('notice.search');


Route::resource('user-management', 'UserManagementController');
Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');

//Set Target
Route::post('user-management/setTarget','UserManagementController@setTarget')->name('setTarget');

//Get All Possessed Leads and Set Bar
Route::post('user-management/possessedLeads','UserManagementController@getPossessedLeads')->name('getPossessedLeads');
// Route::post('user-management/setBarForOwnedLeads','UserManagementController@setBarForOwnedLeads')->name('setBarForOwnedLeads');


//Route::post('lead/changepossibility','LeadController@changePossibility')->name('changePossibility');
Route::post('checkfollowup','FollowupController@followupCheck')->name('followupCheck');
Route::post('storeFollowupReport','FollowupController@storeFollowupReport')->name('storeFollowupReport');
Route::get('follow-up','FollowupController@index')->name('follow-up.index');
//Route::get('follow-up/search/{fromdate}/{todate}', 'FollowupController@search')->name('follow-up.search');
Route::post('follow-up/search', 'FollowupController@search')->name('follow-up.search');

Route::post('call/check/lastday','HomeController@checkLastDayCall')->name('check.lastdayCall');
Route::post('call/check/lastday/comment','HomeController@checkLastDayCallComment')->name('check.lastdayCall.comment');
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

Route::get('/user-target-management', 'UserManagementController@targetManagement')->name('user-management.target');
Route::post('/user-target-management', 'UserManagementController@targetManagementGet')->name('user-management.target.Get');

//Search bettween dates


//Lead
Route::get('/lead/add', 'LeadController@add')->name('addLead');
Route::get('/lead/addNightShift', 'LeadController@addNightShift')->name('addNightShift');
Route::post('lead/add', 'LeadController@store')->name('storeLead');
Route::post('lead/storeLeadAdmin', 'LeadController@storeLeadAdmin')->name('storeLeadAdmin');

Route::post('lead/all','LeadController@allLeads')->name('allLeads');


//verify lead
Route::get('/verify-lead', 'LeadController@verifylead')->name('verifylead');
Route::post('verifyleads','LeadController@verifyallLeads')->name('verifyallLeads');



Route::get('lead/assign','LeadController@assignShow')->name('assignShow');
Route::post('lead/getAssignLeadData','LeadController@getAssignLeadData')->name('getAssignLeadData');  //Get Data using Data Table
Route::post('lead/assign','LeadController@assignStore')->name('assignStore');

Route::post('lead/assignn','LeadController@assignStore2')->name('assignStore2');


Route::get('lead/assign-lead','LeadController@assignAllShow')->name('assignAllShow');
Route::post('lead/getAllAssignLeadData','LeadController@getAllAssignLeadData')->name('getAllAssignLeadData');
//Route::post('lead/getFilteredAssignLeadData','LeadController@getAssignLeadData')->name('getFilteredAssignLeadData');



Route::delete('lead/{id}','LeadController@destroy')->name('deleteLead');
Route::get('lead/filter','LeadController@filter')->name('filterLeads');
Route::post('lead/filter','LeadController@getFilterLeads')->name('filterLeadData');

Route::get('lead/temp','LeadController@tempLeads')->name('tempLeads');

Route::post('lead/tempdata','LeadController@tempData')->name('tempData');

Route::post('lead/changepossibility','LeadController@changePossibility')->name('changePossibility');

Route::post('lead/update','LeadController@update')->name('leadUpdate');
Route::post('lead/testPost','LeadController@testPost')->name('testPost');
Route::post('lead/ajax','LeadController@ajax')->name('ajax');

//Release Lead
Route::get('/lead/Release', 'LeadController@showRelease')->name('showrelease');
Route::post('/lead/getRelease', 'LeadController@getallrelease')->name('getallrelease');


//My List Lead
Route::get('lead/assignedleads', 'LeadController@assignedLeads')->name('assignedLeads');
//Route::get('lead/report/{id}', 'LeadController@report')->name('report');
Route::post('lead/report', 'LeadController@storeReport')->name('storeReport');
Route::post('lead/comments','LeadController@getComments')->name('getComments');
Route::post('lead/callReports','LeadController@getCallingReport')->name('getCallingReport');
Route::post('lead/activities','LeadController@getActivities')->name('getActivities');
Route::get('lead/ippList', 'LeadController@ippList')->name('ippList');
Route::post('lead/FollowupsCounter','LeadController@getFollowupsCounter')->name('getFollowupsCounter');


//Leave Lead
//Route::get('lead/leave/{id}','LeadController@leaveLead')->name('leaveLead');
Route::post('lead/leave','LeadController@leaveLead')->name('leaveLead');


//testList
Route::get('/testlist', 'LeadController@testLeads')->name('testlist');
Route::get('/closelist', 'LeadController@closeLeads')->name('closelist');
Route::get('/rejectlist', 'LeadController@rejectlist')->name('rejectlist');


//Star Lead
Route::get('lead/starleads', 'LeadController@starLeads')->name('starLeads');

//Client Lead
Route::get('lead/clientleads', 'ClientLeadController@index')->name('clientLeads');
Route::post('lead/clientleads/edit', 'ClientLeadController@edit')->name('clientLeads.edit');
Route::post('lead/clientleads/add', 'ClientLeadController@add')->name('clientLeads.add');
Route::post('lead/clientleads/insert', 'ClientLeadController@insert')->name('clientLeads.insert');

//Contacted Lead
Route::get('/contacted', 'LeadController@contacted')->name('contacted');
Route::post('/contacted','LeadController@addContacted')->name('addContacted');
Route::post('/mycontacted','LeadController@addmyContacted')->name('addmyContacted');
Route::post('contacted/status','LeadController@contactedStatus')->name('contactedStatus');
Route::post('/addContactedTemp','LeadController@addContactedTemp')->name('addContactedTemp');
Route::post('/getContacedData','LeadController@getContacedData')->name('getContacedData');

Route::post('/editcontactmodalshow','LeadController@editcontactmodalshow')->name('editcontactmodalshow');

Route::get('/Mycontacted', 'LeadController@Mycontacted')->name('Mycontacted');
Route::post('/getMyContacedData','LeadController@getMyContacedData')->name('getMyContacedData');

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
Route::get('/reportGraph','ReportController@reportGraph')->name('reportGraph');
Route::post('/searchGraphByDate','ReportController@searchGraphByDate')->name('searchGraphByDate');
Route::get('/reportTable','ReportController@reportTable')->name('reportTable');
Route::post('/searchTableByDate','ReportController@searchTableByDate')->name('searchTableByDate');
Route::get('report/user/{id}','ReportController@individualCall');
Route::get('/reportTableForUser','ReportController@reportTableForUser')->name('reportTableForUser');

//Report Analysis
Route::get('/analysisComments', 'LeadController@analysisComments')->name('analysisComments');
Route::post('/analysisComments', 'LeadController@analysisComments');
Route::post('/exportAnalysisComments', 'LeadController@exportAnalysisComments')->name('exportAnalysisComments');
Route::get('/reportAllActivties','LeadController@reportAllActivties')->name('reportAllActivties');
Route::get('duplicateLeadList', 'LeadController@duplicateLeadList')->name('duplicateLeadList');
Route::get('allAssignedButNotMyleads', 'LeadController@allAssignedButNotMyleads')->name('allAssignedButNotMyleads');
Route::get('allConversations', 'LeadController@getallConversations')->name('getallConversations');
Route::get('/hourlyActivity', 'LeadController@hourlyActivity')->name('hourlyActivity');
Route::get('/frequentlyFiltered', 'LeadController@frequentlyFilteredLeads')->name('frequentlyFilteredLeads');
Route::get('/googleSearch', 'LeadController@googleSearch')->name('googleSearch');
Route::post('/googleSearch', 'LeadController@googleSearch');
Route::get('/crawl', 'LeadController@crawlWebsites')->name('crawlWebsites');
Route::post('/crawl', 'LeadController@crawlWebsites')->name('crawlWebsites');



//supervisor OR Manager OR Admin report
Route::get('/reportTableCountry','ReportController@reportTableCountry')->name('reportcountryTable');
Route::post('/searchCountryTableByDate','ReportController@searchCountryTableByDate')->name('searchCountryTableByDate');



//supervisor OR Manager report
Route::get('/reportCategory','ReportController@reportCategory')->name('reportCategory');
Route::get('/reportStatus','ReportController@reportStatus')->name('reportStatus');
Route::get('/reportCountry','ReportController@reportCountry')->name('reportCountry');
Route::get('hour/report', 'ReportController@hourReport')->name('hour.report');
Route::get('follow-up/report', 'ReportController@followupReport')->name('follow-up.report');
Route::post('/searchFollowupByDate','ReportController@searchFollowupByDate')->name('searchFollowupByDate');
Route::get('follow-up/report', 'ReportController@followupReport')->name('follow-up.report');
Route::post('hour/report-filter', 'ReportController@hourReport_filter')->name('hour.report-filter');

//Route::post('/searchCategoryByDate','ReportController@searchCategoryByDate')->name('searchCategoryByDate');
//Route::post('/getHighLead','ReportController@getHighLead')->name('getHighLead');


//Supervisor report Tab
Route::get('/report/tab','ReportController@reportTab')->name('report.tab');
Route::post('/reportTabHourly','ReportController@reportTabHourly')->name('reportTabHourly');
Route::post('/reportTabCategory','ReportController@reportTabCategory')->name('reportTabCategory');
Route::post('/reportTabCountry','ReportController@reportTabCountry')->name('reportTabCountry');
Route::post('/reportTabStatus','ReportController@reportTabStatus')->name('reportTabStatus');
//endtab

Route::post('/searchTableByDateForUser','ReportController@searchTableByDateForUser')->name('searchTableByDateForUser');

//Report Individual from Report Table
Route::post('/getHighPossibilityIndividual','GetIndividualReportController@getHighPossibilityIndividual')->name('getHighPossibilityIndividual');
Route::post('/getHighPossibilityUnIndividual','GetIndividualReportController@getHighPossibilityUnIndividual')->name('getHighPossibilityUnIndividual');
Route::post('/getCallIndividual','GetIndividualReportController@getCallIndividual')->name('getCallIndividual');
Route::post('/getMineIndividual','GetIndividualReportController@getMineIndividual')->name('getMineIndividual');
Route::post('/getFileCountIndividual','GetIndividualReportController@getFileCountIndividual')->name('getFileCountIndividual');
Route::post('/getNewCallIndividual','GetIndividualReportController@getNewCallIndividual')->name('getNewCallIndividual');
Route::post('/getTestFileRaIndividual','GetIndividualReportController@getTestFileRaIndividual')->name('getTestFileRaIndividual');
//Route::post('/getPossessedLeads','GetIndividualReportController@getPossessedLeads')->name('getPossessedLeads');


//followup report
Route::post('/getNotDoneFollowup','GetIndividualReportController@getNotDoneFollowup')->name('getNotDoneFollowup');
Route::post('/getAllFollowup','GetIndividualReportController@getAllFollowup')->name('getAllFollowup');


Route::post('/getEmailIndividual','GetIndividualReportController@getEmailIndividual')->name('getEmailIndividual');
Route::post('/getCategoryLead','GetIndividualReportController@getCategoryLead')->name('getCategoryLead');
Route::post('/getStatusLead','GetIndividualReportController@getStatusLead')->name('getStatusLead');
Route::post('/getCountryLead','GetIndividualReportController@getCountryLead')->name('getCountryLead');
Route::post('/getcoldEmailIndividual','GetIndividualReportController@getcoldEmailIndividual')->name('getcoldEmailIndividual');
Route::post('/getconversationIndividual','GetIndividualReportController@getconversationIndividual')->name('getconversationIndividual');
Route::post('/getOtherIndividual','GetIndividualReportController@getOtherIndividual')->name('getOtherIndividual');
Route::post('/getNotAvailableIndividual','GetIndividualReportController@getNotAvailableIndividual')->name('getNotAvailableIndividual');

Route::post('/getGateKeeper','GetIndividualReportController@getGateKeeper')->name('getgatekeeper');

Route::post('/getNotInterestedIndividual','GetIndividualReportController@getNotInterestedIndividual')->name('getNotInterestedIndividual');

Route::post('new-file/update','GetIndividualReportController@updateNewFile')->name('update.newFile');


Route::post('/getAssignedLeadIndividual','GetIndividualReportController@getAssignedLeadIndividual')->name('getAssignedLeadIndividual');
Route::post('/getTestIndividual','GetIndividualReportController@getTestIndividual')->name('getTestIndividual');
Route::post('/getClosingIndividual','GetIndividualReportController@getClosingIndividual')->name('getClosingIndividual');
Route::post('/getFollowupIndividual','GetIndividualReportController@getFollowupIndividual')->name('getFollowupIndividual');
Route::post('/getContactedIndividual','GetIndividualReportController@getContactedIndividual')->name('getContactedIndividual');
Route::post('/getContactedUsaIndividual','GetIndividualReportController@getContactedUsaIndividual')->name('getContactedUsaIndividual');
Route::post('/approval','GetIndividualReportController@approval')->name('approval');



//Report Individual Country from Report Table
Route::post('/getHighPossibilityIndividualCountry','GetIndividualCountryReportController@getHighPossibilityIndividualCountry')->name('getHighPossibilityIndividualCountry');
Route::post('/getHighPossibilityUnIndividualCountry','GetIndividualCountryReportController@getHighPossibilityUnIndividualCountry')->name('getHighPossibilityUnIndividualCountry');
Route::post('/getCallIndividualCountry','GetIndividualCountryReportController@getCallIndividualCountry')->name('getCallIndividualCountry');
Route::post('/getMineIndividualCountry','GetIndividualCountryReportController@getMineIndividualCountry')->name('getMineIndividualCountry');
Route::post('/getFileCountIndividualCountry','GetIndividualCountryReportController@getFileCountIndividualCountry')->name('getFileCountIndividualCountry');
Route::post('/getNewCallIndividualCountry','GetIndividualCountryReportController@getNewCallIndividualCountry')->name('getNewCallIndividualCountry');
Route::post('/getTestFileRaIndividualCountry','GetIndividualCountryReportController@getTestFileRaIndividualCountry')->name('getTestFileRaIndividualCountry');


//followup report
Route::post('/getNotDoneFollowupCountry','GetIndividualCountryReportController@getNotDoneFollowupCountry')->name('getNotDoneFollowupCountry');
Route::post('/getAllFollowupCountry','GetIndividualCountryReportController@getAllFollowupCountry')->name('getAllFollowupCountry');


Route::post('/getEmailIndividualCountry','GetIndividualCountryReportController@getEmailIndividualCountry')->name('getEmailIndividualCountry');
Route::post('/getCategoryLeadCountry','GetIndividualCountryReportController@getCategoryLeadCountry')->name('getCategoryLeadCountry');
Route::post('/getStatusLeadCountry','GetIndividualCountryReportController@getStatusLeadCountry')->name('getStatusLeadCountry');
Route::post('/getCountryLeadCountry','GetIndividualCountryReportController@getCountryLeadCountry')->name('getCountryLeadCountry');
Route::post('/getcoldEmailIndividualCountry','GetIndividualCountryReportController@getcoldEmailIndividualCountry')->name('getcoldEmailIndividualCountry');
Route::post('/getOtherIndividualCountry','GetIndividualCountryReportController@getOtherIndividualCountry')->name('getOtherIndividualCountry');
Route::post('/getNotAvailableIndividualCountry','GetIndividualCountryReportController@getNotAvailableIndividualCountry')->name('getNotAvailableIndividualCountry');




Route::post('new-file/updateCountry','GetIndividualCountryReportController@updateNewFile')->name('update.newFile');


Route::post('/getAssignedLeadIndividualCountry','GetIndividualCountryReportController@getAssignedLeadIndividualCountry')->name('getAssignedLeadIndividualCountry');
Route::post('/getTestIndividualCountry','GetIndividualCountryReportController@getTestIndividualCountry')->name('getTestIndividualCountry');
Route::post('/getClosingIndividualCountry','GetIndividualCountryReportController@getClosingIndividualCountry')->name('getClosingIndividualCountry');
Route::post('/getFollowupIndividualCountry','GetIndividualCountryReportController@getFollowupIndividualCountry')->name('getFollowupIndividualCountry');
Route::post('/getContactedIndividualCountry','GetIndividualCountryReportController@getContactedIndividualCountry')->name('getContactedIndividualCountry');
Route::post('/getContactedUsaIndividualCountry','GetIndividualCountryReportController@getContactedUsaIndividualCountry')->name('getContactedUsaIndividualCountry');
Route::post('/approvalCountry','GetIndividualCountryReportController@approval')->name('approval');


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
Route::post('local/insertOldSale','LocalSalesController@insertOldSale')->name('local.insertOldSale');
Route::post('local/getOldSalesData','LocalSalesController@getOldSalesData')->name('local.getOldSalesData');
Route::post('local/getOldPaymentInfo','LocalSalesController@getOldPaymentInfo')->name('local.getOldPaymentInfo');
Route::post('local/insertOldSalePayment','LocalSalesController@insertOldSalePayment')->name('local.insertOldSalePayment');

//Local Company
Route::get('local/company','LocalCompanyController@index')->name('local.company');
Route::post('local/company/add','LocalCompanyController@addCompany')->name('local.addCompany');
Route::post('local/company/getCompanyModal','LocalCompanyController@getCompanyModal')->name('local.getCompanyModal');

//Local Reporting
Route::get('local/report','LocalReportController@index')->name('local.report');
Route::post('local/revenueClient','LocalReportController@revenueClient')->name('local.revenueClient');
Route::post('local/employeeReport','LocalReportController@employeeReport')->name('local.employeeReport');
Route::post('local/leadAssignReport','LocalReportController@leadAssignReport')->name('local.leadAssignReport');
Route::post('local/getUserRevenueLog','LocalReportController@getUserRevenueLog')->name('local.getUserRevenueLog');

Route::post('local/workReportUser','LocalReportController@workReportUser')->name('local.workReportUser');
Route::post('local/getUserSales','LocalReportController@getUserSales')->name('local.getUserSales');
Route::post('local/getUserOldSales','LocalReportController@getUserOldSales')->name('local.getUserOldSales');
Route::post('local/getUserMeeting','LocalReportController@getUserMeeting')->name('local.getUserMeeting');
Route::post('local/getUserFollowup','LocalReportController@getUserFollowup')->name('local.getUserFollowup');


//Local User
Route::post('local/getUserTarget','UserManagementController@getLocalUserTarget')->name('local.getUserTarget');
Route::post('local/setUserTarget','UserManagementController@setLocalUserTarget')->name('local.setUserTarget');

