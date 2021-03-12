<?php

namespace App\Http\Controllers;

use App\Country;
use App\NewCall;
use App\NewFile;
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

class
GetIndividualCountryReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getHighPossibilityIndividualCountry(Request $r){
        $country=Country::where('countryId', $r->countryid)->first();

        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }


//        if($user->typeId == 4) {
//            $highPosibilitiesThisWeek = Lead::select('leads.*')
//                ->with('country','category','possibility')
//                ->where('minedBy', $user->id)
//                ->where('filteredPossibility',3)
//                ->whereBetween(DB::raw('DATE(created_at)'),[$fromDate,$toDate])->get();
//        }

//        else{
//            SELECT * FROM `possibilitychanges` LEFT JOIN workprogress ON possibilitychanges.created_at = workprogress.created_at WHERE possibilitychanges.changeId=197
//            $highPosibilitiesThisWeek=Lead::select('leads.*','workprogress.comments','possibilitychanges.created_at','possibilitychanges.changeId','possibilitychanges.approval')
//                ->with('country','category','possibility')
//                ->leftJoin('possibilitychanges', 'leads.leadId', 'possibilitychanges.leadId')
//                ->where('possibilitychanges.userId',$user->id)
//                ->where('possibilitychanges.possibilityId',3)
//                ->leftJoin('workprogress', 'possibilitychanges.created_at', 'workprogress.created_at')
//                ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$fromDate,$toDate])->get();
            $highPosibilitiesThisWeek=Lead::select('leads.*','possibilitychanges.created_at','possibilitychanges.changeId','possibilitychanges.approval')
                ->with('country','category','possibility')
                ->leftJoin('possibilitychanges', 'leads.leadId', 'possibilitychanges.leadId')
                ->where('leads.countryId',$country->countryId)
                ->where('possibilitychanges.possibilityId',3)
                ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$fromDate,$toDate])
                ->get();



//        }
//        $comments=Workprogress::where('userId',$user->id)
//            ->whereBetween(DB::raw('DATE(created_at)'), [$fromDate,$toDate])
//            ->get();


//        return $highPosibilitiesThisWeek;
        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Created_at</th>';
//        if(Session::get('userType')=='ADMIN' && $user->typeId!=4){
//            $table.='<th>action</th>';
//
//        }
        $table.='</tr></thead><tbody>';

        foreach ($highPosibilitiesThisWeek as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>';

               $check=false;
//                foreach ($comments as $comment)
//                {
//                    if($comment->created_at ==$l->created_at ){
//                        $table.= '<td>'.$comment->comments.'</td>';
//                        $check=true;
//                        break;
//
//                    }
//                }
                if($check==false){
                    $table.= '<td></td>';
                }
                $table.= '</td><td>'.$l->created_at.'</td>';


            $comment='';


//            if(Session::get('userType')=='ADMIN' && $user->typeId!=4) {

//                $table .= '<td><select class="form-control"  name="aprove" id="' . $l->changeId . '" data-changeid="' . $l->changeId . '" onChange="test(this)">';
//                if ($l->approval == 1) {
//                    $table .= '<option value="">select</option>
//                        <option value="1" selected>Approve</option>
//                        <option value="0">Decline</option>
//                      </td>
//                    </tr>';
//                } else if ($l->approval == 2) {
//                    $table .= '<option value="">select</option>
//                        <option value="1" >Approve</option>
//                        <option value="0" selected>Decline</option>
//                      </td>
//                    </tr>';
//
//                } else if ($l->approval == null) {
//                    $table .= '<option value="" selected>select</option>
//                        <option value="1" >Approve</option>
//                        <option value="0">Decline</option>
//                      </td>
//                    </tr>';
//                }

//            }

        }
        $table.='</tbody></table>';



        return Response($table);
    }



    public function getHighPossibilityUnIndividualCountry(Request $r){
        $country=Country::where('countryId', $r->countryid)->first();

        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }


