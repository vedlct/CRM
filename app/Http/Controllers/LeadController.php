<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Auth;
use Session;

use App\Category;
use App\Possibility;
use App\Country;
use App\Lead;
use App\DB;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        //Validating The input Filed
        $this->validate($r,[

            'companyName' => 'required|max:100',
            'website' => 'required|max:100',
            'email' => 'required|max:100',
            'category' => 'required',
            'possibility' => 'required',
            'personName' => 'required:max:100',
            'personNumber' => 'required|max:15|regex:/^[\+0-9\-\(\)\s]*$/',
            'country' => 'required',
            'country' => 'required',

        ]);

        //Inserting Data To Leads TAble

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
        $l->comments=$r->comment;

        //getting Loggedin User id
        $l->minedBy = Auth::user()->id;
        $l->save();



        //for Flash Meassage
        Session::flash('message', 'Lead Added successfully');
        return redirect()->route('addLead');



    }


    public function assignShow(){
        //$leads=Lead::where('statusId', 1)->get();
        $leads=(new Lead())->getTempLead();

        $users=User::select('id','firstName')->where('id','!=',Auth::user()->id)->get();


        return view('layouts.lead.assignLead')
            ->with('leads',$leads)
            ->with('users',$users);
    }



    public function assignStore(Request $r){

        $this->validate($r,[

            'userName' => 'required',
            'leadId' => 'required',


        ]);

      //  $lead=Lead::findOrFail($r->leadId);




        return $r;

    }



}
