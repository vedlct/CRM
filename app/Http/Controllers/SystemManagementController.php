<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Country;
class SystemManagementController extends Controller
{
    public function index(){
        $categories = Category::get();
        $countries = Country::get();

        return view('layouts.systemManagement')
                ->with('categories',$categories)
                ->with('countries',$countries);

    }
}
