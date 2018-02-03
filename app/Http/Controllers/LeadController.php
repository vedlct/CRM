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
use DataTables;


class LeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(){
        //for RA
        $User_Type=Session::get('userType');
        if($User_Type=='RA'){

            $cats=Category::where('type', 1)->get();
            $countries=Country::get();

            return view('layouts.lead.add')
                ->with('cats',$cats)
                ->with('countries',$countries);}
        return Redirect()->route('home');
    }

    public function store(Request $r){
        //Validating The input Filed
        $this->validate($r,[
            'companyName' => 'required|max:100',
            'website' => 'required|max:100',
            'email' => 'required|max:100',
            'category' => 'required',
            'personName' => 'required|max:100',
            'personNumber' => 'required|max:15|regex:/^[\0-9\-\(\)\s]*$/',
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

//        return Auth::user()->teamId;
        $User_Type=Session::get('userType');
        if($User_Type == 'RA' || $User_Type == 'MANAGER'){

//            $leads=(new Lead())->showNotAssignedLeads();
//            $leads=$leads
//                ->limit(100)
//                ->get();

            //getting only first name of users
            if($User_Type == 'RA'){
                $users=User::select('id','firstName','lastName')
                    ->where('id','!=',Auth::user()->id)
                    ->Where('typeId',5)
                    ->get();
            }

            else{
                $users=User::select('id','firstName','lastName')
                    ->where('teamId',Auth::user()->teamId)
                    ->Where('typeId',5)
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

        return DataTables::of($leads)
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


        $categories=Category::where('type',1)
        ->get();



        return view('layouts.lead.filterLead')->with('categories',$categories);

    }

    public function getFilterLeads(Request $request){

        $leads=(new Lead())->showNotAssignedLeads();

        return DataTables::of($leads)
            ->addColumn('action', function ($lead) {
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

            return view('layouts.lead.myLead')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities);
        }

        return Redirect()->route('home');

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

        //For Ra
        $User_Type=Session::get('userType');
        if($User_Type=='RA' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){

            return view('layouts.lead.temp');
        }

        return Redirect()->route('home');


    }


    public function tempData(Request $request){

        $start = $request->input('start');
        $limit = $request->input('length');
        if(empty($request->input('search.value')))
        {
            $leads=(new Lead())->getTempLead($start,$limit,null);

        }
        else{

            $search = $request->input('search.value');
            $leads=(new Lead())->getTempLead($start,$limit,$search);

        }


        $totalData =Lead::where('statusId', 1)->count();
        $totalFiltered = $totalData;

        $possibility=Possibility::get();

        $pBefore='<select class="form-control" id="drop" ';

        $pAfter=' name="possibility" ><option value="">Select</option>';
        foreach ($possibility as $pos){
            $pAfter.='<option value="'.$pos->possibilityId.'">'.$pos->possibilityName.'</option>';
        }
        $pAfter.='</select>';


        $data = array();
        foreach ($leads as $lead){
            $nestedData['name'] = $lead->companyName;
            $nestedData['email'] = $lead->email;
            $nestedData['website'] = '<a href="http://'.$lead->website.'" target="_blank" >'.$lead->website.'</a>';
            $nestedData['category'] = $lead->category->categoryName;
            $nestedData['person'] = $lead->personName;
            $nestedData['number'] = $lead->contactNumber;
            $nestedData['country'] = $lead->country->countryName;
            $nestedData['minedBy']=$lead->mined->firstName;
            $nestedData['createdAt']=$lead->created_at;
            $nestedData['edit']='<a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                      data-lead-id="'.$lead->leadId.
                '"data-lead-name="'.$lead->companyName.'"
                                    data-lead-email="'.$lead->email.'"
                                    data-lead-number="'.$lead->contactNumber.'"
                                    data-lead-person="'.$lead->personName.'"
                                    data-lead-website="'.$lead->website.'">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            $nestedData['possibility']=$pBefore.'data-lead-id="'.$lead->leadId.'"'.$pAfter;
            $data[]=$nestedData;
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );


        return json_encode($json_data);


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
//            ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
//            ->where('leadassigneds.assignTo',Auth::user()->id)
//            ->where('leadassigneds.leaveDate',null)
                ->where('workprogress.userId',Auth::user()->id)
                ->distinct('workprogress.leadId')
                ->get();


            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities);}

        return Redirect()->route('home');


    }



    public function starLeads(){
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->where('possibilityId',4)
                ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
                ->where('leadassigneds.assignTo',Auth::user()->id)
                ->where('leadassigneds.leaveDate',null)
                ->get();

            $callReports=Callingreport::get();
            $possibilities=Possibility::get();

            return view('layouts.lead.starLead')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities);}
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

            $categories=Category::where('type',1)
                ->get();


            $leads=Lead::where('contactedUserId',Auth::user()->id)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            return view('layouts.lead.myLead')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);

        }

        return Redirect()->route('home');
    }

    public function rejectedLeads(){
        return view('layouts.lead.rejectedLead');
    }


    public function rejectData(Request $request)
    {

        $leads = Lead::with('mined')
            ->where('statusId',5);

        return DataTables::of($leads)->make(true);

    }


    public function rejectStore($id){

        $lead=Lead::findOrFail($id);
        if($lead->statusId ==1){
            $lead->statusId=5;
            $lead->save();
        }

        Session::flash('message', 'Lead Rejected Successfully');
        return back();

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
                $lead->contactedUserId =0;
                $lead->statusId=2;
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