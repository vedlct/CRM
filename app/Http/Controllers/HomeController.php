<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Auth;
use Session;
use App\Workprogress;
use App\Followup;
use App\Lead;
use App\User;
use App\Possibilitychange;
use App\Usertarget;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $date = Carbon::now();
//        $totalFollowUp=Followup::where('userId',Auth::user()->id)
//            ->whereBetween('followUpDate', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
//        $totalFollowUpCalled=Workprogress::where('userId',Auth::user()->id)
//            ->where('callingReport',4)
//            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

        $calledThisWeek=Workprogress::where('userId',Auth::user()->id)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();




        $leadMinedThisWeek=Lead::where('minedBy',Auth::user()->id)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

        $highPosibilitiesThisWeek=Possibilitychange::where('userId',Auth::user()->id)
            ->where('possibilityId',3)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();




        $lastDate=Carbon::now()->subDay()->format('Y-m-d');



        $lastDayCalled=Workprogress::where('userId',Auth::user()->id)
            ->whereDate('created_at',$lastDate)->count();

        $lastDayLeadMined=Lead::where('minedBy',Auth::user()->id)
            ->whereDate('created_at',$lastDate)->count();

        $highPosibilities=Possibilitychange::where('userId',Auth::user()->id)
            ->where('possibilityId',3)
            ->whereDate('created_at',$lastDate)->count();


        try{
            $target=Usertarget::findOrFail(Auth::user()->id);
        }
        catch (ModelNotFoundException $ex) {

            $target=new Usertarget;
            $target->userId=Auth::user()->id;
            $target->targetCall=0;
            $target->targetHighPossibility=0;
            $target->targetLeadmine=0;
            $target->save();


        }



        $countWeek=0;

        //Weekly Report
        if($target->targetCall>0){
            $calledThisWeek=round(($calledThisWeek/($target->targetCall*5))*100);
            $countWeek++;
        }

        if($target->targetLeadmine>0){
            $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine*5))*100);
            $countWeek++;
        }

        if($target->targetHighPossibility>0){
            $highPosibilitiesThisWeek=round(($highPosibilitiesThisWeek/($target->targetHighPossibility))*100);
            $countWeek++;
        }











//
//        if($User_Type=='MANAGER') {
//            $teamMembers = User::select('id', 'firstName', 'lastName', 'typeId')
//                ->where('teamId', Auth::user()->teamId)
//                ->where('teamId', '!=', null)
//                ->get();
//        }
//        else if($User_Type=='ADMIN' || $User_Type =='SUPERVISOR'){
//            $teamMembers = User::select('id', 'firstName', 'lastName', 'typeId')
////                ->where('teamId', Auth::user()->teamId)
////                ->where('teamId', '!=', null)
//                ->get();
//
//        }
//        else{
//            $teamMembers=0;
//        }


        //Graph Access for Manager /SuperVisor / Admin

        return view('dashboard')
            ->with('target',$target)
            ->with('lastDayLeadMined',$lastDayLeadMined)
            ->with('highPosibilities',$highPosibilities)
            ->with('lastDayCalled',$lastDayCalled)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('leadMinedThisWeek',$leadMinedThisWeek)
            ->with('highPosibilitiesThisWeek',$highPosibilitiesThisWeek)
            ->with('countWeek',$countWeek);

//            ->with('teamMembers',$teamMembers);
    }
}