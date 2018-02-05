<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;
use Auth;
use Session;
use App\Workprogress;
use App\Followup;
use App\Lead;
use App\User;
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
        // return view('home');
        $date = Carbon::now();
        $totalFollowUp=Followup::where('userId',Auth::user()->id)
            ->whereBetween('followUpDate', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
        $totalFollowUpCalled=Workprogress::where('userId',Auth::user()->id)
            ->where('callingReport',4)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
        $calledThisWeek=Workprogress::where('userId',Auth::user()->id)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
        $lastDayCalled=Workprogress::where('userId',Auth::user()->id)
            ->where('created_at',date('Y-m-d',strtotime("-1 days")))->count();
        $leadMined=Lead::where('minedBy',Auth::user()->id)
            ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
        $User_Type=Session::get('userType');

        if($User_Type=='MANAGER') {
            $teamMembers = User::select('id', 'firstName', 'lastName', 'typeId')
                ->where('teamId', Auth::user()->teamId)
                ->where('teamId', '!=', null)
                ->get();
        }
        else if($User_Type=='ADMIN' || $User_Type =='SUPERVISOR'){
            $teamMembers = User::select('id', 'firstName', 'lastName', 'typeId')
//                ->where('teamId', Auth::user()->teamId)
//                ->where('teamId', '!=', null)
                ->get();

        }
        else{
            $teamMembers=0;
        }

        //Graph Access for Manager /SuperVisor / Admin

        return view('dashboard')
            ->with('calledThisWeek',$calledThisWeek)
            ->with('totalFollowUp',$totalFollowUp)
            ->with('totalFollowUpCalled',$totalFollowUpCalled)
            ->with('lastDayCalled',$lastDayCalled)
            ->with('leadMined',$leadMined)
            ->with('teamMembers',$teamMembers);
    }
}