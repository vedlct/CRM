<?php

namespace App\Http\Controllers;

use App\Category;
use App\Lead;
use App\LocalCompany;
use App\Possibility;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LocalLead;
use App\Area;
use App\LocalService;
use App\LocalLeadServiceRelation;
use App\LocalComment;
use App\LocalFollowup;
use Illuminate\Support\Facades\Auth;
use Session;
use Yajra\DataTables\DataTables;
use App\LocalLeadAssign;
use DB;

class LocalLeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function all(){
        $cats=Category::where('type', 3)->get();
        $areas=Area::get();
        $possibilities=Possibility::get();
        $services=LocalService::get();
        $companies=LocalCompany::get();


        return view('local-lead.all')
            ->with('categories',$cats)
            ->with('areas',$areas)
            ->with('possibilities',$possibilities)
            ->with('services',$services)
            ->with('companies',$companies);

    }

    public function getLeadData(Request $r){
        $lead=LocalLead::select('local_lead.local_leadId','local_company.companyName','local_lead.leadName','local_lead.website','local_lead.mobile','local_lead.tnt','categories.categoryName','area.areaName','local_lead.address','local_lead.statusId','possibilities.possibilityName')
            ->leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->leftJoin('possibilities','possibilities.possibilityId','local_lead.possibilityId')
            ->get();

        $datatables = Datatables::of($lead);
        return $datatables->make(true);


    }

    public function storeLead(Request $r){

        if($r->local_leadId){
            $lead=LocalLead::findOrFAil($r->local_leadId);
        }
        else{
            $lead=new LocalLead();
        }

        $lead->leadName=$r->leadName;
        $lead->local_companyId=$r->local_companyId;
        $lead->website=$r->website;
        $lead->contactPerson=$r->personName;
        $lead->email=$r->email;
        $lead->mobile=$r->mobile;
        $lead->tnt=$r->tnt;
        $lead->categoryId=$r->category;
        $lead->areaId=$r->areaId;
        $lead->possibilityId=$r->possibility;
        $lead->comment=$r->comment;
        $lead->address=$r->address;
        $lead->createdBy=Auth::user()->id;
        $lead->save();

        if($r->contact){
            $assign=new LocalLeadAssign();
            $assign->local_leadId=$lead->local_leadId;
            $assign->userId=Auth::user()->id;
            $assign->assignBy=Auth::user()->id;
            $assign->save();
        }

        $serviceRelation=LocalLeadServiceRelation::where('local_leadId',$lead->local_leadId)
            ->delete();

        foreach ($r->services as $service){
            $serviceRelation=new LocalLeadServiceRelation();
            $serviceRelation->local_leadId= $lead->local_leadId;
            $serviceRelation->serviceId= $service;
            $serviceRelation->save();
        }


        if($r->local_leadId){
            Session::flash('message', 'Lead Edited successfully');
        }
        else{

            Session::flash('message', 'Lead Added successfully');
        }

        return back();
    }

    public function myLead(){


        return view('local-lead.myLead');
    }

    public function getMyLead(Request $r){

        $lead=LocalLead::select('local_lead.local_leadId','local_company.companyName','local_lead.leadName','local_lead.website','local_lead.mobile','local_lead.tnt','categories.categoryName','area.areaName','local_lead.address','possibilities.possibilityName')
            ->leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('possibilities','possibilities.possibilityId','local_lead.possibilityId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->leftJoin('local_lead_assign','local_lead_assign.local_leadId','local_lead.local_leadId')
            ->where('local_lead_assign.userId',Auth::user()->id)
            ->get();

        $datatables = Datatables::of($lead);
        return $datatables->make(true);


    }

    public function getEditModal(Request $r){
        $lead=LocalLead::leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')->findOrFail($r->leadId);

        $cats=Category::where('type', 3)->get();
        $areas=Area::get();
        $possibilities=Possibility::get();
        $companies=LocalCompany::get();

        $localServices=LocalLeadServiceRelation::where('local_leadId',$lead->local_leadId)
            ->get();
        $services=LocalService::get();

        return view('local-lead.getEditModal')
            ->with('categories',$cats)
            ->with('areas',$areas)
            ->with('possibilities',$possibilities)
            ->with('lead',$lead)
            ->with('localServices',$localServices)
            ->with('services',$services)
            ->with('companies',$companies);
    }


    public function assignLead(){
        $assign=LocalLeadAssign::select('local_leadId',DB::raw('Count(local_leadId) as total'))->groupBy('local_leadId')->get();


        $leads=LocalLead::select('local_lead.local_leadId','local_lead.leadName','website','mobile','tnt','categories.categoryName','area.areaName','address','local_lead.statusId','possibilities.possibilityName')
            ->leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('possibilities','possibilities.possibilityId','local_lead.possibilityId')
            ->get();

        $users=User::select('id','firstName')->where('crmType','local')->get();


        return view('local-lead.assignLead')
            ->with('assign',$assign)
            ->with('leads',$leads)
            ->with('users',$users);
    }

    public function getAssignLead(Request $r){
        $lead=LocalLead::select('local_lead.local_leadId','local_lead.leadName','website','mobile','tnt','categories.categoryName','area.areaName','address','local_lead.statusId','possibilities.possibilityName')
            ->whereNotIn('local_leadId', function($q){
                $q->select('local_leadId')->from('local_lead_assign');
            })
            ->leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('possibilities','possibilities.possibilityId','local_lead.possibilityId')
            ->get();


        $datatables = Datatables::of($lead);

        return $datatables->make(true);


    }

    public function insertAssign(Request $r){
        foreach ($r->leadId as $local_leadId){
            $count=LocalLeadAssign::where('userId',$r->userId)->where('local_leadId',$local_leadId)->count();
            if($count==0){
                $assign=new LocalLeadAssign();
                $assign->local_leadId=$local_leadId;
                $assign->userId=$r->userId;
                $assign->assignBy=Auth::user()->id;
                $assign->save();
            }


        }
        Session::flash('message', 'Lead Assigned successfully');
    }

    public function getAssignedUsers(Request $r){
        $users=LocalLeadAssign::select('users.firstName as user','u2.firstName as assignBy','local_lead_assign.assignDate as date')->where('local_leadId',$r->leadid)
            ->leftJoin('users','users.id','local_lead_assign.userId')
            ->leftJoin('users as u2','u2.id','local_lead_assign.assignBy')
            ->get();

        return view('local-lead.getAssignedUsers',compact('users'));
    }

    public function getFollowupModal(Request $r){
        $comments=LocalComment::select('msg','users.firstName')->where('local_leadId',$r->leadId)
            ->leftJoin('users','users.id','local_comment.userId')
            ->get();

        $followup=LocalFollowup::where('local_leadId',$r->leadId)
            ->where('userId',Auth::user()->id)
            ->where('local_followup.workStatus',null)
            ->orderBy('local_followupId','desc')
            ->first();

        $count=LocalLeadAssign::where('local_leadId',$r->leadId)
            ->where('userId',Auth::user()->id)
            ->count();


        return view('local-lead.getFollowupModal')
            ->with('local_leadId',$r->leadId)
            ->with('comments',$comments)
            ->with('followup',$followup)
            ->with('count',$count);

    }

    public function insertCallReport(Request $r){
        LocalFollowup::where('local_followup.userId',Auth::user()->id)
            ->where('local_leadId',$r->local_leadId)
            ->update(['workStatus'=>1]);
        if($r->msg !=null){
            $comment=new LocalComment();
            $comment->local_leadId=$r->local_leadId;
            $comment->userId=Auth::user()->id;
            $comment->msg=$r->msg;
            $comment->save();
        }


        if($r->followup !=null){
            $followup=new LocalFollowup();
            $followup->local_leadId=$r->local_leadId;
            $followup->date=$r->followup;
            $followup->userId=Auth::user()->id;
            $followup->save();
        }

        Session::flash('message', 'Comment added successfully');
        return back();
    }

    public function todaysFollowup(){

        $leads=LocalFollowup::where('local_followup.userId',Auth::user()->id)
            ->where('local_followup.workStatus',null)
            ->leftJoin('local_lead','local_lead.local_leadId','local_followup.local_leadId')
            ->where(DB::raw('DATE(local_followup.date)'),date('Y-m-d'))
            ->leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('possibilities','possibilities.possibilityId','local_lead.possibilityId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->get();

        return view('local-lead.todaysFollowup',compact('leads'));
    }



}
