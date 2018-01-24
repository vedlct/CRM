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


Route::view('/clients', 'layouts.clients')->name('clients');
Route::view('/leads', 'layouts.leads');

//Route::view('/newinfo', 'layouts.newInfo');
Route::view('/newinfo', 'layouts.newInfo');

//Route::view('/reports', 'layouts.reports');
//Route::view('/notices', 'layouts.notices');
Route::view('/leaves', 'layouts.leaves');

Route::view('/profile', 'layouts.profile');


Route::get('/user','UserController@index');


Route::view('/test', 'test');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

/*Route::get('/home',function (){
    return redirect('/dashboard');
});*/


Route::view('/lead', 'layouts.lead.add');
//Route::get('/assignreport', 'UserController@test');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



/**/

Route::resource('notice', 'NoticeController');
Route::post('notice/search', 'NoticeController@search')->name('notice.search');

Route::resource('user-management', 'UserManagementController');
Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');

Route::resource('follow-up', 'FollowupController');
Route::post('follow-up/search', 'FollowupController@search')->name('follow-up.search');

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





//Lead
Route::get('/lead/add', 'LeadController@add')->name('addLead');
Route::post('lead/add', 'LeadController@store')->name('storeLead');

Route::get('lead/assign','LeadController@assignShow')->name('assignShow');
Route::post('lead/assign','LeadController@assignStore')->name('assignStore');

Route::delete('lead/{id}','LeadController@destroy')->name('deleteLead');
Route::get('lead/filter','LeadController@filter')->name('filterLeads');
Route::get('lead/temp','LeadController@tempLeads')->name('tempLeads');
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
Route::get('/modal', 'TestController@modal')->name('modal');


//Star Lead
Route::get('lead/starleads', 'LeadController@starLeads')->name('starLeads');



//My Team
Route::get('/myteam', 'TeamController@myTeam')->name('myTeam');

//Assign Team

