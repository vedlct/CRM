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
use App\Leadstatus;
use DB;
use DataTables;


class LeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function allLeads(Request $r){
        $leads=Lead::with('country','category','mined','status','contact','possibility')
                    ->orderBy('leadId','desc');



        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                return '<a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"
                                            ><i class="fa fa-comments"></i></a>';
            })

            ->make(true);

    }

    public function add(){
        
            $cats=Category::where('type', 1)->get();
            $countries=Country::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.add')
                ->with('categories',$cats)
                ->with('countries',$countries)
                ->with('possibilities',$possibilities);

    }

    public function numberCheck(Request $r){
        $number=Lead::where('contactNumber',$r->number)->count();

        return Response($number);
    }

    public function store(Request $r){
        //Validating The input Filed

        $this->validate($r,[
            'companyName' => 'required|max:100',
            'website' => 'max:100',
            'email' => 'max:100',
            'personName' => 'max:100',
            'personNumber' => 'required|max:15|unique:leads,contactNumber|regex:/^[\0-9\-\(\)\s]*$/',
            'designation'=>'max:100'
        ]);

        //Inserting Data To Leads TAble
        $l=new Lead;
        if($r->contact){
            $l->statusId = 7;
            $l->contactedUserId=Auth::user()->id;
        }
        else{
            $l->statusId = 1;
        }

        $l->possibilityId=$r->possibility;
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
        return back();

    }


    public function assignShow(){


        $User_Type=Session::get('userType');
        if($User_Type == 'RA' || $User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR'){



            //getting only first name of users
            if($User_Type == 'RA' || $User_Type == 'SUPERVISOR'){
                $users=User::select('id','firstName','lastName')
                    ->where('id','!=',Auth::user()->id)
                    ->where('typeId',5)
                    ->orWhere('typeId',2)
                    ->orWhere('typeId',3)
                    ->get();
            }

            else{
                $users=User::select('id','firstName','lastName')
                    ->where('teamId',Auth::user()->teamId)
                    ->where('teamId','!=',null)
                    ->get();
            }


            return view('layouts.lead.assignLead')
//                ->with('leads',$leads)
                ->with('users',$users);
        }

        return Redirect()->route('home');

    }


    public function getAssignLeadData(){

        $leads=(new Lead())->showNotAssignedLeads();

        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="'.$lead->leadId.'">';

            })
            ->make(true);


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
            'companyName' => 'max:100',
            'website' => 'max:100',
            'email' => 'max:100',
            'personName' => 'max:100',
            'number' => 'required|max:15|regex:/^[\+0-9\-\(\)\s]*$/',

        ]);



        $lead=Lead::findOrFail($r->leadId);
        $lead->companyName=$r->companyName;
        $lead->email=$r->email;
        $lead->categoryId=$r->category;
        $lead->personName=$r->personName;
        $lead->contactNumber=$r->number;
        $lead->website=$r->website;
        $lead->save();
        Session::flash('message', 'Lead Edited successfully');
        return back();
    }





    public function filter(){


        $categories=Category::where('type',1)
        ->get();



        return view('layouts.lead.filterLead')->with('categories',$categories);

    }

    public function getFilterLeads(Request $request){

        $leads=(new Lead())->showNotAssignedLeads();


        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                if(Session::get('userType')=='RA'){
                    return '<a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                           
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    ';

                }

                else{
                    return '<form method="post" action="'.route('addContacted').'">
                                        <input type="hidden" name="_token" id="csrf-token" value="'.csrf_token().'" />
                                        <input type="hidden" value="'.$lead->leadId.'" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                        <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                           
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    </form>';

                }

            })
            ->make(true);

    }





    public function assignedLeads(){
        //will return the leads assigned to you
        //for user
        $User_Type=Session::get('userType');

        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR') {
            $leads = (new Lead())->myLeads();
            $callReports = Callingreport::get();
            $possibilities = Possibility::get();
            $categories=Category::where('type',1)->get();
            $status=Leadstatus::where('statusId','!=',7)
                    ->get();


            return view('layouts.lead.myLead')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('categories',$categories)
                ->with('status',$status);
        }

        return Redirect()->route('home');

    }





    public function getComments(Request $r){
        if($r->ajax()){
            $comments=Workprogress::select(['users.firstName','comments','workprogress.created_at'])
                ->where('workprogress.leadId',$r->leadId)
                ->leftJoin('users','users.id','workprogress.userId')
                ->get();
            $text='';
            foreach ($comments as $comment){

                $text.='<li class="list-group-item list-group-item-action"><b>'.$comment->comments.'</b> <div style="color:blue;">-By '.$comment->firstName.' ('.$comment->created_at.')</div>'.'</li>';

            }
            return Response($text);
        }

    }



    public function tempLeads(){



        //For Ra
        $User_Type=Session::get('userType');
        if($User_Type=='RA' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR' || $User_Type=='ADMIN'){
            $categories=Category::where('type',1)->get();
            $countries=Country::get();

            return view('layouts.lead.temp')
                    ->with('categories',$categories)
                    ->with('countries',$countries);
        }

        return Redirect()->route('home');


    }


    public function tempData(Request $request){


        $possibility=Possibility::get();

        $pBefore='<select class="form-control" id="drop" ';

        $pAfter=' name="possibility" ><option value="">Select</option>';
        foreach ($possibility as $pos){
            $pAfter.='<option value="'.$pos->possibilityId.'">'.$pos->possibilityName.'</option>';
        }
        $pAfter.='</select>';

        $leads=(new Lead())->getTempLead();



        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) use ($pAfter,$pBefore){
                return $pBefore.'data-lead-id="'.$lead->leadId.'"'.$pAfter;
            })
            ->addColumn('edit', function ($lead) use ($pAfter,$pBefore){
                return '<a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                      data-lead-id="'.$lead->leadId.
                                    '"data-lead-name="'.$lead->companyName.'"
                                    data-lead-email="'.$lead->email.'"
                                    data-lead-number="'.$lead->contactNumber.'"
                                    data-lead-person="'.$lead->personName.'"
                                    data-lead-website="'.$lead->website.'"
                                    data-lead-mined="'.$lead->mined->firstName.'"
                                    data-lead-category="'.$lead->category->categoryId.'">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['edit', 'action'])
            ->make(true);






    }



    public function changePossibility(Request $r){

        //return Response($r);

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


        if($r->report==4){
            if($r->followup !=null) {
                $f = Followup::where('leadId', $r->leadId)
                    ->where('userId', Auth::user()->id)->first();

                $update = Followup::findOrFail($f->followId);
                $update->workStatus = 1;
                $update->save();
            }

        }



        $workStatus=Leadassigned::where('leadId',$r->leadId)
                ->where('assignTo',Auth::user()->id)
                ->where('workStatus',0)
                ->first();


        if($workStatus != 0){
            $leadAssigned=Leadassigned::findOrFail($workStatus->assignId);
            $leadAssigned->workStatus=1;
            $leadAssigned->save();
        }



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
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->leftJoin('workprogress','workprogress.leadId','=','leads.leadId')
                ->where('workprogress.progress','Test Job')
                ->with('category','country','mined')
                ->where('workprogress.userId',Auth::user()->id)
                ->distinct('workprogress.leadId')
                ->get();

            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);}

        return Redirect()->route('home');


    }


    public function closeLeads(){

        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->with('category','country')
                ->leftJoin('workprogress','workprogress.leadId','=','leads.leadId')
                ->where('workprogress.progress','Closing')
                ->where('workprogress.userId',Auth::user()->id)
                ->distinct('workprogress.leadId')
                ->get();

            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);}

        return Redirect()->route('home');



    }

   public function rejectlist(){
       $User_Type=Session::get('userType');
       if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR') {

           $leads=Lead::select('leads.*','workprogress.comments','workprogress.created_at','users.firstName')
               ->with('category','country')
               ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
               ->leftJoin('users','workprogress.userId','users.id')
               ->where('workprogress.progress','Reject')
               ->where('minedBy',Auth::user()->id)
               ->where('statusId',5)->get();

           $categories=Category::where('type',1)->get();
           $callReports=Callingreport::get();
           $possibilities=Possibility::get();

//            return $leads;

           return view('layouts.lead.rejectList')
               ->with('leads',$leads)
               ->with('callReports',$callReports)
               ->with('possibilities',$possibilities)
               ->with('categories',$categories);

   }

       return Redirect()->route('home');



   }



    public function starLeads(){
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->where('possibilityId',4)
                ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
                ->where(function($q){
                    $q->where('leadassigneds.assignTo',Auth::user()->id)
                        ->where('leadassigneds.leaveDate',null)
                        ->orWhere('contactedUserId',Auth::user()->id);

                })
//                ->where('leadassigneds.assignTo',Auth::user()->id)
//                ->where('leadassigneds.leaveDate',null)

                ->get();

            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            $categories=Category::where('type',1)->get();


            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);}
        return Redirect()->route('home');

    }


    public function addContacted(Request $r){

        $lead=Lead::findOrFail($r->leadId);
        $lead->contactedUserId=Auth::user()->id;
        $lead->statusId=7;
        $lead->save();
        Session::flash('message', 'Lead Added To Contacted List');
        return back();
    }

    public function contacted(){
        //For user
        $User_Type=Session::get('userType');

        if($User_Type=='SUPERVISOR' || $User_Type=='USER' || $User_Type=='MANAGER'){

            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            $status=Leadstatus::where('statusId','!=',7)
                ->get();
            return view('layouts.lead.contact')
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories)
                ->with('status',$status);

        }

        return Redirect()->route('home');
    }


    public function getContacedData(Request $r){

        $leads=Lead::with('mined','category','country','possibility')
            ->where('contactedUserId',Auth::user()->id)
            ->orderBy('leadId','desc');

        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                return '<a href="#my_modal" data-toggle="modal" class="btn btn-success btn-sm"
                                   data-lead-id="'.$lead->leadId.'"
                                   data-lead-possibility="'.$lead->possibilityId.'">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                                <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                   data-lead-id="'.$lead->leadId.'"
                                   data-lead-name="'.$lead->companyName.'"
                                   data-lead-email="'.$lead->email.'"
                                   data-lead-number="'.$lead->contactNumber.'"
                                   data-lead-person="'.$lead->personName.'"
                                   data-lead-website="'.$lead->website.'"
                                   data-lead-mined="'.$lead->mined->firstName.'"
                                   data-lead-category="'.$lead->category->categoryId.'"

                                >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            })
            ->make(true);


    }



    public function rejectedLeads(){
        return view('layouts.lead.rejectedLead');
    }


    public function rejectData(Request $request)
    {

        $leads = Lead::with('mined')
            ->where('statusId',5);

        return DataTables::eloquent($leads)->make(true);

    }


    public function rejectStore(Request $r){


        $lead=Lead::findOrFail($r->leadId);
        if($lead->statusId ==1){
            $lead->statusId=5;
            $lead->save();

            $work=new Workprogress;
            $work->progress='Reject';
            $work->leadId=$r->leadId;
            $work->userId=Auth::user()->id;
            $work->comments=$r->comment;
            $work->save();
        }

        Session::flash('message', 'Lead Rejected Successfully');
        return back();

    }

    public function leaveLead(Request $r){

        $assignId=Leadassigned::select('assignId')
            ->where('leadId',$r->leadId)
            ->where('assignTo',Auth::user()->id)
            ->where('leaveDate',null)
            ->limit(1)->first();


        if ($assignId){
            $leave=Leadassigned::find($assignId->assignId);
            $leave->leaveDate=date('Y-m-d');
            $leave->save();

            $l=Lead::findOrFail($leave->leadId);
            $l->leadAssignStatus=0;
            $l->save();


        }


            $lead=Lead::findOrFail($r->leadId);
            $lead->statusId=$r->Status;
            if($lead->contactedUserId == Auth::user()->id){
                $lead->contactedUserId =null;
                $lead->save();
                Session::flash('message', 'You have Leave The Lead successfully');
                return back();
            }

            $lead->save();
            Session::flash('message', 'You have Leave The Lead successfully');
            return back();



    }

    public function destroy($id){
        $lead=Lead::findOrFail($id);
        $lead->delete();
        Session::flash('message', 'Lead deleted successfully');
        return back();
    }



}