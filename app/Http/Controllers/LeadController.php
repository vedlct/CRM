<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use Auth;
use League\Flysystem\Exception;
use Session;
use Psy\Exception\ErrorException;
use App\Category;
use App\Possibility;
use App\Country;
use App\Lead;
use App\User;
use App\Leadassigned;
use App\Possibilitychange;
use App\Callingreport;
use App\Workprogress;
use App\Followup;
use DB;

use Yajra\Datatables\Datatables;
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
            'personName' => 'required|max:100',
            'personNumber' => 'required|max:15|regex:/^[\+0-9\-\(\)\s]*$/',
            'country' => 'required',
            'country' => 'required',
            'designation'=>'required|max:100'
        ]);

        //Inserting Data To Leads TAble
        $l=new Lead;
        $l->statusId = 1;
        $l->categoryId = $r->category;
        $l->companyName = $r->companyName;
        $l->personName= $r->personName;
        $l->designation=$r->designation;
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

        $leads=(new Lead())->showNotAssignedLeads();

        //getting only first name of users
        $users=User::select('id','firstName','lastName')
//            ->where('id','!=',Auth::user()->id)
            ->Where('typeId','!=',1)
            ->get();


        return view('layouts.lead.assignLead')
            ->with('leads',$leads)
            ->with('users',$users);


    }




    public function assignStore(Request $r){

        if($r->ajax()){
            foreach ($r->leadId as $lead){
                $l=Lead::findOrFail($lead);
                $l->leadAssignStatus=1;
                $l->save();

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


    public function update(Request $r){
        $this->validate($r,[
            'companyName' => 'required|max:100',
            'website' => 'required|max:100',
            'email' => 'required|max:100',
            'personName' => 'required|max:100',
            'number' => 'required|max:15|regex:/^[\+0-9\-\(\)\s]*$/',

        ]);



        $lead=Lead::findOrFail($r->leadId);
        $lead->companyName=$r->companyName;
        $lead->email=$r->email;
        $lead->personName=$r->personName;
        $lead->contactNumber=$r->number;
        $lead->website=$r->website;
        $lead->save();
        Session::flash('message', 'Lead Edited successfully');
        return back();
    }





        public function filter(){
//            $leads=Lead::with('assigned')->where('statusId', 2)->get();
            $leads=(new Lead())->showNotAssignedLeads();
            return view('layouts.lead.filterLead')->with('leads',$leads);
        }





        public function assignedLeads(){
            //will return the leads assigned to you
            $leads=(new Lead())->myLeads();

            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.myLead')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities);
        }






        public function getComments(Request $r){
            if($r->ajax()){
                $comments=Workprogress::select(['comments','created_at'])->where('leadId',$r->leadId)->get();
                $text='';
                foreach ($comments as $comment){

                    $text.='<li class="list-group-item list-group-item-action"><b>'.$comment->comments.'</b> -('.$comment->created_at.')'.'</li>';

                }
                return Response($text);
            }

        }



        public function tempLeads(){
            $leads=(new Lead())->getTempLead();

           $possibilities=Possibility::get();
           return view('layouts.lead.temp')
                ->with('leads',$leads)
                ->with('possibilities',$possibilities);

        }

        public function changePossibility(Request $r){

            if($r->ajax()){
                $lead=Lead::findOrFail($r->leadId);
                $lead->possibilityId=$r->possibility;
                $lead->statusId=2;
                $lead->save();

                $log=new Possibilitychange;
                $log->leadId=$r->leadId;
                $log->possibilityId=$r->possibility;
                $log->userId=Auth::user()->id;
                $log->save();
                return Response('true');
            }
        }




        public function storeReport(Request $r){
            $this->validate($r,[
                'leadId'=>'required',
                'report' => 'required',
                'comment' => 'required|max:300',

            ]);
            if($r->followup !=null){
                $followUp=New Followup;
                $followUp->leadId=$r->leadId;
                $followUp->userId=Auth::user()->id;
                $followUp->followUpDate=$r->followup;
                $followUp->save();

            }

            //posssibility Change
            $lead=Lead::findOrFail($r->leadId);
            $currentPossibility=$lead->possibilityId;
            $lead->possibilityId=$r->possibility;
            $lead->save();

            if($currentPossibility !=$r->possibility){
                $log=new Possibilitychange;
                $log->leadId=$r->leadId;
                $log->possibilityId=$r->possibility;
                $log->userId=Auth::user()->id;
                $log->save();
            }


            $progress=New Workprogress;
            $progress->callingReport=$r->report;
//            $progress->response=$r->response;
            $progress->leadId=$r->leadId;
            $progress->progress=$r->progress;
            $progress->userId=Auth::user()->id;
            $progress->comments=$r->comment;
            $progress->save();

            Session::flash('message', 'Report Updated Successfully');
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

    public function testLeads(){
            //select * from leads where leadId in(select leadId from workprogress where progress ='Test job')

//        $leads=Lead::select('leads.*')
//            ->where('possibilityId',4)
//            ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
//            ->where('leadassigneds.assignTo',Auth::user()->id)
//            ->where('leadassigneds.leaveDate',null)
//            ->get();
//

        $leads=Lead::select('leads.*')
            ->leftJoin('workprogress','workprogress.leadId','=','leads.leadId')
            ->where('workprogress.progress','Test job')
            ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
            ->where('leadassigneds.assignTo',Auth::user()->id)
            ->where('leadassigneds.leaveDate',null)
            ->get();


        $callReports=Callingreport::get();
        $possibilities=Possibility::get();

        return view('layouts.lead.testList')
            ->with('leads',$leads)
            ->with('callReports',$callReports)
            ->with('possibilities',$possibilities);

    }



        public function starLeads(){
            $leads=Lead::select('leads.*')
                ->where('possibilityId',4)
                ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
                ->where('leadassigneds.assignTo',Auth::user()->id)
                ->where('leadassigneds.leaveDate',null)
                ->get();

////            $leads=(new Lead())->myLeads();
//            $leads=Lead::select('leads.*')
//                ->where('possibilityId',4)
//                ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
//                ->where('leadassigneds.assignTo',Auth::user()->id)
//                ->Where('leadassigneds.leadAssignStatus',1)
//                ->get();

            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.starLead')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities);
        }


        public function addContacted(Request $r){
            $lead=Lead::findOrFail($r->leadId);
            $lead->contactedUserId=Auth::user()->id;
            $lead->save();
            Session::flash('message', 'Lead Added To Contacted List');
            return back();
        }

        public function contacted(){
            $leads=Lead::where('contactedUserId',Auth::user()->id)->get();

            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.myLead')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities);

        }

        public function rejectedLeads(){
           $leads=Lead::where('possibilityId',5)->get();


            return view('layouts.lead.rejectedLead');
        }

    public function rejectData()
    {
        $leads = Lead::with('category')->where('possibilityId',5)->get();

        return Datatables::of($leads)->make(true);
    }





        public function leaveLead($id){



                $assignId=Leadassigned::select('assignId')
                    ->where('leadId',$id)
                    ->where('assignTo',Auth::user()->id)
                    ->where('leaveDate',null)
                    ->limit(1)->first();


                if ($assignId){
                    $leave=Leadassigned::find($assignId->assignId);
                    $leave->leaveDate=date('Y-m-d');
                    $leave->save();

                    $l=Lead::findOrFail($leave->leadId);
                    $l->leadAssignStatus=null;
                    $l->save();

                    Session::flash('message', 'You have Leave The Lead successfully');
                    return back();
                }

                else{
                    $lead=Lead::findOrFail($id);
                    if($lead->contactedUserId == Auth::user()->id){
                        $lead->contactedUserId =null;
                        $lead->save();
                        Session::flash('message', 'You have Leave The Lead successfully');
                        return back();
                    }

                }

        }

        public function destroy($id){
            $lead=Lead::findOrFail($id);
            $lead->delete();
            Session::flash('message', 'Lead deleted successfully');
            return back();
    }



}
