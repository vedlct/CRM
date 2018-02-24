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
use App\Callingreport;
use App\Possibility;
use App\Category;
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

        $day = Carbon::now()->format( 'l' );
        return $day;

        $calledThisWeek=Workprogress::where('userId',Auth::user()->id)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();




        $leadMinedThisWeek=Lead::where('minedBy',Auth::user()->id)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();


        $highPosibilitiesThisWeek=Possibilitychange::where('userId',Auth::user()->id)
            ->where('possibilityId',3)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();



        $lastDate=Carbon::now()->subDay()->format('Y-m-d');



        $lastDayCalled=Workprogress::where('userId',Auth::user()->id)
            ->where('workprogress.callingReport','!=',null)
            ->whereDate('created_at',$lastDate)->count();

        $lastDayLeadMined=Lead::where('minedBy',Auth::user()->id)
            ->whereDate('created_at',$lastDate)->count();

        $User_Type=Session::get('userType');
        if($User_Type=='RA'){
            $highPosibilities=Lead::select('leads.*')
                ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                ->where('leads.minedBy',Auth::user()->id)
                ->where('possibilitychanges.possibilityId',3)
                ->whereBetween('possibilitychanges.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

        }

        else{
            $highPosibilities=Possibilitychange::where('userId',Auth::user()->id)
                ->where('possibilityId',3)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

        }



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
            if($calledThisWeek>100){
                $calledThisWeek=100;
            }
            $countWeek++;
        }

        if($target->targetLeadmine>0){
            $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine*5))*100);
            if($leadMinedThisWeek>100){
                $leadMinedThisWeek=100;
            }
            $countWeek++;
        }

        if($target->targetHighPossibility>0){
            $highPosibilitiesThisWeek=round(($highPosibilitiesThisWeek/($target->targetHighPossibility))*100);
            if($highPosibilitiesThisWeek>100){
                $highPosibilitiesThisWeek=100;
            }
            $countWeek++;
        }


        return view('dashboard')
            ->with('target',$target)
            ->with('lastDayLeadMined',$lastDayLeadMined)
            ->with('highPosibilities',$highPosibilities)
            ->with('lastDayCalled',$lastDayCalled)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('leadMinedThisWeek',$leadMinedThisWeek)
            ->with('highPosibilitiesThisWeek',$highPosibilitiesThisWeek)
            ->with('countWeek',$countWeek);


    }



    public  function call(){
        $date = Carbon::now();
        $leads=Lead::select('leads.*','workprogress.created_at')
            ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
            ->where('workprogress.userId',Auth::user()->id)
            ->where('workprogress.callingReport','!=',null)
            ->whereBetween('workprogress.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->get();

        $callReports = Callingreport::get();
        $possibilities = Possibility::get();
        $categories=Category::where('type',1)->get();

        return view('report.weekly')
            ->with('leads', $leads)
            ->with('callReports', $callReports)
            ->with('possibilities', $possibilities)
            ->with('categories',$categories);

    }



 public function highPossibility(){
     $date = Carbon::now();


     $User_Type=Session::get('userType');
     if($User_Type=='RA'){
         $leads=Lead::select('leads.*','possibilitychanges.created_at')
             ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
             ->where('leads.minedBy',Auth::user()->id)
             ->where('possibilitychanges.possibilityId',3)
             ->whereBetween('possibilitychanges.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->get();

     }

    else{
        $leads=Lead::select('leads.*','possibilitychanges.created_at')
            ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
            ->where('possibilitychanges.userId',Auth::user()->id)
            ->where('possibilitychanges.possibilityId',3)
            ->whereBetween('possibilitychanges.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->get();

    }



     $callReports = Callingreport::get();
     $possibilities = Possibility::get();
     $categories=Category::where('type',1)->get();

     return view('report.weekly')
         ->with('leads', $leads)
         ->with('callReports', $callReports)
         ->with('possibilities', $possibilities)
         ->with('categories',$categories);



 }


}