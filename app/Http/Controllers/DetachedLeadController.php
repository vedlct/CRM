<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Lead;
use App\User;
use App\Leadassigned;
use DB;
use Session;

class DetachedLeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $User_Type=Session::get('userType');
        if($User_Type=='MANAGER'){
            $users=User::where('teamId',Auth::user()->teamId)->get();

            $leads=Leadassigned::select('leads.*','leadassigneds.*')
                ->leftJoin('leads','leads.leadId','leadassigneds.leadId')
                ->where('leaveDate',null)->get();


            return view('layouts.DetachedLead.index')
                ->with('leads',$leads)
                ->with('users',$users);
        }

        return Redirect()->route('home');
    }


    public function detached(Request $r){
        $assignId=Leadassigned::select('assignId')
            ->where('leadId',$r->leadId)
            ->where('assignTo',$r->userId)
            ->where('leaveDate',null)
            ->limit(1)->first();

        $leave=Leadassigned::find($assignId->assignId);
        $leave->leaveDate=date('Y-m-d');
        $leave->save();

        $l=Lead::findOrFail($r->leadId);
        $l->leadAssignStatus=null;
        $l->save();

        Session::flash('message', 'Lead successfully Detached');
        return back();

    }



}
