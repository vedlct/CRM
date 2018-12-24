<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Country;
use App\Status;
class SystemManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $categories = Category::get();
        $countries = Country::get();
        $statuses = Status::get();



        return view('layouts.systemManagement')
                ->with('categories',$categories)
                ->with('countries',$countries)
                ->with('statuses',$statuses);

    }
}
