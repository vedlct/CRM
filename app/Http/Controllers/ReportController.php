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
use App\Leadassigned;
use Carbon\Carbon;
use stdClass;
class ReportController extends Controller
{
    public function index(){

        $User_Type=Session::get('userType');
        if($User_Type=='ADMIN' || $User_Type =='MANAGER' ||$User_Type=='SUPERVISOR'){

            if( $User_Type =='MANAGER'){
                $users=User::select('id','firstName','typeId')
                    ->where('typeId','!=',1)
                    ->where('teamId',Auth::user()->teamId)
                    ->get();
            }
            else{
                $users=User::select('id','firstName','typeId')
                    ->where('typeId','!=',1)
                    ->get();
            }

            $date = Carbon::now();
            $report =array();
            foreach ($users as $user){
                $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

                $calledThisWeek=Workprogress::where('userId',$user->id)
                    ->where('workprogress.callingReport','!=',null)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

                //When user is RA
                if($user->typeId==4){
                    $highPosibilitiesThisWeek=Lead::where('minedBy',$user->id)
                        ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                        ->where('possibilitychanges.possibilityId',3)
                        ->whereBetween('possibilitychanges.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
                }
                else{
                    $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                        ->where('possibilityId',3)
                        ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();}

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
                    if($calledThisWeek>100){
                        $calledThisWeek=100;
                    }
                    $t++;
                    }

                if($target->targetLeadmine>0){
                    $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine*5))*100);
                    if ($leadMinedThisWeek>100){
                        $leadMinedThisWeek=100;}
                    $t++;
                   }

