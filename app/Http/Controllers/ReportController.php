<?php
namespace App\Http\Controllers;
use App\NewCall;
use App\NewFile;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $User_Type=Session::get('userType');

        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');


        if( $User_Type =='MANAGER'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else if($User_Type =='USER' || $User_Type =='RA'){
            $users=User::select('id','firstName','typeId')
                ->where('id',Auth::user()->id)->get();
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
                ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])->count();

//            $calledThisWeek=Workprogress::where('userId',$user->id)
//                ->where('workprogress.callingReport','!=',null)
//                ->where('callingReport','!=',6)
//                ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])->count();

            $calledThisWeek=NewCall::where('userId',$user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])
                ->count();



            $contacted=Workprogress::where('userId',$user->id)
//                    ->where('callingReport',5)
                ->where(function($q){
                    $q->orWhere('callingReport',5)
                        ->orWhere('callingReport',4);
                })
                ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])
                ->count();

            //USA CONTACT TARGET
            $contactedUsa=Workprogress::where('userId',$user->id)
                ->leftJoin('leads','workprogress.leadId','leads.leadId')
                ->leftJoin('countries','leads.countryId','countries.countryId')
                ->where('countries.countryName','like','%USA%')
                ->where(function($q){
                    $q->orWhere('callingReport',5)
                        ->orWhere('callingReport',4);
                })
                ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$start,$end])->count();



            $testLead=Workprogress::where('progress','Test Job')
                ->where('userId',$user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])
                ->count();



            //When user is RA
            if($user->typeId==4){

                $highPosibilitiesThisWeek=Lead::select('leads.*')
//                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('leads.minedBy',$user->id)
                    ->where('filteredPossibility',3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])->count();
            }
            else{
                $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                    ->where('possibilityId',3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$start,$end])->count();

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
                $target->targetTest=0;
                $target->save();
            }


            $t=0;

            //Weekly Report
            if($target->targetCall>0){
                $calledThisWeek=ceil(($calledThisWeek/($target->targetCall))*100);
                if($calledThisWeek>100){
                    $calledThisWeek=100;
                }
                $t++;
            }

            if($target->targetTest>0){
                $testLead=round(($testLead/($target->targetTest))*100);
                if($testLead>100){
                    $testLead=100;
                }
                $t++;
            }

            if($target->targetLeadmine>0){
                $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine))*100);
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

            if($target->targetContact >0){

                $contacted=round(($contacted/($target->targetContact))*100);
                if($contacted>100){
                    $contacted=100;
                }
            }

            if($target->targetUsa >0){

                $contactedUsa=round(($contactedUsa/($target->targetUsa))*100);
                if($contactedUsa>100){
                    $contactedUsa=100;
                }
            }

            else{
                $contactedUsa=0;
            }

            $targetFile=NewFile::where('userId',Auth::user()->id)
                ->whereBetween(DB::raw('date(created_at)'), [$start, $end])
                ->sum('fileCount');

            if($target->targetFile >0){

                $targetFile=round(($targetFile/($target->targetFile))*100);
                if($targetFile>100){
                    $targetFile=100;
                }
            }

            else{
                $targetFile=0;
            }




            if($t==0){
                $t=1;}

            $u = new stdClass;
            $u->userName=$user->firstName;
            $u->typeId=$user->typeId;
            $u->leadMined=$leadMinedThisWeek;
            $u->called=$calledThisWeek;
            $u->highPosibilities=$highPosibilitiesThisWeek;
            $u->contacted=$contacted;
            $u->contactedUsa=$contactedUsa;
            $u->testLead=$testLead;
            $u->targetFile=$targetFile;
            $u->t=$t;
            array_push($report, $u);
        }
