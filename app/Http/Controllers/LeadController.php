<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Auth;
use Session;

use App\Category;
use App\Possibility;
use App\Country;
use App\Lead;
use App\User;
use App\Leadassigned;
use DB;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(){
        $cats=Category::where('type', 1)->get();


        $countries=Country::get();

        return view('layouts.lead.add')
            ->with('cats',$cats)
            ->with('countries',$countries);
    }

    public function store(Request $r){
        //Validating The input Filed
        $this->validate($r,[
            'companyName' => 'required|max:100',
            'website' => 'required|max:100',
            'email' => 'required|max:100',
            'category' => 'required',
            'personName' => 'required:max:100',
            'personNumber' => 'required|max:15|regex:/^[\+0-9\-\(\)\s]*$/',
            'country' => 'required',
            'country' => 'required',
        ]);

        //Inserting Data To Leads TAble
        $l=new Lead;
        $l->statusId = 1;
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

        $leads=(new Lead())->showAssignedLeads();

        //getting only first name of users
        $users=User::select('id','firstName','lastName')->where('id','!=',Auth::user()->id)->get();


        return view('layouts.lead.assignLead')
            ->with('leads',$leads)
            ->with('users',$users);
    }

    public function update(Request $r){


        return $r;
    }


    public function assignStore(Request $r){

        $jsonText = $r->leadId;
        $decodedText = html_entity_decode($jsonText);
        $leadIds = json_decode($decodedText, true);

        foreach ($leadIds as $leadId){
            $leadAssigned=new Leadassigned;
            $leadAssigned->assignBy=Auth::user()->id;
            $leadAssigned->assignTo=$r->assignTo;
            $leadAssigned->leadId=$leadId;
            $leadAssigned->save();

            }
        Session::flash('message', 'Lead assigned successfully');
            return back();
        }


        public function filter(){
            $leads=Lead::with('assigned')->where('statusId', 2)->get();

            return view('layouts.lead.filterLead')->with('leads',$leads);
        }


        public function destroy($id){
            $lead=Lead::findOrFail($id);
            $lead->delete();
            Session::flash('message', 'Lead deleted successfully');
            return back();
        }


        public function temperLeads(){
            $leads=(new Lead())->getTempLead();

           $possibilities=Possibility::get();


            return view('layouts.lead.temper')
                ->with('leads',$leads)
                ->with('possibilities',$possibilities);

        }

        public function changePossibility(Request $r){
            $lead=Lead::findOrFail($r->leadId);
            $lead->possibiliyId=$r->possibility;
            $lead->statusId=2;
            $lead->save();

            Session::flash('message', 'Possibility Added successfully');
            return back();
        }


        public function ajax(Request $r){

            if($r->ajax()){
                foreach ($r->leadId as $lead){
                    $leadAssigned=new Leadassigned;
                    $leadAssigned->assignBy=Auth::user()->id;
                    $leadAssigned->assignTo=$r->userId;
                    $leadAssigned->leadId=$lead;
                    $leadAssigned->save();



                }
                return Response('true');
               // return Response($r->leadId);
            }

        }



}
