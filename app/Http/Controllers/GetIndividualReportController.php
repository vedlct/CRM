<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
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

class GetIndividualReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getHighPossibilityIndividual(Request $r){
        $user=User::findOrFail($r->userid);

        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }


        if($user->typeId == 4) {
            $highPosibilitiesThisWeek = Lead::select('leads.*')
                ->with('country','category','possibility')
                ->where('minedBy', $user->id)
                ->where('filteredPossibility',3)
                ->whereBetween(DB::raw('DATE(created_at)'),[$fromDate,$toDate])->get();
        }

        else{
            $highPosibilitiesThisWeek=Lead::select('leads.*','possibilitychanges.created_at','possibilitychanges.changeId','possibilitychanges.approval')
                ->with('country','category','possibility')
                ->leftJoin('possibilitychanges', 'leads.leadId', 'possibilitychanges.leadId')
                ->where('possibilitychanges.userId',$user->id)
                ->where('possibilitychanges.possibilityId',3)
                ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$fromDate,$toDate])->get();

        }


//        return $highPosibilitiesThisWeek;
        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Created_at</th>';
        if(Session::get('userType')=='ADMIN' && $user->typeId!=4){
            $table.='<th>action</th>';

        }
        $table.='</tr></thead><tbody>';

        foreach ($highPosibilitiesThisWeek as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>';
            $comment=Workprogress::select('comments')->where('leadId',$l->leadId)->orderBy('progressId','desc')->first();
            if(!empty($comment)){
                $table.= '<td>'.$comment->comments.'</td>
                    </td><td>'.$l->created_at.'</td>';
            }

            else{
                $table.= '<td></td>
                    </td><td>'.$l->created_at.'</td>';
            }

            $comment='';


            if(Session::get('userType')=='ADMIN' && $user->typeId!=4) {

                $table .= '<td><select class="form-control"  name="aprove" id="' . $l->changeId . '" data-changeid="' . $l->changeId . '" onChange="test(this)">';
                if ($l->approval == 1) {
                    $table .= '<option value="">select</option> 
                        <option value="1" selected>Approve</option>
                        <option value="0">Decline</option>
                      </td>
                    </tr>';
                } else if ($l->approval == 2) {
                    $table .= '<option value="">select</option> 
                        <option value="1" >Approve</option>
                        <option value="0" selected>Decline</option>
                      </td>
                    </tr>';

                } else if ($l->approval == null) {
                    $table .= '<option value="" selected>select</option> 
                        <option value="1" >Approve</option>
                        <option value="0">Decline</option>
                      </td>
                    </tr>';
                }

            }

        }
        $table.='</tbody></table>';



        return Response($table);
    }

    public function approval(Request $r){
        $possibilityChanges=Possibilitychange::findOrFail($r->changeId);
        if($r->value==0){
            $possibilityChanges->possibilityId=2;
            $lead=Lead::findOrFail($possibilityChanges->leadId);
            $lead->possibilityId=2;
            $lead->save();
        }
        $possibilityChanges->approval=$r->value;
        $possibilityChanges->save();

        return Response($r);
    }



    public function getCallIndividual(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
                ->with('country','category','possibility')
                ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
                ->where('workprogress.userId',$user->id)
                ->where('workprogress.callingReport','!=',null)
                ->where('workprogress.callingReport','!=',6)
                ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }

    public function getFollowupIndividual(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at')
            ->with('country','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->where('workprogress.userId',$user->id)
            ->where('workprogress.callingReport',4)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Country</th>
                 <th>Comment</th>
                <th>Created At</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->country->countryName.'</td>
                     <td>'.$l->comments.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }



    public function getTestIndividual(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('workprogress.userId',$user->id)
            ->where('workprogress.progress','Test Job')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }



    public function getClosingIndividual(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('workprogress.userId',$user->id)
            ->where('workprogress.progress','Closing')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }






    public function getMineIndividual(Request $r){


        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*')
            ->with('country','category','possibility')
            ->where('minedBy',$user->id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                 <th>Created_at</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }


    public function getAssignedLeadIndividual(Request $r){

        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);

        $leads = Lead::select('leads.*','leadassigneds.created_at','leadassigneds.leaveDate','users.firstName')
            ->with('country','category','possibility')
            ->leftJoin('leadassigneds','leads.leadId','leadassigneds.leadId')
            ->leftJoin('users','users.id','leadassigneds.assignBy')
            ->where('leadassigneds.assignTo',$user->id)
            ->whereBetween(DB::raw('DATE(leadassigneds.created_at)'),[$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>Assign By</th>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                <th>Assign Date</th>
                 <th>Leave</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->firstName.'</td>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->created_at.'</td>
                    <td>'.$l->leaveDate.'</td>
                    </tr>';
        }

        $table.='</tbody></table>';
        return Response($table);
    }


    public function getContactedIndividual(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('workprogress.userId',$user->id)
            ->where('workprogress.callingReport',5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }






}
