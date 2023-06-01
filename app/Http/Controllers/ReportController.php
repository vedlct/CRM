<?php

namespace App\Http\Controllers;

use App\Category;
use App\Country;
use App\Failreport;
use App\NewCall;
use App\NewFile;
use App\Possibility;
use App\UserType;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use Illuminate\Http\Request;
use App\Workprogress;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Followup;
use App\Lead;
use App\Usertarget;
use App\Possibilitychange;
use App\Leadassigned;
use App\Activities;
use Carbon\Carbon;
use stdClass;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

//count(*) as total,
    public function reportCategory()
    {
        $possibilities = Possibility::orderBy('possibilityId', 'ASC')->get();

        $categories = collect(DB::select(DB::raw("SELECT categories.categoryId, categories.categoryName FROM leads left join categories on categories.categoryId = leads.categoryId group by leads.categoryId")));

        $leads = collect(DB::select(DB::raw("SELECT count(*) as total, leadId, companyName, comments, possibilities.possibilityName, possibilities.possibilityId, categories.categoryName, categories.categoryId FROM leads left join categories on categories.categoryId = leads.categoryId left join possibilities on possibilities.possibilityId = leads.possibilityId WHERE leads.possibilityId != 'null' group by categories.categoryId, possibilities.possibilityId")));
        return view('report.supervisor.category')
            ->with('categories', $categories)
            ->with('possibilities', $possibilities)
            ->with('leads', $leads);
    }

    public function reportStatus()
    {
//        $check = Lead::where('statusId', 6)->where('possibilityId', 4)->get();
        $possibilities = Possibility::orderBy('possibilityId', 'ASC')->get();

        $statuses = collect(DB::select(DB::raw("SELECT leadstatus.statusId, leadstatus.statusName FROM leads left join leadstatus on leadstatus.statusId = leads.statusId group by leads.statusId")));
        $leads = collect(DB::select(DB::raw("SELECT count(*) as total, leadId, companyName, comments, possibilities.possibilityName, possibilities.possibilityId, leadstatus.statusId, leadstatus.statusName FROM leads left join leadstatus on leadstatus.statusId = leads.statusId left join possibilities on possibilities.possibilityId = leads.possibilityId WHERE leads.possibilityId != 'null' group by leadstatus.statusId, possibilities.possibilityId")));
        return view('report.supervisor.status')
            ->with('statuses', $statuses)
            ->with('possibilities', $possibilities)
            ->with('leads', $leads);
    }

    public function reportCountry()
    {
//        $check = Lead::where('statusId', 6)->where('possibilityId', 4)->get();
        $possibilities = Possibility::orderBy('possibilityId', 'ASC')->get();

        $countries = collect(DB::select(DB::raw("SELECT countries.countryId, countries.countryName FROM leads left join countries on countries.countryId = leads.countryId group by leads.countryId")));
        $leads = collect(DB::select(DB::raw("SELECT count(*) as total, leadId, companyName, comments, possibilities.possibilityName, possibilities.possibilityId, countries.countryId, countries.countryName FROM leads left join countries on countries.countryId = leads.countryId left join possibilities on possibilities.possibilityId = leads.possibilityId WHERE leads.possibilityId != 'null' group by countries.countryId, possibilities.possibilityId")));
        return view('report.supervisor.country')
            ->with('countries', $countries)
            ->with('possibilities', $possibilities)
            ->with('leads', $leads);
    }

    public function hourReport()
    {
        /* //workprogress avg update time
         $today = date('Y-m-d');

 //        $workProgress = collect(DB::select(DB::raw("SELECT (users.id) as userid, users.userId,  (workprogress.created_at) as time FROM workprogress LEFT JOIN users ON users.id = workprogress.userId WHERE date(workprogress.created_at) = '2020-09-21' AND users.typeId = 5")));
         $wp = collect(DB::select(DB::raw("SELECT id, userId FROM users where typeId = 5")));
         for ($u = 0; $u < $wp->count(); $u++) {
 //echo $wp[$u]->id;
             $timeDiff = [];
             $workProgress = collect(DB::select(DB::raw("SELECT userId,  created_at as time FROM workprogress WHERE date(created_at) = '2020-09-21' AND userId = '" . $wp[$u]->id . "'")));

             $totalWorkprogress = $workProgress->count();

             for ($i = 0; $i < $totalWorkprogress; $i++) {
                 if ($i != ($totalWorkprogress - 1)) {
                     for ($j = $i + 1; $j == $i + 1; $j++) {
                         $startTime = Carbon::parse($workProgress[$i]->time);
                         $endTime = Carbon::parse($workProgress[$j]->time);
                         $timeDiff[] = $startTime->diff($endTime)->format('%H:%i:%s') . " Minutes";
                     }
                 }
             }

         //end

     }*/

        $User_Type = Session::get('userType');
        if ($User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR') {
            $today = date('Y-m-d');
            $wp = User::where('typeId', 5)->select('id', 'userId')->get();
            $work = collect(DB::select(DB::raw("SELECT userId as userid, time(created_at) as createtime FROM workprogress WHERE date(created_at) = '" . $today . "'")));

            return view('hourReport', compact('work', 'wp'));
        }

    }

    public function followupReport()
    {
        $users = User::all();

     $followups = collect(DB::select(DB::raw("SELECT DISTINCT(leadId), count(*) as total, followUpDate, userId FROM followup WHERE followup.leadId not in (SELECT DISTINCT(leadId) FROM workprogress WHERE DATE(workprogress.created_at) = '2020-09-10') AND followUpDate = '2020-09-10' group by followup.userId")));

     $allFollowups = collect(DB::select(DB::raw("SELECT DISTINCT(leadId), count(*) as total, followUpDate, userId FROM followup WHERE followUpDate = '2020-09-10' group by userId")));

        /*$followups = collect(DB::select(DB::raw("SELECT count(*) as total, wp.callingReport, fu.followId, l.companyName, l.leadId, fu.followUpDate, fu.userId, DATE(wp.created_at) as wpcreatedate FROM leads l LEFT JOIN followup fu ON fu.leadId = l.leadId LEFT JOIN workprogress wp ON wp.leadId = l.leadId WHERE fu.followUpDate = '2020-09-10' AND fu.leadId = wp.leadId AND fu.followUpDate = DATE(wp.created_at) GROUP BY fu.userId")));*/

        return view('report.followupReport')->with('followups', $followups)->with('allFollowups', $allFollowups)->with('users', $users);
    }

    public function searchFollowupByDate(Request $r)
    {
        $users = User::all();
        $from = $r->fromDate;
        $to = $r->toDate;

        $followups = collect(DB::select(DB::raw("SELECT DISTINCT(leadId), count(*) as total, userId FROM followup WHERE followup.leadId not in (SELECT DISTINCT(leadId) FROM workprogress WHERE DATE(workprogress.created_at) BETWEEN '".$from."' AND '".$to."') AND followUpDate BETWEEN '".$from."' AND '".$to."' group by followup.userId")));

        $allFollowups = collect(DB::select(DB::raw("SELECT DISTINCT(leadId), count(*) as total, followUpDate, userId FROM followup WHERE followUpDate BETWEEN '".$from."' AND '".$to."' group by userId")));

        /*$followups = collect(DB::select(DB::raw("SELECT count(*) as total, wp.callingReport, fu.followId, l.companyName, l.leadId, fu.followUpDate, fu.userId, DATE(wp.created_at) as wpcreatedate FROM leads l LEFT JOIN followup fu ON fu.leadId = l.leadId LEFT JOIN workprogress wp ON wp.leadId = l.leadId WHERE fu.followUpDate BETWEEN '" . $from . "' AND '$to' AND fu.leadId = wp.leadId AND fu.followUpDate = DATE(wp.created_at) GROUP BY fu.userId")));*/

        return view('report.followupReport')
            ->with('followups', $followups)
            ->with('allFollowups', $allFollowups)
            ->with('fromDate', $r->fromDate)
            ->with('toDate', $r->toDate)
            ->with('users', $users);
    }


    public function reportGraph()
    {

        $User_Type = Session::get('userType');

        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');


        if ($User_Type == 'MANAGER') {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'SUPERVISOR') {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'USER' || $User_Type == 'RA') {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('active', 1)
                ->where('id', Auth::user()->id)->get();

        } else {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('active', 1)
                ->get();
        }

        $date = Carbon::now();
        $report = array();
        foreach ($users as $user) {
            $leadMinedThisWeek = Lead::where('minedBy', $user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->count();

            $calledThisWeek = Workprogress::where('userId', $user->id)
                ->where('workprogress.callingReport', '!=', null)
                ->where('callingReport', '!=', 6)
                ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->count();

//            $calledThisWeek=NewCall::where('new_call.userId',$user->id)
//                ->leftJoin('workprogress','workprogress.progressId','new_call.progressId')
//                ->where('workprogress.callingReport',5)
//                ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$start,$end])
//                ->count();


            $contacted = Workprogress::where('userId', $user->id)
                ->where('callingReport', 5)
//                ->where(function($q){
//                    $q->orWhere('callingReport',5)
//                        ->orWhere('callingReport',4);
//                })
                ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])
                ->count();

            //USA CONTACT TARGET
            $contactedUsa = Workprogress::where('userId', $user->id)
                ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
                ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
                ->where('countries.countryName', 'like', '%USA%')
                ->where(function ($q) {
                    $q->orWhere('callingReport', 5)
                        ->orWhere('callingReport', 4);
                })
                ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$start, $end])->count();


            $testLead = Workprogress::where('progress', 'Test Job')
                ->where('userId', $user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])
                ->count();


            //When user is RA
            if ($user->typeId == 4) {

                $highPosibilitiesThisWeek = Lead::select('leads.*')
//                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('leads.minedBy', $user->id)
                    ->where('filteredPossibility', 3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->count();
            } else {
                $highPosibilitiesThisWeek = Possibilitychange::where('userId', $user->id)
                    ->where('possibilityId', 3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->count();

            }

            try {
                $target = Usertarget::findOrFail($user->id);
            } catch (ModelNotFoundException $ex) {
                $target = new Usertarget;
                $target->userId = $user->id;
                $target->targetCall = 0;
                $target->targetHighPossibility = 0;
                $target->targetLeadmine = 0;
                $target->targetTest = 0;
                $target->save();
            }


            $t = 0;

            //Weekly Report
            if ($target->targetCall > 0) {
                $calledThisWeek = ceil(($calledThisWeek / ($target->targetCall)) * 100);
                if ($calledThisWeek > 100) {
                    $calledThisWeek = 100;
                }
                $t++;
            }

            if ($target->targetTest > 0) {
                $testLead = round(($testLead / ($target->targetTest)) * 100);
                if ($testLead > 100) {
                    $testLead = 100;
                }
                $t++;
            }

            if ($target->targetLeadmine > 0) {
                $leadMinedThisWeek = round(($leadMinedThisWeek / ($target->targetLeadmine)) * 100);
                if ($leadMinedThisWeek > 100) {
                    $leadMinedThisWeek = 100;
                }
                $t++;
            }

            if ($target->targetHighPossibility > 0) {
                $highPosibilitiesThisWeek = round(($highPosibilitiesThisWeek / ($target->targetHighPossibility)) * 100);
                if ($highPosibilitiesThisWeek > 100) {
                    $highPosibilitiesThisWeek = 100;
                }
                $t++;
            }

            if ($target->targetContact > 0) {

                $contacted = round(($contacted / ($target->targetContact)) * 100);
                if ($contacted > 100) {
                    $contacted = 100;
                }
            }

            if ($target->targetUsa > 0) {

                $contactedUsa = round(($contactedUsa / ($target->targetUsa)) * 100);
                if ($contactedUsa > 100) {
                    $contactedUsa = 100;
                }
            } else {
                $contactedUsa = 0;
            }

            $targetFile = NewFile::where('userId', $user->id)
                ->whereBetween(DB::raw('date(created_at)'), [Carbon::now()->subDays(30), date('Y-m-d')])
                ->sum('fileCount');

            if ($target->targetFile > 0) {

                $targetFile = round(($targetFile / ($target->targetFile)) * 100);
                if ($targetFile > 100) {
                    $targetFile = 100;
                }
            } else {
                $targetFile = 0;
            }


            if ($t == 0) {
                $t = 1;
            }

            $u = new stdClass;
            $u->userName = $user->firstName;
            $u->typeId = $user->typeId;
            $u->leadMined = $leadMinedThisWeek;
            $u->called = $calledThisWeek;
            $u->highPosibilities = $highPosibilitiesThisWeek;
            $u->contacted = $contacted;
            $u->contactedUsa = $contactedUsa;
            $u->testLead = $testLead;
            $u->targetFile = $targetFile;
            $u->t = $t;
            array_push($report, $u);
        }
//        return $report;
        return view('report.graph')->with('report', $report);
    }

    public function searchGraphByDate(Request $r)
    {

        $User_Type = Session::get('userType');
        $f = Carbon::parse($r->fromDate);
        $t = Carbon::parse($r->toDate);
        $t = $t->addDays(1);

        $months = $t->diffInMonths($f);

        if ($months == 0) {
            $months = 1;
        }


        if ($User_Type == 'MANAGER') {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'USER' || $User_Type == 'RA') {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('id', Auth::user()->id)->get();
        } else {
            $users = User::select('id', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->get();
        }


        $report = array();
        foreach ($users as $user) {
            $leadMinedThisWeek = Lead::where('minedBy', $user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])->count();
            $contacted = Workprogress::where('userId', $user->id)
                ->where('callingReport', 5)
//                ->where(function($q){
//                    $q->orWhere('callingReport',5)
//                        ->orWhere('callingReport',4);
//                })
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])->count();

