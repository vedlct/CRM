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
Route::view('/', 'layouts.login');
Route::view('/mylist', 'layouts.myList')->name('mylist');
Route::view('/testlist', 'layouts.testList')->name('testlist');
Route::view('/clients', 'layouts.clients')->name('clients');
Route::view('/leads', 'layouts.leads');
Route::view('/starleads', 'layouts.starLeads');
//Route::view('/newinfo', 'layouts.newInfo');
Route::view('/newinfo', 'layouts.newInfo');

Route::view('/reports', 'layouts.reports');
Route::view('/notices', 'layouts.notices');
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
Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');

//Route::view('/user-management', 'user-management.index');



//Lead

Route::get('/lead/add', 'LeadController@add')->name('addLead');
Route::post('lead/add', 'LeadController@store')->name('storeLead');

Route::get('lead/assign','LeadController@assignShow')->name('assignShow');
Route::post('lead/assign','LeadController@assignStore')->name('assignStore');

