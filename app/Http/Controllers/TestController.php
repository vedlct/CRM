<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use Illuminate\Http\Request;
use App\Workprogress;
use App\User;
use Auth;
use DB;
use App\Followup;
use App\Lead;
use App\Usertarget;
use App\Possibilitychange;
use App\Leadassigned;
use Carbon\Carbon;
use stdClass;
class TestController extends Controller
{
//    protected $pAfter = '';



    public function getTable(){
        $date = Carbon::now();
        $User_Type=Session::get('userType');

        if( $User_Type =='MANAGER'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else if($User_Type =='USER' || $User_Type =='RA'){
            $users=User::select('id','firstName','typeId')
                ->where('id',Auth::user()->id)
                ->get();

        }
        else{
            $users=User::select('id as userid','firstName','typeId')
                ->where('typeId','!=',1)
                ->get();
        }

        $usersRa=User::select('id as userid','firstName','typeId')
            ->where('typeId',4)
            ->get();




        $calledThisWeek=Workprogress::select('userId',DB::raw('count(*) as userCall'))
            ->where('workprogress.callingReport','!=',null)
            ->where('callingReport','!=',6)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


//        return $calledThisWeek;

        $leadMinedThisWeek=Lead::select('minedBy',DB::raw('count(*) as userLeadMined'))
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
           ->get();


//        return $leadMinedThisWeek;

        $followupThisWeek=Workprogress::select('userId',DB::raw('count(*) as userFollowup'))
            ->where('callingReport',4)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


//        return $followupThisWeek;

        $highPosibilitiesThisWeekRa=Lead::select('minedBy',DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility',3)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();

//        return $highPosibilitiesThisWeekRa;

        $highPosibilitiesThisWeekUser=Possibilitychange::select('userId',DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId',3)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead=Leadassigned::select('assignTo',DB::raw('count(*) as userAssignedLead'))
            ->whereBetween('created_at',[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $uniqueHighPosibilitiesThisWeek=Possibilitychange::select('userId',DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId',3)
            ->whereBetween('created_at',[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead=Workprogress::select('userId',DB::raw('count(leadId) as userTestLead'))
            ->where('progress','Test Job')
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted=Workprogress::select('userId',DB::raw('count(*) as userContacted'))
            ->where('callingReport',5)
            ->whereBetween('created_at',[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $contacted;

//            USA
        $contactedUsa=Workprogress::select('userId',DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads','workprogress.leadId','leads.leadId')
            ->leftJoin('countries','leads.countryId','countries.countryId')
            ->where('countries.countryName','like','%USA%')
            ->where('callingReport',5)
            ->whereBetween('workprogress.created_at',[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;




        return view('test')
            ->with('users', $users)
            ->with('contactedUsa',$contactedUsa)
            ->with('contacted',$contacted)
            ->with('testLead',$testLead)
            ->with('uniqueHighPosibilitiesThisWeek',$uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead',$assignedLead)
            ->with('highPosibilitiesThisWeekUser',$highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa',$highPosibilitiesThisWeekRa)
            ->with('followupThisWeek',$followupThisWeek)
            ->with('leadMinedThisWeek',$leadMinedThisWeek)
            ->with('calledThisWeek',$calledThisWeek)
            ->with('usersRa',$usersRa);

    }

    public function index(){
        return view('layouts.lead.testList');
    }

    public function modal(){
    $v="value";
        return view('modal')->with('v',$v);
    }

    public function test(){
       // $leads = Lead::get();
////
////        return $leads;
//
//        return view('test');


// Execute the query

//        $leads=Lead::with('mined','category','country','possibility')
//            ->where('statusId',2)
//            ->where(function($q){
//                $q->orWhere('contactedUserId',0)
//                    ->orWhere('contactedUserId',null);
//            })
//            ->where('leadAssignStatus',0)
//            ->select('leads.*')->get();
       $time=(new Test())->test();
        return $time;




    }
    public function anyData(Request $r)
    {
//        $possibility=Possibility::get();
//
//        $pBefore='<select class="form-control" id="drop" ';
//        $pAfter=' name="possibility" ><option value="">Select</option>';
//        foreach ($possibility as $pos){
//            $pAfter.='<option value="'.$pos->possibilityId.'">'.$pos->possibilityName.'</option>';
//        }
//        $pAfter.='</select>';
//
//        $leads=Lead::select('leadId','companyName','personName','email','contactNumber','created_at');
//        return DataTables::of($leads,$pBefore,$pAfter)
//            ->addColumn('action', function ($lead) {
//                return '<a href="'.$lead->leadId.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
//            })
//            ->addColumn('drop', function ($lead,$pBefore,$pAfter) {
//                return $pBefore.$lead->leadId.' "'.$pAfter;
//            })
//            ->make(true);

        $leads = Lead::with('mined')
        ->where('statusId',5)->get();

        return DataTables::of($leads)->make(true);



    }
}
