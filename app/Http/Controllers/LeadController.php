<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

use App\Category;
use App\Possibility;
use App\Country;
use App\Lead;

class LeadController extends Controller
{
    public function add(){

        $cats=Category::where('type', 1)->get();
        $pos=Possibility::get();

        $countries=Country::get();

        return view('layouts.lead.add')
            ->with('cats',$cats)
            ->with('pos',$pos)
            ->with('countries',$countries);
    }


    public function store(Request $r){

        $this->validate($r,[

            'companyName' => 'required|max:100',
            'website' => 'required|max:100',
            'email' => 'required|max:100',
            'category' => 'required',
            'possibility' => 'required',
            'personName' => 'required:max:100',
            'personNumber' => 'required|max:15',
            'country' => 'required',
            'country' => 'required',

        ]);


        $l=new Lead;
        $l->statusId = 1;
        $l->possibiliyId = $r->possibility;
        $l->categoryId = $r->category;
        $l->companyName = $r->companyName;
        $l->personName= $r->personName;
        $l->website = $r->website;
        $l->email= $r->email;
        $l->contactNumber = $r->personNumber;
        $l->countryId = $r->country;

        $l->minedBy = Auth::user()->id;
        $l->save();




        Session::flash('message', 'Lead Added successfully');
        return redirect()->route('addLead');



    }



}