//        if($user->typeId == 4) {
//            $highPosibilitiesThisWeek = Lead::select('leads.*')
//                ->with('country','category','possibility')
//                ->where('minedBy', $user->id)
//                ->where('filteredPossibility',3)
//                ->whereBetween(DB::raw('DATE(created_at)'),[$fromDate,$toDate])->get();
//        }

//        else{
//            SELECT * FROM `possibilitychanges` LEFT JOIN workprogress ON possibilitychanges.created_at = workprogress.created_at WHERE possibilitychanges.changeId=197
            $highPosibilitiesThisWeek=Lead::select('leads.*','possibilitychanges.created_at','possibilitychanges.changeId','possibilitychanges.approval')
                ->with('country','category','possibility')
                ->leftJoin('possibilitychanges', 'leads.leadId', 'possibilitychanges.leadId')
                ->where('leads.countryId',$country->countryId)
                ->where('possibilitychanges.possibilityId',3)
                ->groupBy('possibilitychanges.leadId')
                ->whereBetween(DB::raw('DATE(possibilitychanges.created_at)'), [$fromDate,$toDate])->get();

//        }

//        $comments=Workprogress::where('userId',$user->id)
//            ->whereBetween(DB::raw('DATE(created_at)'), [$fromDate,$toDate])
//            ->get();



//        return $highPosibilitiesThisWeek;
        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Created_at</th>';
