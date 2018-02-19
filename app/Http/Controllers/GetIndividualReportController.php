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
    public function getHighPossibilityIndividual(Request $r){

        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);



        if($user->typeId == 4) {
            $highPosibilitiesThisWeek = Lead::select('leads.*','possibilitychanges.created_at')
                ->with('country','category','possibility')
                ->where('minedBy', $user->id)
                ->leftJoin('possibilitychanges', 'leads.leadId', 'possibilitychanges.leadId')
                ->where('possibilitychanges.possibilityId', 3)
                ->whereBetween('possibilitychanges.created_at', [$fromDate,$toDate])->get();
        }

        else{
            $highPosibilitiesThisWeek=Lead::select('leads.*','possibilitychanges.created_at')
                ->with('country','category','possibility')
                ->leftJoin('possibilitychanges', 'leads.leadId', 'possibilitychanges.leadId')
                ->where('possibilitychanges.userId',$user->id)
                ->where('possibilitychanges.possibilityId',3)
                ->whereBetween('possibilitychanges.created_at', [$fromDate,$toDate])->get();
        }


//        return $highPosibilitiesThisWeek;
        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                 <th>Created_at</th>
      </tr></thead>
    <tbody>';
        foreach ($highPosibilitiesThisWeek as $l){
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




    public function getCallIndividual(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $user=User::findOrFail($r->userid);
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at')
                ->with('country','category','possibility')
                ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                ->where('workprogress.userId',$user->id)
                ->whereBetween('workprogress.created_at', [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Call Date</th>
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
            ->whereBetween('created_at', [$fromDate,$toDate])->get();

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
            ->whereBetween('leadassigneds.created_at',[$fromDate,$toDate])->get();

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
}