                if($target->targetHighPossibility>0){
                    $highPosibilitiesThisWeek=round(($highPosibilitiesThisWeek/($target->targetHighPossibility))*100);
                    if($highPosibilitiesThisWeek>100){
                        $highPosibilitiesThisWeek=100;
                    }
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
            return view('report.index')->with('report',$report);}
    }

    public function searchTableByDate(Request $r){
        $User_Type=Session::get('userType');
        if( $User_Type =='MANAGER'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        elseif ($User_Type =='USER' || $User_Type =='RA'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('id',Auth::user()->id)
                ->get();
        }
        else{
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->get();
        }

        $report =array();

        foreach ($users as $user) {

            $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                ->whereBetween('created_at', [$r->fromDate, $r->toDate])->count();

            $calledThisWeek=Workprogress::where('userId',$user->id)
                ->where('workprogress.callingReport','!=',null)
                ->whereBetween('created_at', [$r->fromDate,$r->toDate])->count();

            $followupThisWeek=Followup::where('userId',$user->id)
                ->whereBetween('created_at',[$r->fromDate,$r->toDate])->count();

            if($user->typeId==4){
                $highPosibilitiesThisWeek=Lead::where('minedBy',$user->id)
                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('possibilitychanges.possibilityId',3)
                    ->whereBetween('possibilitychanges.created_at', [$r->fromDate,$r->toDate])->count();
            }
            else{
                $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                    ->where('possibilityId',3)
                    ->whereBetween('created_at', [$r->fromDate, $r->toDate])->count();
            }


            $assignedLead=Leadassigned::where('assignTo',$user->id)
//                ->where('leaveDate',null)
                ->whereBetween('created_at', [$r->fromDate,$r->toDate])->count();

            $closing=Workprogress::where('userId',$user->id)
                ->where('progress','Closing')
                ->whereBetween('created_at', [$r->fromDate,$r->toDate])->count();

            $test=Workprogress::where('userId',$user->id)
                ->where('progress','Test Job')
                ->whereBetween('created_at', [$r->fromDate,$r->toDate])->count();

            $contacted=Workprogress::where('userId',$user->id)
                ->where('callingReport',5)
                ->whereBetween('created_at', [$r->fromDate, $r->toDate])->count();

            $u = new stdClass;
            $u->id=$user->id;
            $u->userName=$user->firstName;
            $u->leadMined=$leadMinedThisWeek;
            $u->followupThisWeek=$followupThisWeek;
            $u->called=$calledThisWeek;
            $u->highPosibilities=$highPosibilitiesThisWeek;
            $u->assignedLead=$assignedLead;
            $u->closing=$closing;
            $u->test=$test;
            $u->contacted=$contacted;
            array_push($report, $u);

        }




        return view('report.table')
            ->with('report',$report)
            ->with('fromDate',$r->fromDate)
            ->with('toDate',$r->toDate);


    }

    public function searchGraphByDate(Request $r){
        $User_Type=Session::get('userType');
        $f = Carbon::parse($r->fromDate);
        $t = Carbon::parse($r->toDate);


        $length = $t->diffInWeeks($f);
        if($length==0){
            $length = $t->diffInDays($f);
            $length = $length/5;
        }
//        $length = $t->diffInDays($f);
//        $length = $length/5;

        

        if($User_Type=='ADMIN' || $User_Type =='MANAGER' ||$User_Type=='SUPERVISOR'){

            if( $User_Type =='MANAGER'){
                $users=User::select('id','firstName','typeId')
                    ->where('typeId','!=',1)
                    ->where('teamId',Auth::user()->teamId)
                    ->get();
            }
            else{
                $users=User::select('id','firstName','typeId')
                    ->where('typeId','!=',1)
                  //  ->where('id',Auth::user()->id)
                    ->get();
            }


            $report=array();
            foreach ($users as $user){
                $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                    ->whereBetween('created_at', [$r->fromDate, $r->toDate])->count();

                $calledThisWeek=Workprogress::where('userId',$user->id)
                    ->whereBetween('created_at', [$r->fromDate, $r->toDate])->count();

                //When user is RA
                if($user->typeId==4){
                    $highPosibilitiesThisWeek=Lead::where('minedBy',$user->id)
                        ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                        ->where('possibilitychanges.possibilityId',3)
                        ->whereBetween('possibilitychanges.created_at', [$r->fromDate, $r->toDate])->count();
                }
                else{
                    $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                        ->where('possibilityId',3)
                        ->whereBetween('created_at', [$r->fromDate,  $r->toDate])->count();
                }

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
                    $calledThisWeek=round(($calledThisWeek/($target->targetCall*5*$length))*100);
                    if($calledThisWeek>100){
                        $calledThisWeek=100;
                    }
                    $t++;
                }

                if($target->targetLeadmine>0){
                    $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine*5*$length))*100);
                    if ($leadMinedThisWeek>100){
                        $leadMinedThisWeek=100;
                    }
                    $t++;}

                if($target->targetHighPossibility>0){
                    $highPosibilitiesThisWeek=round(($highPosibilitiesThisWeek/($target->targetHighPossibility*$length))*100);
                    if($highPosibilitiesThisWeek>100){
                        $highPosibilitiesThisWeek=100;
                    }
                    $t++;
                }
                if($t==0){
                    $t=1;}
                $u = new stdClass;
                $u->userName=$user->firstName;
                $u->leadMined=$leadMinedThisWeek;
                $u->called=$calledThisWeek;
                $u->highPosibilities=$highPosibilitiesThisWeek;
                $u->t=$t;
                array_push($report, $u);
            }
            return view('report.index')
                ->with('report',$report)
                ->with('fromDate',$r->fromDate)
                ->with('toDate',$r->toDate);
        }

    }

    public function reportTable(){
        $date = Carbon::now();
        $User_Type=Session::get('userType');

        if( $User_Type =='MANAGER'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else{
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('id' , Auth::user()->id)
                ->get();
        }

        $report =array();



        foreach ($users as $user) {

            $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $calledThisWeek=Workprogress::where('userId',$user->id)
                ->where('workprogress.callingReport','!=',null)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $followupThisWeek=Followup::where('userId',$user->id)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();




            if($user->typeId==4){

                $highPosibilitiesThisWeek=Lead::select('leads.*')
                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('leads.minedBy',$user->id)
                    ->where('possibilitychanges.possibilityId',3)
                    ->whereBetween('possibilitychanges.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
                    ->count();

                //                $highPosibilitiesThisWeek=Lead::where('leads.minedBy',$user->id)
//                    ->where('possibilityId',3)
//                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            }
            else{
                $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                    ->where('possibilityId',3)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
            }


            $assignedLead=Leadassigned::where('assignTo',$user->id)
//                ->where('leaveDate',null)
                ->whereBetween('created_at',[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $closing=Workprogress::where('userId',$user->id)
                ->where('progress','Closing')
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $test=Workprogress::where('userId',$user->id)
                ->where('progress','Test Job')
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $contacted=Workprogress::where('userId',$user->id)
                    ->where('callingReport',5)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();


            $u = new stdClass;
            $u->id=$user->id;
            $u->userName=$user->firstName;
            $u->leadMined=$leadMinedThisWeek;
            $u->called=$calledThisWeek;
            $u->highPosibilities=$highPosibilitiesThisWeek;
            $u->assignedLead=$assignedLead;
            $u->followupThisWeek=$followupThisWeek;
            $u->closing=$closing;
            $u->test=$test;
            $u->contacted=$contacted;
            array_push($report, $u);
        }


        return view('report.table')->with('report',$report);
    }



    public function reportTableForUser(){
        $date = Carbon::now();
        $User_Type=Session::get('userType');

        if( $User_Type =='MANAGER'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else{
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('id',Auth::user()->id)
                ->get();
        }

        $report =array();



        foreach ($users as $user) {

            $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $calledThisWeek=Workprogress::where('userId',$user->id)
                ->where('workprogress.callingReport','!=',null)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $followupThisWeek=Followup::where('userId',$user->id)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();




            if($user->typeId==4){

                $highPosibilitiesThisWeek=Lead::select('leads.*')
                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('leads.minedBy',$user->id)
                    ->where('possibilitychanges.possibilityId',3)
                    ->whereBetween('possibilitychanges.created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
                    ->count();

                //                $highPosibilitiesThisWeek=Lead::where('leads.minedBy',$user->id)
//                    ->where('possibilityId',3)
//                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            }
            else{
                $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                    ->where('possibilityId',3)
                    ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();
            }


            $assignedLead=Leadassigned::where('assignTo',$user->id)
//                ->where('leaveDate',null)
                ->whereBetween('created_at',[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $closing=Workprogress::where('userId',$user->id)
                ->where('progress','Closing')
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $test=Workprogress::where('userId',$user->id)
                ->where('progress','Test Job')
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();

            $contacted=Workprogress::where('userId',$user->id)
                ->where('callingReport',5)
                ->whereBetween('created_at', [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])->count();


            $u = new stdClass;
            $u->id=$user->id;
            $u->userName=$user->firstName;
            $u->leadMined=$leadMinedThisWeek;
            $u->called=$calledThisWeek;
            $u->highPosibilities=$highPosibilitiesThisWeek;
            $u->assignedLead=$assignedLead;
            $u->followupThisWeek=$followupThisWeek;
            $u->closing=$closing;
            $u->test=$test;
            $u->contacted=$contacted;
            array_push($report, $u);
        }


        return view('report.table')->with('report',$report);
    }

    public function individualCall($id){
        $report=Workprogress::where('userId',$id)->count();
        return $report;
    }




}