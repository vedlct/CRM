<?php
namespace App\Http\Controllers;
use App\LocalFollowup;
use App\LocalMeeting;
use App\LocalSales;
use App\LocalUserTarget;
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
use DB;
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
        if(Auth::user()->crmType=='local'){
            return $this->digitalMarketing();
        }

        $date = Carbon::now();

        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        $calledThisWeek=Workprogress::where('userId',Auth::user()->id)
            ->where('callingReport','!=',6)
            ->whereBetween('created_at', [$start, $end])->count();


        $leadMinedThisWeek=Lead::where('minedBy',Auth::user()->id)
            ->whereBetween('created_at', [$start, $end])->count();




        $contactThisWeek=Workprogress::where('userId',Auth::user()->id)
//            ->where('callingReport',5)
            ->where(function($q){
                $q->orWhere('callingReport',5)
                    ->orWhere('callingReport',4);
            })
            ->whereBetween('created_at', [$start, $end])->count();





        $day=Carbon::now()->format('l');

        $lastDate=Carbon::now()->subDay()->format('Y-m-d');


        if ($day=='Monday'){
            $lastDate=Carbon::now()->subDay(3)->format('Y-m-d');

        }


        $lastDayCalled=Workprogress::where('userId',Auth::user()->id)
            ->where('workprogress.callingReport','!=',null)
            ->where('callingReport','!=',6)
            ->whereBetween('created_at', [$start, $end])->count();

        $lastDayLeadMined=Lead::where('minedBy',Auth::user()->id)
            ->whereBetween('created_at', [$start, $end])->count();

        $lastDayContact= Workprogress::where('userId',Auth::user()->id)
//            ->where('callingReport',5)
            ->where(function($q){
                $q->orWhere('callingReport',5)
                    ->orWhere('callingReport',4);
            })
            ->whereBetween('created_at', [$start, $end])->count();

        $User_Type=Session::get('userType');
        if($User_Type=='RA'){
            $highPosibilities=Lead::select('leads.*')
                ->where('leads.minedBy',Auth::user()->id)
                ->where('filteredPossibility',3)
                ->whereBetween('created_at', [$start, $end])->count();

            $highPosibilitiesThisWeek=Lead::select('leads.*')
//                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                ->where('leads.minedBy',Auth::user()->id)
                ->where('filteredPossibility',3)
                ->whereBetween('created_at', [$start, $end])->count();

        }

        else{
            $highPosibilities=Possibilitychange::where('userId',Auth::user()->id)
                ->where('possibilityId',3)
                ->whereBetween('created_at', [$start, $end])->count();


            $highPosibilitiesThisWeek=Possibilitychange::where('userId',Auth::user()->id)
                ->where('possibilityId',3)
                ->whereBetween('created_at', [$start, $end])->count();
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
            $calledThisWeek=round(($calledThisWeek/($target->targetCall))*100);
            if($calledThisWeek>100){
                $calledThisWeek=100;
            }
            $countWeek++;
        }

        if($target->targetLeadmine>0){
            $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine))*100);
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

        if($target->targetContact>0){
            $contactThisWeek=round(($contactThisWeek/($target->targetContact))*100);
            if($contactThisWeek>100){
                $contactThisWeek=100;
            }
            $countWeek++;
        }



        return view('dashboard')
            ->with('target',$target)
            ->with('lastDayLeadMined',$lastDayLeadMined)
            ->with('highPosibilities',$highPosibilities)
            ->with('lastDayCalled',$lastDayCalled)
            ->with('lastDayContact',$lastDayContact)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('leadMinedThisWeek',$leadMinedThisWeek)
            ->with('highPosibilitiesThisWeek',$highPosibilitiesThisWeek)
            ->with('contactThisWeek',$contactThisWeek)
            ->with('countWeek',$countWeek);


    }


    public function digitalMarketing(){
        $userId=Auth::user()->id;
        try{
            $target=LocalUserTarget::findOrFail($userId);
        }
        catch (ModelNotFoundException $ex) {
            $target=new LocalUserTarget();
            $target->local_user_targetId=$userId;
            $target->earn=0;
            $target->meeting=0;
            $target->followup=0;
            $target->save();
        }
        $date = Carbon::now();

        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');


        $meeting=LocalMeeting::where('userId',Auth::user()->id)->whereBetween(DB::raw('DATE(created_at)'),[$start,$end])
            ->count();


        $followup=LocalFollowup::where('userId',Auth::user()->id)
            ->where('workStatus',1)
            ->whereBetween(DB::raw('DATE(created_at)'),[$start,$end])
            ->count();

        $revenue=LocalSales::where('userId',$userId)
            ->whereBetween(DB::raw('DATE(created_at)'),[$start,$end])
            ->sum('total');




        return view('dashboardDigital')
            ->with('followup',$followup)
            ->with('meeting',$meeting)
            ->with('target',$target)
            ->with('revenue',$revenue);

    }



    public  function call(){
    $date = Carbon::now();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        $leads=Lead::select('leads.*','workprogress.created_at')
        ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
        ->where('workprogress.userId',Auth::user()->id)
        ->where('workprogress.callingReport','!=',null)
        ->where('workprogress.callingReport','!=',6)
        ->whereBetween('workprogress.created_at', [$start,$end])->get();

    $callReports = Callingreport::get();
    $possibilities = Possibility::get();
    $categories=Category::where('type',1)->get();

    return view('report.weekly')
        ->with('leads', $leads)
        ->with('callReports', $callReports)
        ->with('possibilities', $possibilities)
        ->with('categories',$categories);

}

    public  function contact(){
        $date = Carbon::now();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $leads=Lead::select('leads.*','workprogress.created_at')
            ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
            ->where('workprogress.userId',Auth::user()->id)
//            ->where('workprogress.callingReport',5)
            ->where(function($q){
                $q->orWhere('callingReport',5)
                    ->orWhere('callingReport',4);
            })
            ->whereBetween('workprogress.created_at', [$start,$end])->get();

        $callReports = Callingreport::get();
        $possibilities = Possibility::get();
        $categories=Category::where('type',1)->get();

        return view('report.weekly')
            ->with('leads', $leads)
            ->with('callReports', $callReports)
            ->with('possibilities', $possibilities)
            ->with('categories',$categories);

    }

    public function mine(){
        $date = Carbon::now();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $leads=Lead::where('minedBy',Auth::user()->id)
            ->whereBetween('created_at', [$start,$end])->get();

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
     $start = Carbon::now()->startOfMonth()->format('Y-m-d');
     $end = Carbon::now()->endOfMonth()->format('Y-m-d');

     $User_Type=Session::get('userType');
     if($User_Type=='RA'){
         $leads=Lead::select('leads.*')
             ->where('leads.minedBy',Auth::user()->id)
             ->where('filteredPossibility',3)
             ->whereBetween('created_at', [$start,$end])->get();

     }

    else{
        $leads=Lead::select('leads.*','possibilitychanges.created_at')
            ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
            ->where('possibilitychanges.userId',Auth::user()->id)
            ->where('possibilitychanges.possibilityId',3)
            ->whereBetween('possibilitychanges.created_at', [$start,$end])->get();

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