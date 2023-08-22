<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\SalesPipeline;
use App\Category;
use App\Possibility;
use App\Country;
use App\Lead;
use App\User;
use App\Probability;



class PipelineController extends Controller
{



    public function salesPipeline()
    {

        $UserType=Session::get('userType');
 
        $stages = [
            'Contact',
            'Conversation',
            'Possibility',
            'Test',
            'Closed',
            'Lost'
        ];
    
        $pipeline = [];
    
        foreach ($stages as $stage) {

            if($UserType == 'USER' || $UserType == 'MANAGER' ){

                $leads = SalesPipeline::select('salespipeline.*', 'leads.leadId', 'leads.companyName', 'leads.website', 'possibilities.possibilityName', 'leads.ippStatus')
                ->where('salespipeline.userId', Auth::user()->id)
                ->leftJoin('leads', 'salespipeline.leadId', 'leads.leadId')
                ->leftJoin('possibilities', 'leads.possibilityId', 'possibilities.possibilityId')
                ->where('leads.contactedUserId', Auth::user()->id)
                ->where('salespipeline.stage', 'LIKE', '%' . $stage . '%')
                ->where('salespipeline.workStatus', '1')
                ->get();

            } else {
                $leads = SalesPipeline::select('salespipeline.*', 'leads.leadId', 'leads.companyName', 'leads.website', 'possibilities.possibilityName', 'leads.ippStatus')
                // ->where('salespipeline.userId', Auth::user()->id)
                ->leftJoin('leads', 'salespipeline.leadId', 'leads.leadId')
                ->leftJoin('possibilities', 'leads.possibilityId', 'possibilities.possibilityId')
                // ->where('leads.contactedUserId', Auth::user()->id)
                ->where('salespipeline.stage', 'LIKE', '%' . $stage . '%')
                ->where('salespipeline.workStatus', '1')
                ->get();
                
            }

            $pipeline[$stage] = [
                'leads' => $leads,
                'total' => $leads->count()
            ];
        }
    
        return view('analysis.salesPipeline')->with('pipeline', $pipeline)->with('possibilities', '$possibilities');
    }
    
    


    
    public function createPipeline(Request $request)
    {
        $existingPipeline = SalesPipeline::where('leadId', $request->leadId)
            ->where('userId', Auth::user()->id)
            ->first();
    
        if ($existingPipeline) {
            $existingPipeline->workStatus = 1;
            $existingPipeline->stage = $request->stage;
            $existingPipeline->save();
            $message = 'Sales pipeline updated successfully.';
        } else {
            $pipeline = new SalesPipeline;
            $pipeline->leadId = $request->leadId;
            $pipeline->userId = Auth::user()->id;
            $pipeline->stage = $request->stage;
            $pipeline->workStatus = 1;
            $pipeline->save();
            $message = 'Sales pipeline created successfully.';
        }
    
        Session::flash('success', $message);
        return back();
    }
    




    public function updatePipeline(Request $request)
    {

        $salesPipeline = SalesPipeline::where('pipelineId', '=', $request->pipelineId)
          ->update(['stage' => $request->stage]);


        Session::flash('success', 'Sales Pipeline is updated');
        return back();
    }
            

    public function removePipeline(Request $request)
    {
        $pipelineId = $request->pipelineId;

        SalesPipeline::where('pipelineId', $pipelineId)
            ->update(['workStatus' => 0]);


        return back();
        Session::flash('success', 'Sales Pipeline has been removed');
    }



    public function assignToPipeline(Request $r)
    {
        if ($r->ajax()) {
            foreach ($r->leadId as $lead) {
                $pipeline = SalesPipeline::where('leadId', $lead)
                    ->where('userId', Auth::user()->id)
                    ->first();
    
                if ($pipeline) {
                    $pipeline->workStatus = 1;
                    $pipeline->stage = $r->stage;
                    $pipeline->save();
                } else {
                    $salesPipeline = new SalesPipeline;
                    $salesPipeline->leadId = $lead;
                    $salesPipeline->userId = Auth::user()->id;
                    $salesPipeline->stage = $r->stage;
                    $salesPipeline->workStatus = 1;
                    $salesPipeline->save();
                }
            }
    
            return response('true');
        }
    }



    public function pipelineReport()
    {
        $userType = Session::get('userType');
        
        if ($userType == 'ADMIN' || $userType == 'SUPERVISOR') {
            $pipelineData = SalesPipeline::select('users.userId')
                ->selectRaw("SUM(CASE WHEN stage = 'Contact' THEN 1 ELSE 0 END) as Contact")
                ->selectRaw("SUM(CASE WHEN stage = 'Conversation' THEN 1 ELSE 0 END) as Conversation")
                ->selectRaw("SUM(CASE WHEN stage = 'Possibility' THEN 1 ELSE 0 END) as Possibility")
                ->selectRaw("SUM(CASE WHEN stage = 'Test' THEN 1 ELSE 0 END) as Test")
                ->selectRaw("SUM(CASE WHEN stage = 'Closed' THEN 1 ELSE 0 END) as Closed")
                ->selectRaw("SUM(CASE WHEN stage = 'Lost' THEN 1 ELSE 0 END) as Lost")
                ->leftJoin('users', 'salesPipeline.userId', '=', 'users.id')
                ->where('salespipeline.workStatus', '1')
                ->groupBy('users.userId')
                ->get();
            
            return response()->json($pipelineData);
        }
    }
    



}
