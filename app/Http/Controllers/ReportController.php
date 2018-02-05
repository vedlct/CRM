<?php
namespace App\Http\Controllers;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Workprogress;
use App\User;
use Auth;
use DB;
use App\Followup;
use App\Lead;
use Carbon\Carbon;
class ReportController extends Controller
{
    public function index(){




    //select users.firstName,count(workprogress.userId)
    // from users LEFT JOIN workprogress on users.id=workprogress.userId GROUP BY workprogress.userId

        $users= User::select('users.*',DB::raw('count(workprogress.userId) as total'))
            ->leftJoin('workprogress','users.id','workprogress.userId')
            ->where(DB::raw('DATE(workprogress.created_at)'),'2018-01-27')
            ->groupBy('workprogress.userId')
            ->get();



        return view('report.index')->with('users',$users);
    }


    public function individualCall($id){
        $report=Workprogress::where('userId',$id)->count();
        return $report;
    }


    public function getUserGraph(Request $r){

        if($r->ajax()){
            $date = Carbon::now();

            $name=User::findOrFail($r->id);

            $totalFollowUp=Followup::where('userId',$r->id)
                ->whereBetween('followUpDate', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $totalFollowUpCalled=Workprogress::where('userId',$r->id)
                ->where('callingReport',4)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();


            $calledThisWeek=Workprogress::where('userId',$r->id)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

//            $lastDayCalled=Workprogress::where('userId',$r->id)
//                ->where('created_at',date('Y-m-d',strtotime("-1 days")))->count();

            $leadMined=Lead::where('minedBy',$r->id)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $graph= array('totalFollowUp' => $totalFollowUp,
                'totalFollowUpCalled' => $totalFollowUpCalled,
                'calledThisWeek' => $calledThisWeek,
                'leadMined' => $leadMined,
                'name'=>$name->firstName);


           return Response($graph);
        }


    }


}