//            $testLead=Workprogress::where('progress','Test Job')
//                ->whereBetween('created_at', [$r->fromDate, $r->toDate])
//                ->count();
            $testLead = Workprogress::where('progress', 'Test Job')
                ->where('userId', $user->id)
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
                ->count();


            //USA CONTACT TARGET
            $contactedUsa = Workprogress::where('userId', $user->id)
                ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
                ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
                ->where('countries.countryName', 'like', '%USA%')
                ->where(function ($q) {
                    $q->orWhere('callingReport', 5)
                        ->orWhere('callingReport', 4);
                })
                ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])->count();


            $calledThisWeek = Workprogress::where('userId', $user->id)
                ->where('callingReport', '!=', 6)
                ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])->count();

//            $calledThisWeek=NewCall::where('new_call.userId',$user->id)
//                ->leftJoin('workprogress','workprogress.progressId','new_call.progressId')
//                ->where('workprogress.callingReport',5)
//                ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$r->fromDate, $r->toDate])
//                ->count();

            //When user is RA
            if ($user->typeId == 4) {
                $highPosibilitiesThisWeek = Lead::select('leads.*')
//                    ->leftJoin('possibilitychanges','leads.leadId','possibilitychanges.leadId')
                    ->where('leads.minedBy', $user->id)
                    ->where('filteredPossibility', 3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
                    ->count();
            } else {
                $highPosibilitiesThisWeek = Possibilitychange::where('userId', $user->id)
                    ->where('possibilityId', 3)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])->count();
            }

            try {
                $target = Usertarget::findOrFail($user->id);
            } catch (ModelNotFoundException $ex) {

                $target = new Usertarget;
                $target->userId = $user->id;
                $target->targetCall = 0;
                $target->targetHighPossibility = 0;
                $target->targetLeadmine = 0;
                $target->save();
            }


            $t = 0;

            //Weekly Report
            if ($target->targetCall > 0) {
                $calledThisWeek = round(($calledThisWeek / ($target->targetCall * $months)) * 100);
                if ($calledThisWeek > 100) {
                    $calledThisWeek = 100;
                }
                $t++;
            }
            if ($target->targetTest > 0) {
                $testLead = round(($testLead / ($target->targetTest)) * 100);
                if ($testLead > 100) {
                    $testLead = 100;
                }
                $t++;
            }
            if ($target->targetContact > 0) {
                $contacted = round(($contacted / ($target->targetContact * $months)) * 100);
                if ($contacted > 100) {
                    $contacted = 100;
                }
                $t++;
            }

            if ($target->targetUsa > 0) {

                $contactedUsa = round(($contactedUsa / ($target->targetUsa * $months)) * 100);
                if ($contactedUsa > 100) {
                    $contactedUsa = 100;
                }
                $t++;
            } else {
                $contactedUsa = 0;
            }

            if ($target->targetLeadmine > 0) {
                $leadMinedThisWeek = round(($leadMinedThisWeek / ($target->targetLeadmine * $months)) * 100);
                if ($leadMinedThisWeek > 100) {
                    $leadMinedThisWeek = 100;
                }
                $t++;
            }

            if ($target->targetHighPossibility > 0) {
                $highPosibilitiesThisWeek = round(($highPosibilitiesThisWeek / ($target->targetHighPossibility * $months)) * 100);
                if ($highPosibilitiesThisWeek > 100) {
                    $highPosibilitiesThisWeek = 100;
                }
                $t++;
            }


            $targetFile = NewFile::where('userId', $user->id)
                ->whereBetween(DB::raw('date(created_at)'), [Carbon::parse($r->fromdate)->subDays(30)->format('Y-m-d'), $r->toDate])
                ->sum('fileCount');

            if ($target->targetFile > 0) {

                $targetFile = round(($targetFile / ($target->targetFile)) * 100);
                if ($targetFile > 100) {
                    $targetFile = 100;
                }
            } else {
                $targetFile = 0;
            }


            if ($t == 0) {
                $t = 1;
            }
            $u = new stdClass;
            $u->userName = $user->firstName;
            $u->typeId = $user->typeId;
            $u->leadMined = $leadMinedThisWeek;
            $u->called = $calledThisWeek;
            $u->highPosibilities = $highPosibilitiesThisWeek;
            $u->contacted = $contacted;
            $u->contactedUsa = $contactedUsa;
            $u->testLead = $testLead;
            $u->targetFile = $targetFile;
            $u->t = $t;
            array_push($report, $u);
        }
        return view('report.graph')
            ->with('report', $report)
            ->with('fromDate', $r->fromDate)
            ->with('toDate', $r->toDate);
    }

    public function reportTable()
    { 

        $date = Carbon::now();
        $User_Type = Session::get('userType');

  //      $User_Type = UserType::select('typeName')->Where('typeId',Auth::user()->typeId)->first();


        if ($User_Type == 'MANAGER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('typeId', '!=', 4)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();

            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'USER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('active', 1)
                ->where('id', Auth::user()->id)
                ->get();
            $usersRa = [];

        } else if ($User_Type == 'RA') {
            $users = [];
            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('active', 1)
                ->where('id', Auth::user()->id)
                ->get();

        } else {
            $users = User::select('id as userid', 'firstName', 'typeId')
//                ->where('typeId','!=',1)
//                ->where('typeId','!=',4)
                ->whereNotIn('typeId', [1, 4])
                ->where('users.crmType', null)
                ->where('active', 1)
                ->get();


            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->where('active', 1)
                ->get();
        }


        $failReport = Failreport::select('failreport.*', 'users.firstName')
            ->leftJoin('users', 'users.id', 'failreport.userId')
            ->whereBetween(DB::raw('DATE(failreport.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->orderBy('failreport.id', 'desc')
            ->get();

//        return $failReport;

        $calledThisWeek = Workprogress::select('userId', DB::raw('count(*) as userCall'))
            ->where('workprogress.callingReport', '!=', null)
            ->where('callingReport', '!=', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();



        $newFiles = NewFile::whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->subDays(30), date('Y-m-d')])
            ->get();


        $leadMinedThisWeek = Lead::select('minedBy', DB::raw('count(*) as userLeadMined'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();


        $followupThisWeek = Workprogress::select('userId', DB::raw('count(*) as userFollowup'))
            ->where('callingReport', 4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $highPosibilitiesThisWeekRa = Lead::select('minedBy', DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();


        $highPosibilitiesThisWeekUser = Possibilitychange::select('userId', DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead = Leadassigned::select('assignTo', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $assignedLeadRa = Leadassigned::select('assignBy', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignBy')
            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek = Possibilitychange::select('userId', DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead = Workprogress::select('userId', DB::raw('count(leadId) as userTestLead'))
            ->where('progress', 'Test Job')
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted = Workprogress::select('userId', DB::raw('count(*) as userContacted'))
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

        $conversation = Workprogress::select('userId', DB::raw('count(*) as conversation'))
            ->where('callingReport', 11)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $emailed = Workprogress::select('userId', DB::raw('count(*) as userEmailed'))
            ->where('callingReport', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

        $coldemailed = Workprogress::select('userId', DB::raw('count(*) as usercoldEmailed'))
            ->where('callingReport', 8)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

        $other = Workprogress::select('userId', DB::raw('count(*) as userOther'))
            ->where('callingReport', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $notAvailable = Workprogress::select('userId', DB::raw('count(*) as userNotAvialable'))
            ->where('callingReport', 2)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


            $notInterested = Workprogress::select('userId', DB::raw('count(*) as userNotInterested'))
            ->where('callingReport', 10)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $contactedUsa = Workprogress::select('userId', DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('countries.countryName', 'like', '%USA%')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;

        $closing = Workprogress::select('userId', DB::raw('count(*) as userClosing'))
            ->where('progress', 'Closing')
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $closing;

        $newCall = NewCall::leftJoin('workprogress', 'workprogress.progressId', 'new_call.progressId')
            ->where('workprogress.callingReport', 5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();

        $gatekeeper = Workprogress::select('userId', DB::raw('count(*) as gatekeeper'))
            ->where('callingReport', 9)
            ->groupBy('userId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();



        $testLeadForRa = Workprogress::select('minedBy')
            ->where('progress', 'Test Job')
            ->leftJoin('leads', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('users', 'users.id', 'leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();

//        return $testLeadForRa;


        return view('report.table')
            ->with('users', $users)
            ->with('contactedUsa', $contactedUsa)
            ->with('contacted', $contacted)
            ->with('testLead', $testLead)
            ->with('uniqueHighPosibilitiesThisWeek', $uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead', $assignedLead)
            ->with('assignedLeadRa', $assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser', $highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa', $highPosibilitiesThisWeekRa)
            ->with('followupThisWeek', $followupThisWeek)
            ->with('leadMinedThisWeek', $leadMinedThisWeek)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('closing', $closing)
            ->with('usersRa', $usersRa)
            ->with('newCall', $newCall)
            ->with('newFiles', $newFiles)
            ->with('testLeadForRa', $testLeadForRa)
            ->with('failReport', $failReport)
            ->with('emailed', $emailed)
            ->with('coldemailed', $coldemailed)
            ->with('other', $other)
            ->with('notAvailable', $notAvailable)
            ->with('gatekeeper', $gatekeeper)
            ->with('notInterested', $notInterested)
            ->with('conversation', $conversation);


    }

    public function searchTableByDate(Request $r)
    {

        $User_Type = Session::get('userType');


        if ($User_Type == 'MANAGER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('typeId', '!=', 4)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();

            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'USER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('id', Auth::user()->id)
                ->get();
            $usersRa = [];

        } else if ($User_Type == 'RA') {
            $users = [];
            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('id', Auth::user()->id)
                ->get();

        } else {

            $users = User::select('id as userid', 'firstName', 'typeId')
//                ->where('typeId','!=',1)
//                ->where('typeId','!=',4)
                ->whereNotIn('typeId', [1, 4])
                ->where('users.crmType', null)
                ->where('active', 1)
                ->get();

            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->get();
        }


        $failReport = Failreport::select('failreport.*', 'users.firstName')
            ->leftJoin('users', 'users.id', 'failreport.userId')
            ->whereBetween(DB::raw('DATE(failreport.created_at)'), [$r->fromDate, $r->toDate])
            ->orderBy('failreport.id', 'desc')
            ->get();

//        return $failReport;


        $calledThisWeek = Workprogress::select('userId', DB::raw('count(progressId) as userCall'))
            ->where('workprogress.callingReport', '!=', null)
            ->where('callingReport', '!=', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();


        $leadMinedThisWeek = Lead::select('minedBy', DB::raw('count(*) as userLeadMined'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('minedBy')
            ->get();


//        return $leadMinedThisWeek;


        $followupThisWeek = Workprogress::select('userId', DB::raw('count(*) as userFollowup'))
            ->where('callingReport', 4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();


//        return $followupThisWeek;

        $highPosibilitiesThisWeekRa = Lead::select('minedBy', DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('minedBy')
            ->get();

//        return $highPosibilitiesThisWeekRa;

        $highPosibilitiesThisWeekUser = Possibilitychange::select('userId', DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead = Leadassigned::select('assignTo', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $assignedLeadRa = Leadassigned::select('assignBy', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('assignBy')
            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek = Possibilitychange::select('userId', DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead = Workprogress::select('userId', DB::raw('count(leadId) as userTestLead'))
            ->where('progress', 'Test Job')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted = Workprogress::select('userId', DB::raw('count(*) as userContacted'))
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

        $conversation = Workprogress::select('userId', DB::raw('count(*) as conversation'))
            ->where('callingReport', 11)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

        $emailed = Workprogress::select('userId', DB::raw('count(*) as userEmailed'))
            ->where('callingReport', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();
        $coldemailed = Workprogress::select('userId', DB::raw('count(*) as usercoldEmailed'))
            ->where('callingReport', 8)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();
        $other = Workprogress::select('userId', DB::raw('count(*) as userOther'))
            ->where('callingReport', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

        $notAvailable = Workprogress::select('userId', DB::raw('count(*) as userNotAvialable'))
            ->where('callingReport', 2)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();
        $gatekeeper = Workprogress::select('userId', DB::raw('count(*) as gatekeeper'))
            ->where('callingReport', 9)
            ->groupBy('userId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->get();

        $notInterested = Workprogress::select('userId', DB::raw('count(*) as userNotInterested'))
            ->where('callingReport', 10)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//            USA
        $contactedUsa = Workprogress::select('userId', DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('countries.countryName', 'like', '%USA%')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;

        $closing = Workprogress::select('userId', DB::raw('count(*) as userClosing'))
            ->where('progress', 'Closing')
            ->groupBy('userId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->get();


        $newFiles = NewFile::whereBetween(DB::raw('DATE(created_at)'), [Carbon::parse($r->fromdate)->subDays(30)->format('Y-m-d'), $r->toDate])
            ->get();

        $newCall = NewCall::leftJoin('workprogress', 'workprogress.progressId', 'new_call.progressId')
            ->where('workprogress.callingReport', 5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$r->fromDate, $r->toDate])
            ->get();


        $testLeadForRa = Workprogress::select('minedBy')
            ->where('progress', 'Test Job')
            ->leftJoin('leads', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('users', 'users.id', 'leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])
            ->get();



        return view('report.table')
            ->with('users', $users)
            ->with('contactedUsa', $contactedUsa)
            ->with('contacted', $contacted)
            ->with('testLead', $testLead)
            ->with('uniqueHighPosibilitiesThisWeek', $uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead', $assignedLead)
            ->with('assignedLeadRa', $assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser', $highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa', $highPosibilitiesThisWeekRa)
            ->with('followupThisWeek', $followupThisWeek)
            ->with('leadMinedThisWeek', $leadMinedThisWeek)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('closing', $closing)
            ->with('usersRa', $usersRa)
            ->with('fromDate', $r->fromDate)
            ->with('toDate', $r->toDate)
            ->with('newFiles', $newFiles)
            ->with('newCall', $newCall)
            ->with('testLeadForRa', $testLeadForRa)
            ->with('failReport', $failReport)
            ->with('emailed', $emailed)
            ->with('coldemailed', $coldemailed)
            ->with('other', $other)
            ->with('notAvailable', $notAvailable)
            ->with('gatekeeper', $gatekeeper)
            ->with('notInterested', $notInterested)
            ->with('conversation', $conversation);

    }

    public function searchCategoryByDate(Request $r)
    {
        $User_Type = Session::get('userType');


        if ($User_Type == 'MANAGER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('typeId', '!=', 4)
                ->where('teamId', Auth::user()->teamId)
                ->get();

            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'USER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('id', Auth::user()->id)
                ->get();
            $usersRa = [];

        } else if ($User_Type == 'RA') {
            $users = [];
            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('id', Auth::user()->id)
                ->get();

        } else {

            $users = User::select('id as userid', 'firstName', 'typeId')
//                ->where('typeId','!=',1)
//                ->where('typeId','!=',4)
                ->whereNotIn('typeId', [1, 4])
                ->where('users.crmType', null)
                ->get();

            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->get();
        }


        $failReport = Failreport::select('failreport.*', 'users.firstName')
            ->leftJoin('users', 'users.id', 'failreport.userId')
            ->whereBetween(DB::raw('DATE(failreport.created_at)'), [$r->fromDate, $r->toDate])
            ->orderBy('failreport.id', 'desc')
            ->get();

//        return $failReport;


        $calledThisWeek = Workprogress::select('userId', DB::raw('count(progressId) as userCall'))
            ->where('workprogress.callingReport', '!=', null)
            ->where('callingReport', '!=', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();


        $leadMinedThisWeek = Lead::select('minedBy', DB::raw('count(*) as userLeadMined'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('minedBy')
            ->get();


//        return $leadMinedThisWeek;

        $followupThisWeek = Workprogress::select('userId', DB::raw('count(*) as userFollowup'))
            ->where('callingReport', 4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();


//        return $followupThisWeek;

        $highPosibilitiesThisWeekRa = Lead::select('minedBy', DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('minedBy')
            ->get();

//        return $highPosibilitiesThisWeekRa;

        $highPosibilitiesThisWeekUser = Possibilitychange::select('userId', DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead = Leadassigned::select('assignTo', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $assignedLeadRa = Leadassigned::select('assignBy', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('assignBy')
            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek = Possibilitychange::select('userId', DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead = Workprogress::select('userId', DB::raw('count(leadId) as userTestLead'))
            ->where('progress', 'Test Job')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted = Workprogress::select('userId', DB::raw('count(*) as userContacted'))
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

        $emailed = Workprogress::select('userId', DB::raw('count(*) as userEmailed'))
            ->where('callingReport', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();
        $coldemailed = Workprogress::select('userId', DB::raw('count(*) as usercoldEmailed'))
            ->where('callingReport', 8)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();
        $other = Workprogress::select('userId', DB::raw('count(*) as userOther'))
            ->where('callingReport', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

        $notAvailable = Workprogress::select('userId', DB::raw('count(*) as userNotAvialable'))
            ->where('callingReport', 2)
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//            USA
        $contactedUsa = Workprogress::select('userId', DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('countries.countryName', 'like', '%USA%')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;

        $closing = Workprogress::select('userId', DB::raw('count(*) as userClosing'))
            ->where('progress', 'Closing')
            ->groupBy('userId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            ->get();


        $newFiles = NewFile::whereBetween(DB::raw('DATE(created_at)'), [Carbon::parse($r->fromdate)->subDays(30)->format('Y-m-d'), $r->toDate])
            ->get();

        $newCall = NewCall::leftJoin('workprogress', 'workprogress.progressId', 'new_call.progressId')
            ->where('workprogress.callingReport', 5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$r->fromDate, $r->toDate])
            ->get();


        $testLeadForRa = Workprogress::select('minedBy')
            ->where('progress', 'Test Job')
            ->leftJoin('leads', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('users', 'users.id', 'leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])
            ->get();


        return view('report.table')
            ->with('users', $users)
            ->with('contactedUsa', $contactedUsa)
            ->with('contacted', $contacted)
            ->with('testLead', $testLead)
            ->with('uniqueHighPosibilitiesThisWeek', $uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead', $assignedLead)
            ->with('assignedLeadRa', $assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser', $highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa', $highPosibilitiesThisWeekRa)
            ->with('followupThisWeek', $followupThisWeek)
            ->with('leadMinedThisWeek', $leadMinedThisWeek)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('closing', $closing)
            ->with('usersRa', $usersRa)
            ->with('fromDate', $r->fromDate)
            ->with('toDate', $r->toDate)
            ->with('newFiles', $newFiles)
            ->with('newCall', $newCall)
            ->with('testLeadForRa', $testLeadForRa)
            ->with('failReport', $failReport)
            ->with('emailed', $emailed)
            ->with('coldemailed', $coldemailed)
            ->with('other', $other)
            ->with('notAvailable', $notAvailable);


    }

    public function reportTableCountry()
    {

        $date = Carbon::now();
        $User_Type = Session::get('userType');

        $countries = Country::all();

//        $failReport = Failreport::select('failreport.*', 'users.firstName')
//            ->leftJoin('users', 'users.id', 'failreport.userId')
//            ->whereBetween(DB::raw('DATE(failreport.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->orderBy('failreport.id', 'desc')
//            ->get();

//        return $failReport;

        $calledThisWeek = Workprogress::select('leads.countryId', DB::raw('count(*) as userCall'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('workprogress.callingReport', '!=', null)
            ->where('callingReport', '!=', 6)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();


        $newFiles = NewFile::whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->subDays(30), date('Y-m-d')])
            ->get();


//        $leadMinedThisWeek = Lead::select('minedBy', DB::raw('count(*) as userLeadMined'))
//            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->groupBy('minedBy')
//            ->get();


        $followupThisWeek = Workprogress::select('leads.countryId', DB::raw('count(*) as userFollowup'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 4)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();


//        $highPosibilitiesThisWeekRa = Lead::select('minedBy', DB::raw('count(*) as userHighPosibilities'))
//            ->where('filteredPossibility', 3)
//            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->groupBy('minedBy')
//            ->get();


        $highPosibilitiesThisWeekUser = Possibilitychange::select('leads.countryId', DB::raw('count(*) as userHighPosibilities'))
            ->leftJoin('leads', 'possibilitychanges.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('possibilitychanges.possibilityId', 3)
            ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead = Leadassigned::select('assignTo', 'leads.countryId', DB::raw('count(*) as userAssignedLead'))
            ->leftJoin('leads', 'leadassigneds.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->whereBetween(DB::raw('DATE(leadassigneds.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

//       return $assignedLead;

//        $assignedLeadRa = Leadassigned::select('assignBy', DB::raw('count(*) as userAssignedLead'))
//            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->groupBy('assignBy')
//            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek = Possibilitychange::select('leads.countryId', DB::raw('count(DISTINCT possibilitychanges.leadId) as userUniqueHighPosibilities'))
            ->leftJoin('leads', 'possibilitychanges.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('possibilitychanges.possibilityId', 3)
            ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead = Workprogress::select('leads.countryId', DB::raw('count(workprogress.leadId) as userTestLead'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('progress', 'Test Job')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

//        return $testLead;
        $contacted = Workprogress::select('leads.countryId', DB::raw('count(*) as userContacted'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();


        $emailed = Workprogress::select('leads.countryId', DB::raw('count(*) as userEmailed'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 3)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

        $coldemailed = Workprogress::select('leads.countryId', DB::raw('count(*) as usercoldEmailed'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 8)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

        $other = Workprogress::select('leads.countryId', DB::raw('count(*) as userOther'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 6)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();


        $notAvailable = Workprogress::select('leads.countryId', DB::raw('count(*) as userNotAvialable'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 2)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();


        $contactedUsa = Workprogress::select('leads.countryId', DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('countries.countryName', 'like', '%USA%')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();

//        return $contactedUsa;

        $closing = Workprogress::select('leads.countryId', DB::raw('count(*) as userClosing'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->where('progress', 'Closing')
            ->groupBy('leads.countryId')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();

//        return $closing;

        $newCall = NewCall::leftJoin('workprogress', 'workprogress.progressId', 'new_call.progressId')
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'countries.countryId', 'leads.countryId')
            ->where('workprogress.callingReport', 5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('leads.countryId')
            ->get();


        $testLeadForRa = Workprogress::select('minedBy')
            ->where('progress', 'Test Job')
            ->leftJoin('leads', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('users', 'users.id', 'leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();

//        return $testLeadForRa;

        $leadMinedThisWeek = Lead::select('leads.countryId', DB::raw('count(*) as userLeadMined'))
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->whereBetween(DB::raw('DATE(created_at)'),  [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            //->groupBy('minedBy')
            ->groupBy('leads.countryId')
            ->get();

        return view('report.countryTable')
            ->with('countries', $countries)
            ->with('contactedUsa', $contactedUsa)
            ->with('contacted', $contacted)
            ->with('testLead', $testLead)
            ->with('uniqueHighPosibilitiesThisWeek', $uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead', $assignedLead)
//            ->with('assignedLeadRa', $assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser', $highPosibilitiesThisWeekUser)
//            ->with('highPosibilitiesThisWeekRa', $highPosibilitiesThisWeekRa)
            ->with('followupThisWeek', $followupThisWeek)
           ->with('leadMinedThisWeek', $leadMinedThisWeek)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('closing', $closing)
//            ->with('usersRa', $usersRa)
            ->with('newCall', $newCall)
            ->with('newFiles', $newFiles)
            ->with('testLeadForRa', $testLeadForRa)
//            ->with('failReport', $failReport)
            ->with('emailed', $emailed)
            ->with('coldemailed', $coldemailed)
            ->with('other', $other)
            ->with('notAvailable', $notAvailable);
    }


    public function searchCountryTableByDate(Request $r)
    {
        $User_Type = Session::get('userType');



        $countries = Country::all();

//        $failReport = Failreport::select('failreport.*', 'users.firstName')
//            ->leftJoin('users', 'users.id', 'failreport.userId')
//            ->whereBetween(DB::raw('DATE(failreport.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->orderBy('failreport.id', 'desc')
//            ->get();

//        return $failReport;

        $calledThisWeek = Workprogress::select('leads.countryId', DB::raw('count(*) as userCall'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('workprogress.callingReport', '!=', null)
            ->where('callingReport', '!=', 6)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();


        $newFiles = NewFile::whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->subDays(30), date('Y-m-d')])
            ->get();


        $leadMinedThisWeek = Lead::select('leads.countryId', DB::raw('count(*) as userLeadMined'))
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$r->fromDate, $r->toDate])
            //->groupBy('minedBy')
            ->groupBy('leads.countryId')
            ->get();


        $followupThisWeek = Workprogress::select('leads.countryId', DB::raw('count(*) as userFollowup'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 4)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();


//        $highPosibilitiesThisWeekRa = Lead::select('minedBy', DB::raw('count(*) as userHighPosibilities'))
//            ->where('filteredPossibility', 3)
//            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->groupBy('minedBy')
//            ->get();


        $highPosibilitiesThisWeekUser = Possibilitychange::select('leads.countryId', DB::raw('count(*) as userHighPosibilities'))
            ->leftJoin('leads', 'possibilitychanges.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('possibilitychanges.possibilityId', 3)
            ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead = Leadassigned::select('assignTo', 'leads.countryId', DB::raw('count(*) as userAssignedLead'))
            ->leftJoin('leads', 'leadassigneds.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->whereBetween(DB::raw('DATE(leadassigneds.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

//       return $assignedLead;

//        $assignedLeadRa = Leadassigned::select('assignBy', DB::raw('count(*) as userAssignedLead'))
//            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
//            ->groupBy('assignBy')
//            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek = Possibilitychange::select('leads.countryId', DB::raw('count(DISTINCT possibilitychanges.leadId) as userUniqueHighPosibilities'))
            ->leftJoin('leads', 'possibilitychanges.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('possibilitychanges.possibilityId', 3)
            ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead = Workprogress::select('leads.countryId', DB::raw('count(workprogress.leadId) as userTestLead'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('progress', 'Test Job')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

//        return $testLead;
        $contacted = Workprogress::select('leads.countryId', DB::raw('count(*) as userContacted'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();


        $emailed = Workprogress::select('leads.countryId', DB::raw('count(*) as userEmailed'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 3)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

        $coldemailed = Workprogress::select('leads.countryId', DB::raw('count(*) as usercoldEmailed'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 8)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

        $other = Workprogress::select('leads.countryId', DB::raw('count(*) as userOther'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 6)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();


        $notAvailable = Workprogress::select('leads.countryId', DB::raw('count(*) as userNotAvialable'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('callingReport', 2)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();


        $contactedUsa = Workprogress::select('leads.countryId', DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('countries.countryName', 'like', '%USA%')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();

//        return $contactedUsa;

        $closing = Workprogress::select('leads.countryId', DB::raw('count(*) as userClosing'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->where('progress', 'Closing')
            ->groupBy('leads.countryId')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])

            ->get();

//        return $closing;

        $newCall = NewCall::leftJoin('workprogress', 'workprogress.progressId', 'new_call.progressId')
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'countries.countryId', 'leads.countryId')
            ->where('workprogress.callingReport', 5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$r->fromDate, $r->toDate])

            ->groupBy('leads.countryId')
            ->get();


        $testLeadForRa = Workprogress::select('minedBy')
            ->where('progress', 'Test Job')
            ->leftJoin('leads', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('users', 'users.id', 'leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$r->fromDate, $r->toDate])
            ->get();


        return view('report.countryTable')
            ->with('countries', $countries)
            ->with('contactedUsa', $contactedUsa)
            ->with('contacted', $contacted)
            ->with('testLead', $testLead)
            ->with('uniqueHighPosibilitiesThisWeek', $uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead', $assignedLead)
//            ->with('assignedLeadRa', $assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser', $highPosibilitiesThisWeekUser)
//            ->with('highPosibilitiesThisWeekRa', $highPosibilitiesThisWeekRa)
            ->with('followupThisWeek', $followupThisWeek)
            ->with('leadMinedThisWeek', $leadMinedThisWeek)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('closing', $closing)
//            ->with('usersRa', $usersRa)
            ->with('newCall', $newCall)
            ->with('newFiles', $newFiles)
            ->with('testLeadForRa', $testLeadForRa)
//            ->with('failReport', $failReport)
            ->with('emailed', $emailed)
            ->with('coldemailed', $coldemailed)
            ->with('other', $other)
            ->with('fromDate', $r->fromDate)
            ->with('toDate', $r->toDate)
            ->with('notAvailable', $notAvailable);


    }



    public function individualCall($id)
    {
        $report = Workprogress::where('userId', $id)->count();
        return $report;
    }


//    Tab Report
    public function reportTab()
    {
        return view('report.supervisor.tab.tab');
    }

    public function reportTabCategory(Request $r)
    {
        $possibilities = Possibility::orderBy('possibilityId', 'ASC')->get();

        $categories = collect(DB::select(DB::raw("SELECT categories.categoryId, categories.categoryName FROM leads left join categories on categories.categoryId = leads.categoryId group by leads.categoryId")));

        $leads = collect(DB::select(DB::raw("SELECT count(*) as total, leadId, companyName, comments, possibilities.possibilityName, possibilities.possibilityId, categories.categoryName, categories.categoryId FROM leads left join categories on categories.categoryId = leads.categoryId left join possibilities on possibilities.possibilityId = leads.possibilityId WHERE leads.possibilityId != 'null' group by categories.categoryId, possibilities.possibilityId")));
        return view('report.supervisor.tab.category')
            ->with('categories', $categories)
            ->with('possibilities', $possibilities)
            ->with('leads', $leads);
    }

    public function reportTabCountry(Request $r)
    {
//        $check = Lead::where('statusId', 6)->where('possibilityId', 4)->get();
        $possibilities = Possibility::orderBy('possibilityId', 'ASC')->get();

        $countries = collect(DB::select(DB::raw("SELECT countries.countryId, countries.countryName FROM leads left join countries on countries.countryId = leads.countryId group by leads.countryId")));
        $leads = collect(DB::select(DB::raw("SELECT count(*) as total, leadId, companyName, comments, possibilities.possibilityName, possibilities.possibilityId, countries.countryId, countries.countryName FROM leads left join countries on countries.countryId = leads.countryId left join possibilities on possibilities.possibilityId = leads.possibilityId WHERE leads.possibilityId != 'null' group by countries.countryId, possibilities.possibilityId")));
        return view('report.supervisor.tab.country')
            ->with('countries', $countries)
            ->with('possibilities', $possibilities)
            ->with('leads', $leads);
    }

    public function reportTabStatus(Request $r)
    {
        $possibilities = Possibility::orderBy('possibilityId', 'ASC')->get();

        $statuses = collect(DB::select(DB::raw("SELECT leadstatus.statusId, leadstatus.statusName FROM leads left join leadstatus on leadstatus.statusId = leads.statusId group by leads.statusId")));
        $leads = collect(DB::select(DB::raw("SELECT count(*) as total, leadId, companyName, comments, possibilities.possibilityName, possibilities.possibilityId, leadstatus.statusId, leadstatus.statusName FROM leads left join leadstatus on leadstatus.statusId = leads.statusId left join possibilities on possibilities.possibilityId = leads.possibilityId WHERE leads.possibilityId != 'null' group by leadstatus.statusId, possibilities.possibilityId")));
        return view('report.supervisor.tab.status')
            ->with('statuses', $statuses)
            ->with('possibilities', $possibilities)
            ->with('leads', $leads);
    }


    public function reportTabHourly(Request $r)
    {
        $User_Type = Session::get('userType');
        if ($User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR') {
            $today = date('Y-m-d');
            $wp = User::where('typeId', 5)->select('id', 'userId')->get();
            $work = collect(DB::select(DB::raw("SELECT userId as userid, time(created_at) as createtime FROM workprogress WHERE date(created_at) = '" . $today . "'")));

            return view('report.supervisor.tab.hourly', compact('work', 'wp'));
        }

    }

    public function hourReport_filter(Request $r)
    {
        $User_Type = Session::get('userType');
        if ($User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR') {
            $selectedDay = $r->selectedDay;
            $wp = User::where('typeId', 5)->select('id', 'userId')->get();
            $work = collect(DB::select(DB::raw("SELECT userId as userid, time(created_at) as createtime FROM workprogress WHERE date(created_at) = '" . $selectedDay . "'")));

            return view('hourReport-filter', compact('work', 'wp'));
        }
    }




    // public function reportIndividualLeadCount(request $r){
    //     $totalOwnedLeads = Lead::select('contactedUserId', DB::raw('count(*) as userOwnedLeads'))
    //     ->groupBy('contactedUserId')
    //     ->get();
    // }


    /*public function reportValue(Request $r)
    {

        $date = Carbon::now();
        $User_Type = Session::get('userType');


        if ($User_Type == 'MANAGER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', '!=', 1)
                ->where('typeId', '!=', 4)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();

            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->where('active', 1)
                ->where('teamId', Auth::user()->teamId)
                ->get();
        } else if ($User_Type == 'USER') {
            $users = User::select('id as userid', 'firstName', 'typeId')
                ->where('active', 1)
                ->where('id', Auth::user()->id)
                ->get();
            $usersRa = [];

        } else if ($User_Type == 'RA') {
            $users = [];
            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('active', 1)
                ->where('id', Auth::user()->id)
                ->get();

        } else {
            $users = User::select('id as userid', 'firstName', 'typeId')
//                ->where('typeId','!=',1)
//                ->where('typeId','!=',4)
                ->whereNotIn('typeId', [1, 4])
                ->where('users.crmType', null)
                ->where('active', 1)
                ->get();


            $usersRa = User::select('id as userid', 'firstName', 'typeId')
                ->where('typeId', 4)
                ->where('active', 1)
                ->get();
        }


        $failReport = Failreport::select('failreport.*', 'users.firstName')
            ->leftJoin('users', 'users.id', 'failreport.userId')
            ->whereBetween(DB::raw('DATE(failreport.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->orderBy('failreport.id', 'desc')
            ->get();

//        return $failReport;

        $calledThisWeek = Workprogress::select('userId', DB::raw('count(*) as userCall'))
            ->where('workprogress.callingReport', '!=', null)
            ->where('callingReport', '!=', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $newFiles = NewFile::whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->subDays(30), date('Y-m-d')])
            ->get();


        $leadMinedThisWeek = Lead::select('minedBy', DB::raw('count(*) as userLeadMined'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();


        $followupThisWeek = Workprogress::select('userId', DB::raw('count(*) as userFollowup'))
            ->where('callingReport', 4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $highPosibilitiesThisWeekRa = Lead::select('minedBy', DB::raw('count(*) as userHighPosibilities'))
            ->where('filteredPossibility', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('minedBy')
            ->get();


        $highPosibilitiesThisWeekUser = Possibilitychange::select('userId', DB::raw('count(*) as userHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $highPosibilitiesThisWeekUser;

        $assignedLead = Leadassigned::select('assignTo', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignTo')
            ->get();

//       return $assignedLead;

        $assignedLeadRa = Leadassigned::select('assignBy', DB::raw('count(*) as userAssignedLead'))
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('assignBy')
            ->get();

//        return $assignedLeadRa;

        $uniqueHighPosibilitiesThisWeek = Possibilitychange::select('userId', DB::raw('count(DISTINCT leadId) as userUniqueHighPosibilities'))
            ->where('possibilityId', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $uniqueHighPosibilitiesThisWeek;

        $testLead = Workprogress::select('userId', DB::raw('count(leadId) as userTestLead'))
            ->where('progress', 'Test Job')
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $testLead;
        $contacted = Workprogress::select('userId', DB::raw('count(*) as userContacted'))
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $emailed = Workprogress::select('userId', DB::raw('count(*) as userEmailed'))
            ->where('callingReport', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

        $coldemailed = Workprogress::select('userId', DB::raw('count(*) as usercoldEmailed'))
            ->where('callingReport', 8)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

        $other = Workprogress::select('userId', DB::raw('count(*) as userOther'))
            ->where('callingReport', 6)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $notAvailable = Workprogress::select('userId', DB::raw('count(*) as userNotAvialable'))
            ->where('callingReport', 2)
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();


        $contactedUsa = Workprogress::select('userId', DB::raw('count(*) as userContactedUsa'))
            ->leftJoin('leads', 'workprogress.leadId', 'leads.leadId')
            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
            ->where('countries.countryName', 'like', '%USA%')
            ->where('callingReport', 5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->groupBy('userId')
            ->get();

//        return $contactedUsa;

        $closing = Workprogress::select('userId', DB::raw('count(*) as userClosing'))
            ->where('progress', 'Closing')
            ->groupBy('userId')
            ->whereBetween(DB::raw('DATE(created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();

//        return $closing;

        $newCall = NewCall::leftJoin('workprogress', 'workprogress.progressId', 'new_call.progressId')
            ->where('workprogress.callingReport', 5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();


        $testLeadForRa = Workprogress::select('minedBy')
            ->where('progress', 'Test Job')
            ->leftJoin('leads', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('users', 'users.id', 'leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$date->startOfWeek()->format('Y-m-d'), $date->endOfWeek()->format('Y-m-d')])
            ->get();

//        return $testLeadForRa;


        return view('report.supervisor.value')
            ->with('users', $users)
            ->with('contactedUsa', $contactedUsa)
            ->with('contacted', $contacted)
            ->with('testLead', $testLead)
            ->with('uniqueHighPosibilitiesThisWeek', $uniqueHighPosibilitiesThisWeek)
            ->with('assignedLead', $assignedLead)
            ->with('assignedLeadRa', $assignedLeadRa)
            ->with('highPosibilitiesThisWeekUser', $highPosibilitiesThisWeekUser)
            ->with('highPosibilitiesThisWeekRa', $highPosibilitiesThisWeekRa)
            ->with('followupThisWeek', $followupThisWeek)
            ->with('leadMinedThisWeek', $leadMinedThisWeek)
            ->with('calledThisWeek', $calledThisWeek)
            ->with('closing', $closing)
            ->with('usersRa', $usersRa)
            ->with('newCall', $newCall)
            ->with('newFiles', $newFiles)
            ->with('testLeadForRa', $testLeadForRa)
            ->with('failReport', $failReport)
            ->with('emailed', $emailed)
            ->with('coldemailed', $coldemailed)
            ->with('other', $other)
            ->with('notAvailable', $notAvailable);
    }*/

//End Tab
}