//        if(Session::get('userType')=='ADMIN' && $user->typeId!=4){
//            $table.='<th>action</th>';
//
//        }
        $table.='</tr></thead><tbody>';

        foreach ($highPosibilitiesThisWeek as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>';
            $check=false;
//            foreach ($comments as $comment)
//            {
//                if($comment->created_at ==$l->created_at ){
//                    $table.= '<td>'.$comment->comments.'</td>';
//                    $check=true;
//                    break;
//
//                }
//            }
            if($check==false){
                $table.= '<td></td>';
            }
            $table.= '</td><td>'.$l->created_at.'</td>';
         
//            }

            $comment='';


//            if(Session::get('userType')=='ADMIN' && $user->typeId!=4) {
//
//                $table .= '<td><select class="form-control"  name="aprove" id="' . $l->changeId . '" data-changeid="' . $l->changeId . '" onChange="test(this)">';
//                if ($l->approval == 1) {
//                    $table .= '<option value="">select</option>
//                        <option value="1" selected>Approve</option>
//                        <option value="0">Decline</option>
//                      </td>
//                    </tr>';
//                } else if ($l->approval == 2) {
//                    $table .= '<option value="">select</option>
//                        <option value="1" >Approve</option>
//                        <option value="0" selected>Decline</option>
//                      </td>
//                    </tr>';
//
//                } else if ($l->approval == null) {
//                    $table .= '<option value="" selected>select</option>
//                        <option value="1" >Approve</option>
//                        <option value="0">Decline</option>
//                      </td>
//                    </tr>';
//                }
//
//            }

        }
        $table.='</tbody></table>';



        return Response($table);
    }



    public function approvalCountry(Request $r){
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



    public function getCallIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
                ->with('country','category','possibility')
                ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
                ->where('leads.countryId',$country->countryId)
                ->where('workprogress.callingReport','!=',null)
                ->where('workprogress.callingReport','!=',6)
                ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }

    public function getFollowupIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at')
            ->with('country','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',4)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Country</th>
                 <th>Comment</th>
                <th>Created At</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->possibility->possibilityName.'</td>
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                     <td>'.$l->comments.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }



    public function getTestIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.progress','Test Job')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }



    public function getClosingIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.progress','Closing')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';

        }
        $table.='</tbody></table>';
        return Response($table);
    }


    public function getFileCountIndividualCountry(Request $r){
        $date = Carbon::now();
//        $fromDate=$date->startOfWeek()->format('Y-m-d');
//        $toDate=$date->endOfWeek()->format('Y-m-d');

        $fromDate=Carbon::now()->subDays(30);
        $toDate=date('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){

            $fromDate=Carbon::parse($r->fromdate)->subDays(30)->format('Y-m-d');
            $toDate=$r->todate;
        }

        $leads = Lead::select('leads.*')
            ->with('country','category','possibility')
            ->where('leads.countryId',$r->countryid)
            ->whereBetween(DB::raw('DATE(leads.created_at)'), [$fromDate,$toDate])->get();

//        $newFile=NewFile::select('new_file.*','leads.companyName','new_file.new_fileId as fid')
//            ->where('userId',$r->userid)
//            ->whereBetween(DB::raw('DATE(new_file.created_at)'), [$fromDate,$toDate])
//            ->leftJoin('leads','leads.leadId','new_file.leadId')
//            ->get();

//        return $newFile;

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>File Count</th>
                 <th>Created_at</th>
      </tr></thead>
    <tbody>';

//        foreach ($newFile as $l){
//            $table.='<tr>
//                    <td>'.$l->companyName.'</td>
//                    <td data-panel-id="'.$l->fid.'" onclick="listenForDoubleClick(this);" onblur="this.contentEditable=false;" onfocusout="changeQuantity(this)">'.$l->fileCount.'</td>
//                    <td>'.$l->created_at.'</td>
//                    </tr>';
//
//        }
        $table.='</tbody></table>';
        return Response($table);

    }

    public function updateNewFileCountry(Request $r){

        $file=NewFile::findOrFail($r->id);
        $newFile=new NewFile();
        $newFile->leadId=$file->leadId;
        $newFile->fileCount=$r->rate;
//        $newFile->userId=Auth::user()->id;
        $newFile->userId=$file->userId;
        $newFile->save();
        return $r;
    }



    public function getMineIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*')
            ->with('country','category','possibility')
            ->where('leads.countryId',$country->countryId)
            ->whereBetween(DB::raw('DATE(leads.created_at)'), [$fromDate,$toDate])->get();

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


    public function getAssignedLeadIndividualCountry(Request $r){

        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();


//        if($user->typeId==4){
//            $leads = Lead::select('leads.*','leadassigneds.created_at','leadassigneds.leaveDate','users.firstName')
//                ->with('country','category','possibility')
//                ->leftJoin('leadassigneds','leads.leadId','leadassigneds.leadId')
//                ->leftJoin('users','users.id','leadassigneds.assignTo')
//                ->where('leadassigneds.assignBy',$user->id)
//                ->whereBetween(DB::raw('DATE(leadassigneds.created_at)'),[$fromDate,$toDate])->get();
//
//            $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
//                 <th>Assign To</th>
//                 <th>CompanyName</th>
//                 <th>Possibility</th>
//                 <th>Category</th>
//                 <th>Country</th>
//                <th>Assign Date</th>
//                 <th>Leave</th>
//      </tr></thead>
//    <tbody>';
//            foreach ($leads as $l){
//                $table.='<tr>
//                    <td>'.$l->firstName.'</td>
//                    <td>'.$l->companyName.'</td>
//                    <td>'.$l->possibility->possibilityName.'</td>
//                    <td>'.$l->category->categoryName.'</td>
//                    <td>'.$l->country->countryName.'</td>
//                    <td>'.$l->created_at.'</td>
//                    <td>'.$l->leaveDate.'</td>
//                    </tr>';
//            }
//
//            $table.='</tbody></table>';
//            return Response($table);
//
//        }

        $leads = Lead::select('leads.*','leadassigneds.created_at','leadassigneds.leaveDate','users.firstName')
            ->with('country','category','possibility')
            ->leftJoin('leadassigneds','leads.leadId','leadassigneds.leadId')
            ->leftJoin('users','users.id','leadassigneds.assignBy')
            ->where('leads.countryId',$country->countryId)
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


    public function getContactedIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }


    public function getContactedUsaIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report','countries.countryName')
            ->with('category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->leftJoin('countries','leads.countryId','countries.countryId')
            ->where('countries.countryName','like','%USA%')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',5)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }


    public function getNewCallIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }

        $newCAll=NewCall::select('new_call.*','leads.companyName')
            ->leftJoin('workprogress','workprogress.progressId','new_call.progressId')
            ->leftJoin('leads','leads.leadId','workprogress.leadId')
            ->where('leads.countryId',$r->countryid)

            ->where('workprogress.callingReport',5)
            ->whereBetween(DB::raw('DATE(new_call.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($newCAll as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);

    }


    public function getTestFileRaIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }


        $testLeadForRa=Workprogress::select('leads.companyName','workprogress.created_at')
            ->where('progress','Test Job')
            ->leftJoin('leads','leads.leadId','workprogress.leadId')
            ->leftJoin('users','users.id','leads.minedBy')
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])
            ->where('leads.countryId',$r->countryid)
            ->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';

        foreach ($testLeadForRa as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);

    }

    public function getEmailIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',3)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);

    }

    public function getcoldEmailIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',8)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);

    }

    public function getCategoryLeadCountry(Request $r){
        $category =  $r->categoryid;
        $possibility =  $r->possibilityid;
       /* $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');*/

        /*if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }*/
        $leads = Lead::where('categoryId', $category)->where('possibilityId', $possibility)->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);

    }

    public function getStatusLeadCountry(Request $r){
        $status =  $r->statusid;
        $possibility =  $r->possibilityid;
        /* $date = Carbon::now();
         $fromDate=$date->startOfWeek()->format('Y-m-d');
         $toDate=$date->endOfWeek()->format('Y-m-d');*/

        /*if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }*/
        $leads = Lead::where('statusId', $status)->where('possibilityId', $possibility)->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Country</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->country->countryName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }

    public function getNotDoneFollowupCountry(Request $r){

        $userId = $r->userId;

        if($r->fromdate && $r->todate){
            $fromdate = $r->fromdate;
            $todate = $r->todate;

            $followupDetails = collect(DB::select(DB::raw("SELECT DISTINCT(fl.leadId), fl.followUpDate, leads.companyName, possibilities.possibilityName, categories.categoryName FROM followup fl LEFT JOIN leads ON leads.leadId = fl.leadId LEFT JOIN possibilities ON possibilities.possibilityId = leads.possibilityId left join categories on categories.categoryId = leads.categoryId WHERE fl.leadId not in (SELECT DISTINCT(leadId) FROM workprogress WHERE DATE(workprogress.created_at) BETWEEN '".$fromdate."' AND '".$todate."') AND fl.followUpDate BETWEEN '".$fromdate."' AND '".$todate."' AND fl.userId = '".$userId."' group by fl.followId")));
        }

        else{
            $followupDetails = collect(DB::select(DB::raw("SELECT DISTINCT(fl.leadId), fl.followUpDate, leads.companyName, possibilities.possibilityName, categories.categoryName FROM followup fl LEFT JOIN leads ON leads.leadId = fl.leadId LEFT JOIN possibilities ON possibilities.possibilityId = leads.possibilityId left join categories on categories.categoryId = leads.categoryId WHERE fl.leadId not in (SELECT DISTINCT(leadId) FROM workprogress WHERE DATE(workprogress.created_at) = '2020-09-10') AND fl.followUpDate = '2020-09-10' AND fl.userId = '".$userId."' group by fl.followId")));
        }

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>Lead ID</th>
                 <th>Company Name</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Follow-Up Date</th>
      </tr></thead>
    <tbody>';
        foreach ($followupDetails as $lead){
            $table.='<tr>
                    <td>'.$lead->leadId.'</td>
                    <td>'.$lead->companyName.'</td>
                    <td>'.$lead->possibilityName.'</td>
                    <td>'.$lead->categoryName.'</td>
                    <td>'.$lead->followUpDate.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }

    public function getAllFollowupCountry(Request $r){
        $userId = $r->userId;

        if($r->fromdate && $r->todate){
            $fromdate = $r->fromdate;
            $todate = $r->todate;

            $followupDetails = collect(DB::select(DB::raw("SELECT DISTINCT(fl.leadId), fl.followUpDate, leads.companyName, possibilities.possibilityName, categories.categoryName, fl.userId FROM followup fl LEFT JOIN leads ON leads.leadId = fl.leadId LEFT JOIN possibilities ON possibilities.possibilityId = leads.possibilityId left join categories on categories.categoryId = leads.categoryId WHERE fl.followUpDate BETWEEN '".$fromdate."' AND '".$todate."' AND userId = '".$userId."' group by fl.followId")));
        }

        else{
            $followupDetails = collect(DB::select(DB::raw("SELECT DISTINCT(fl.leadId), fl.followUpDate, leads.companyName, possibilities.possibilityName, categories.categoryName, fl.userId FROM followup fl LEFT JOIN leads ON leads.leadId = fl.leadId LEFT JOIN possibilities ON possibilities.possibilityId = leads.possibilityId left join categories on categories.categoryId = leads.categoryId WHERE fl.followUpDate = '2020-09-10' AND userId = '".$userId."' group by fl.followId")));
        }

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>Lead ID</th>
                 <th>Company Name</th>
                 <th>Possibility</th>
                 <th>Category</th>
                 <th>Follow-Up Date</th>
      </tr></thead>
    <tbody>';
        foreach ($followupDetails as $lead){
            $table.='<tr>
                    <td>'.$lead->leadId.'</td>
                    <td>'.$lead->companyName.'</td>
                    <td>'.$lead->possibilityName.'</td>
                    <td>'.$lead->categoryName.'</td>
                    <td>'.$lead->followUpDate.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }

    public function getCountryLeadCountry(Request $r){
        $country =  $r->countryid;
        $possibility =  $r->possibilityid;
        /* $date = Carbon::now();
         $fromDate=$date->startOfWeek()->format('Y-m-d');
         $toDate=$date->endOfWeek()->format('Y-m-d');*/

        /*if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }*/
        $leads = Lead::where('countryId', $country)->where('possibilityId', $possibility)->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Comment</th>
                 <th>Report</th>
                 <th>Call Date</th>
      </tr></thead>
    <tbody>';
        foreach ($leads as $l){
            $table.='<tr>
                    <td>'.$l->companyName.'</td>
                    <td>'.$l->comments.'</td>
                    <td>'.$l->report.'</td>
                    <td>'.$l->created_at.'</td>
                    </tr>';
        }
        $table.='</tbody></table>';
        return Response($table);
    }

    public function getOtherIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',6)
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
    public function getNotAvailableIndividualCountry(Request $r){
        $date = Carbon::now();
        $fromDate=$date->startOfWeek()->format('Y-m-d');
        $toDate=$date->endOfWeek()->format('Y-m-d');

        if($r->fromdate !=null && $r->todate !=null){
            $fromDate=$r->fromdate;
            $toDate=$r->todate;
        }
        $country=Country::where('countryId', $r->countryid)->first();
        $leads = Lead::select('leads.*','workprogress.comments','workprogress.created_at','callingreports.report')
            ->with('country','category','possibility')
            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
            ->leftJoin('callingreports', 'callingreports.callingReportId', 'workprogress.callingReport')
            ->where('leads.countryId',$country->countryId)
            ->where('workprogress.callingReport',2)
            ->whereBetween(DB::raw('DATE(workprogress.created_at)'), [$fromDate,$toDate])->get();

        $table='<table id="myTable" class="table table-bordered table-striped"><thead><tr>
                 <th>CompanyName</th>
                 <th>Possibility</th>
                 <th>Category</th>
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
                    <td>'.$l->category->categoryName.'</td>
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
