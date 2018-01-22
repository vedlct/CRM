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

Route::view('/testlist', 'layouts.testList')->name('testlist');
Route::view('/clients', 'layouts.clients')->name('clients');
Route::view('/leads', 'layouts.leads');
Route::view('/starleads', 'layouts.starLeads');
//Route::view('/newinfo', 'layouts.newInfo');
Route::view('/newinfo', 'layouts.newInfo');

Route::view('/reports', 'layouts.reports');
//Route::view('/notices', 'layouts.notices');
Route::view('/leaves', 'layouts.leaves');
Route::view('/myteam', 'layouts.myTeam');
Route::view('/profile', 'layouts.profile');


Route::get('/user','UserController@index');


Route::view('/test', 'test');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

/*Route::get('/home',function (){
    return redirect('/dashboard');
});*/


Route::view('/lead', 'layouts.lead.add');
Route::get('/assignreport', 'UserController@test');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



/**/

Route::resource('notice', 'NoticeController');
Route::post('notice/search', 'NoticeController@search')->name('notice.search');

Route::resource('user-management', 'UserManagementController');
Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');

//Route::resource('system-management/userType', 'UserTypeController');
//Route::post('system-management/userType/search', 'UserTypeController@search')->name('userType.search');
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
Route::get('lead/report/{id}', 'LeadController@report')->name('report');
Route::post('lead/report', 'LeadController@storeReport')->name('storeReport');
Route::post('lead/comments','LeadController@getComments')->name('getComments');


//Leave Lead
Route::get('lead/leave/{id}','LeadController@leaveLead')->name('leaveLead');
