<?php

namespace App\Http\Controllers;

use App\Category;
use App\Lead;
use App\Possibility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LocalLead;
use App\Area;
use Illuminate\Support\Facades\Auth;
use Session;
use Yajra\DataTables\DataTables;
use App\LocalLeadAssign;
class LocalLeadController extends Controller
{
    public function all(){
        $cats=Category::where('type', 3)->get();
        $areas=Area::get();
        $possibilities=Possibility::get();

        return view('local-lead.all')
            ->with('categories',$cats)
            ->with('areas',$areas)
            ->with('possibilities',$possibilities);

    }

    public function getLeadData(Request $r){
        $lead=LocalLead::select('local_lead.local_leadId','local_lead.companyName','website','mobile','tnt','categories.categoryName','area.areaName','address','local_lead.statusId','possibilities.possibilityName')
            ->leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
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

        $lead->companyName=$r->companyName;
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

        $lead=LocalLead::leftJoin('area','area.areaId','local_lead.areaId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('possibilities','possibilities.possibilityId','local_lead.possibilityId')
            ->leftJoin('local_lead_assign','local_lead_assign.local_leadId','local_lead.local_leadId')
            ->where('local_lead_assign.userId',Auth::user()->id)
            ->get();

        $datatables = Datatables::of($lead);
        return $datatables->make(true);


    }

    public function getEditModal(Request $r){
        $lead=LocalLead::findOrFail($r->leadId);

        $cats=Category::where('type', 3)->get();
        $areas=Area::get();
        $possibilities=Possibility::get();

        return view('local-lead.getEditModal')
            ->with('categories',$cats)
            ->with('areas',$areas)
            ->with('possibilities',$possibilities)
            ->with('lead',$lead);
    }


    public function assignLead(){


        return view('local-lead.assignLead');
    }

    public function getAssignLead(Request $r){
        $lead=LocalLead::select('local_lead.local_leadId','local_lead.companyName','website','mobile','tnt','categories.categoryName','area.areaName','address','local_lead.statusId','possibilities.possibilityName')
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
}
