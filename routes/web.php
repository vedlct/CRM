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


Route::view('/main', 'layouts.index');
Route::view('/', 'layouts.login');
Route::view('/mylist', 'layouts.myList');
Route::view('/testlist', 'layouts.testList');
Route::view('/clients', 'layouts.clients');
Route::view('/leads', 'layouts.leads');
Route::view('/starleads', 'layouts.starLeads');
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

Route::get('/home',function (){
    return redirect('/dashboard');
});


Route::view('/lead', 'layouts.lead.add');
Route::get('/assignreport', 'UserController@test');


