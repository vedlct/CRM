<?php
namespace App\Http\Controllers;
use GuzzleHttp\Psr7\Response;
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
use Carbon\Carbon;
use stdClass;
class ReportController extends Controller
{
    public function index(){

        $User_Type=Session::get('userType');
        if($User_Type=='ADMIN' || $User_Type =='MANAGER' ||$User_Type=='SUPERVISOR'){

            if( $User_Type =='MANAGER'){
                $users=User::select('id','firstName')
                    ->where('typeId','!=',1)
                    ->where('teamId',Auth::user()->teamId)
                    ->get();
            }
            else{
                $users=User::select('id','firstName')
                    ->where('typeId','!=',1)
                    ->get();
            }


            $date = Carbon::now();
            $report =array();
            foreach ($users as $user){
                $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

                $calledThisWeek=Workprogress::where('userId',$user->id)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

                $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                    ->where('possibilityId',3)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

                try{
                    $target=Usertarget::findOrFail($user->id);
                }
                catch (ModelNotFoundException $ex) {

                    $target=new Usertarget;
                    $target->userId=$user->id;
                    $target->targetCall=0;
                    $target->targetHighPossibility=0;
                    $target->targetLeadmine=0;
                    $target->save();
                }


                $t=0;

                //Weekly Report
                if($target->targetCall>0){
                    $calledThisWeek=round(($calledThisWeek/($target->targetCall*5))*100);
                    $t++;
                    }

                if($target->targetLeadmine>0){
                    $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine*5))*100);
                    $t++;
                   }

                if($target->targetHighPossibility>0){
                    $highPosibilitiesThisWeek=round(($highPosibilitiesThisWeek/($target->targetHighPossibility))*100);
                    $t++;
                   }
                   if($t==0){
                    $t=1;
                   }

                $u = new stdClass;
                $u->userName=$user->firstName;
                $u->leadMined=$leadMinedThisWeek;
                $u->called=$calledThisWeek;
                $u->highPosibilities=$highPosibilitiesThisWeek;
                $u->t=$t;
                array_push($report, $u);

            }


            return view('report.index')->with('report',$report);

        }

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