//        return $report;
        return view('report.index')->with('report',$report);
    }
    public function searchGraphByDate(Request $r){

        $User_Type=Session::get('userType');
        $f = Carbon::parse($r->fromDate);
        $t = Carbon::parse($r->toDate);
        $t=$t->addDays(1);

        $months=$t->diffInMonths($f);

        if($months==0){
            $months=1;
        }


        if( $User_Type =='MANAGER'){
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else if($User_Type =='USER' || $User_Type =='RA'){
            $users=User::select('id','firstName','typeId')
                ->where('id',Auth::user()->id)->get();
        }
        else{
            $users=User::select('id','firstName','typeId')
                ->where('typeId','!=',1)
                ->get();
        }


        $report=array();
        foreach ($users as $user){
            $leadMinedThisWeek=Lead::where('minedBy',$user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])->count();
            $contacted=Workprogress::where('userId',$user->id)
//                    ->where('callingReport',5)
                ->where(function($q){
                    $q->orWhere('callingReport',5)
                        ->orWhere('callingReport',4);
                })
                ->whereBetween(DB::raw('DATE(created_at)'),[$r->fromDate, $r->toDate])->count();

//            $testLead=Workprogress::where('progress','Test Job')
//                ->whereBetween('created_at', [$r->fromDate, $r->toDate])
//                ->count();
            $testLead=Workprogress::where('progress','Test Job')
                ->where('userId',$user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
                ->count();


            //USA CONTACT TARGET
            $contactedUsa=Workprogress::where('userId',$user->id)
                ->leftJoin('leads','workprogress.leadId','leads.leadId')
                ->leftJoin('countries','leads.countryId','countries.countryId')
                ->where('countries.countryName','like','%USA%')
                ->where(function($q){
                    $q->orWhere('callingReport',5)
                        ->orWhere('callingReport',4);
                })
                ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])->count();



//
//            $calledThisWeek=Workprogress::where('userId',$user->id)
//                ->where('callingReport','!=',6)
//                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])->count();

            $calledThisWeek=NewCall::where('userId',$user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
                ->count();

            //When user is RA
            if($user->typeId==4){
                $highPosibilitiesThisWeek=Lead::select('leads.*')
//                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('leads.minedBy',$user->id)
                    ->where('filteredPossibility',3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
                    ->count();
            }
            else{
                $highPosibilitiesThisWeek=Possibilitychange::where('userId',$user->id)
                    ->where('possibilityId',3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,  $r->toDate])->count();
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
                $calledThisWeek=round(($calledThisWeek/($target->targetCall*$months))*100);
                if($calledThisWeek>100){
                    $calledThisWeek=100;
                }
                $t++;
            }
            if($target->targetTest>0){
                $testLead=round(($testLead/($target->targetTest))*100);
                if($testLead>100){
                    $testLead=100;
                }
                $t++;
            }
            if($target->targetContact >0){
                $contacted=round(($contacted/($target->targetContact*$months))*100);
                if($contacted>100){
                    $contacted=100;
                }
                $t++;
            }

            if($target->targetUsa >0){

                $contactedUsa=round(($contactedUsa/($target->targetUsa*$months))*100);
                if($contactedUsa>100){
                    $contactedUsa=100;
                }
                $t++;
            }
            else{
                $contactedUsa=0;
            }

            if($target->targetLeadmine>0){
                $leadMinedThisWeek=round(($leadMinedThisWeek/($target->targetLeadmine*$months))*100);
                if ($leadMinedThisWeek>100){
                    $leadMinedThisWeek=100;
                }
                $t++;}

            if($target->targetHighPossibility>0){
                $highPosibilitiesThisWeek=round(($highPosibilitiesThisWeek/($target->targetHighPossibility*$months))*100);
                if($highPosibilitiesThisWeek>100){
                    $highPosibilitiesThisWeek=100;
                }
                $t++;
            }


            $targetFile=NewFile::where('userId',Auth::user()->id)
                ->whereBetween(DB::raw('date(created_at)'), [$start, $end])
                ->sum('fileCount');

            if($target->targetFile >0){

                $targetFile=round(($targetFile/($target->targetFile))*100);
                if($targetFile>100){
                    $targetFile=100;
                }
            }

            else{
                $targetFile=0;
            }


            if($t==0){
                $t=1;}
            $u = new stdClass;
            $u->userName=$user->firstName;
            $u->typeId=$user->typeId;
            $u->leadMined=$leadMinedThisWeek;
            $u->called=$calledThisWeek;
            $u->highPosibilities=$highPosibilitiesThisWeek;
            $u->contacted=$contacted;
            $u->contactedUsa=$contactedUsa;
            $u->testLead=$testLead;
            $u->targetFile=$targetFile;
            $u->t=$t;
            array_push($report, $u);
        }
        return view('report.index')
            ->with('report',$report)
            ->with('fromDate',$r->fromDate)
            ->with('toDate',$r->toDate);
    }




    public function reportTable(){
        $date = Carbon::now();
        $User_Type=Session::get('userType');

//        return $date->startOfWeek()->format('Y-m-d').' '.$date->endOfWeek()->format('Y-m-d');

//        $date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')

        if( $User_Type =='MANAGER'){
            $users=User::select('id as userid','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('typeId','!=',4)
                ->where('teamId',Auth::user()->teamId)
//                ->where('crmType','!=','local')
                ->get();

            $usersRa=User::select('id as userid','firstName','typeId')
                ->where('typeId',4)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else if($User_Type =='USER' ){
            $users=User::select('id as userid','firstName','typeId')
                ->where('id',Auth::user()->id)
                ->get();
            $usersRa=[];

        }
        else if($User_Type =='RA'){
            $users=[];
            $usersRa=User::select('id as userid','firstName','typeId')
                ->where('id',Auth::user()->id)
                ->get();

        }


        else{
            $users=User::select('id as userid','firstName','typeId')
//                ->where('typeId','!=',1)
//                ->where('typeId','!=',4)
                ->whereNotIn('typeId',[1,4])
                ->where('users.crmType',null)
                ->get();



            $usersRa=User::select('id as userid','firstName','typeId')
                ->where('typeId',4)
                ->get();
        }



        $calledThisWeek=Workprogress::select('userId',DB::raw('count(*) as userCall'))
            ->where('workprogress.callingReport','!=',null)
            ->where('callingReport','!=',6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $newFiles=NewFile::whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
                ->get();

//        return $newFiles;




//        return $calledThisWeek;

        $leadMinedThisWeek=Lead::select('minedBy',DB::raw('count(*) as userLeadMined'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();


//        return $leadMinedThisWeek;

        $followupThisWeek=Workprogress::select('userId',DB::raw('count(*) as userFollowup'))
            ->where('callingReport',4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


//        return $followupThisWeek;

        $highPosibilitiesThisWeekRa=Lead::select('minedBy',DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility',3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();

//        return $highPosibilitiesThisWeekRa;

        $highPosibilitiesThisWeekUser=Possibilitychange::select('userId',DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId',3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead=Leadassigned::select('assignTo',DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'),[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $assignedLeadRa=Leadassigned::select('assignBy',DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'),[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignBy')
            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek=Possibilitychange::select('userId',DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId',3)
            ->whereBetween(DB::raw('DATE(created_at)'),[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead=Workprogress::select('userId',DB::raw('count(leadId) as userTestLead'))
            ->where('progress','Test Job')
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted=Workprogress::select('userId',DB::raw('count(*) as userContacted'))
            ->where('callingReport',5)
            ->whereBetween(DB::raw('DATE(created_at)'),[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $contacted;

//            USA
        $contactedUsa=Workprogress::select('userId',DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads','workprogress.leadId','leads.leadId')
            ->leftJoin('countries','leads.countryId','countries.countryId')
            ->where('countries.countryName','like','%USA%')
            ->where('callingReport',5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'),[$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;

        $closing=Workprogress::select('userId',DB::raw('count(*) as userClosing'))
                ->where('progress','Closing')
                ->groupBy('userId')
                ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
                ->get();

//        return $closing;
        $newCall=NewCall::whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
                    ->get();



        return view('report.table')
            ->with('users', $users)
            ->with('contactedUsa',$contactedUsa)
            ->with('contacted',$contacted)
            ->with('testLead',$testLead)
            ->with('uniqueHighPosibilitiesThisWeek',$uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead',$assignedLead)
            ->with('assignedLeadRa',$assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser',$highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa',$highPosibilitiesThisWeekRa)
            ->with('followupThisWeek',$followupThisWeek)
            ->with('leadMinedThisWeek',$leadMinedThisWeek)
            ->with('calledThisWeek',$calledThisWeek)
            ->with('closing',$closing)
            ->with('usersRa',$usersRa)
            ->with('newCall',$newCall)
            ->with('newFiles',$newFiles);


    }

    public function searchTableByDate(Request $r){

        $User_Type=Session::get('userType');

        if( $User_Type =='MANAGER'){
            $users=User::select('id as userid','firstName','typeId')
                ->where('typeId','!=',1)
                ->where('typeId','!=',4)
                ->where('teamId',Auth::user()->teamId)
                ->get();

            $usersRa=User::select('id as userid','firstName','typeId')
                ->where('typeId',4)
                ->where('teamId',Auth::user()->teamId)
                ->get();
        }
        else if($User_Type =='USER' ){
            $users=User::select('id as userid','firstName','typeId')
                ->where('id',Auth::user()->id)
                ->get();
            $usersRa=[];

        }
        else if($User_Type =='RA'){
            $users=[];
            $usersRa=User::select('id as userid','firstName','typeId')
                ->where('id',Auth::user()->id)
                ->get();

        }


        else{

            $users=User::select('id as userid','firstName','typeId')
//                ->where('typeId','!=',1)
//                ->where('typeId','!=',4)
                ->whereNotIn('typeId',[1,4])
                ->where('users.crmType',null)
                ->get();

            $usersRa=User::select('id as userid','firstName','typeId')
                ->where('typeId',4)
                ->get();
        }






        $calledThisWeek=Workprogress::select('userId',DB::raw('count(progressId) as userCall'))
            ->where('workprogress.callingReport','!=',null)
            ->where('callingReport','!=',6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();






        $leadMinedThisWeek=Lead::select('minedBy',DB::raw('count(*) as userLeadMined'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('minedBy')
            ->get();


//        return $leadMinedThisWeek;

        $followupThisWeek=Workprogress::select('userId',DB::raw('count(*) as userFollowup'))
            ->where('callingReport',4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();


//        return $followupThisWeek;

        $highPosibilitiesThisWeekRa=Lead::select('minedBy',DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility',3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('minedBy')
            ->get();

//        return $highPosibilitiesThisWeekRa;

        $highPosibilitiesThisWeekUser=Possibilitychange::select('userId',DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId',3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead=Leadassigned::select('assignTo',DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $assignedLeadRa=Leadassigned::select('assignBy',DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('assignBy')
            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek=Possibilitychange::select('userId',DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId',3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead=Workprogress::select('userId',DB::raw('count(leadId) as userTestLead'))
            ->where('progress','Test Job')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted=Workprogress::select('userId',DB::raw('count(*) as userContacted'))
            ->where('callingReport',5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();

//        return $contacted;

//            USA
        $contactedUsa=Workprogress::select('userId',DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads','workprogress.leadId','leads.leadId')
            ->leftJoin('countries','leads.countryId','countries.countryId')
            ->where('countries.countryName','like','%USA%')
            ->where('callingReport',5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate,$r->toDate])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;

        $closing=Workprogress::select('userId',DB::raw('count(*) as userClosing'))
            ->where('progress','Closing')
            ->groupBy('userId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->get();


        $newFiles=NewFile::whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->get();

        $newCall=NewCall::whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate,$r->toDate])
            ->get();



        return view('report.table')
            ->with('users', $users)
            ->with('contactedUsa',$contactedUsa)
            ->with('contacted',$contacted)
            ->with('testLead',$testLead)
            ->with('uniqueHighPosibilitiesThisWeek',$uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead',$assignedLead)
            ->with('assignedLeadRa',$assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser',$highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa',$highPosibilitiesThisWeekRa)
            ->with('followupThisWeek',$followupThisWeek)
            ->with('leadMinedThisWeek',$leadMinedThisWeek)
            ->with('calledThisWeek',$calledThisWeek)
            ->with('closing',$closing)
            ->with('usersRa',$usersRa)
            ->with('fromDate',$r->fromDate)
            ->with('toDate',$r->toDate)
            ->with('newFiles',$newFiles)
            ->with('newCall',$newCall);


    }



    public function individualCall($id){
        $report=Workprogress::where('userId',$id)->count();
        return $report;
    }




}