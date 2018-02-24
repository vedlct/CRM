<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use DataTables;
use App\Lead;
use App\Possibility;
use DB;
class TestController extends Controller
{
//    protected $pAfter = '';
    public function index(){
        return view('layouts.lead.testList');
    }

    public function modal(){
    $v="value";
        return view('modal')->with('v',$v);
    }

    public function test(){
       // $leads = Lead::get();
////
////        return $leads;
//
//        return view('test');


// Execute the query

//        $leads=Lead::with('mined','category','country','possibility')
//            ->where('statusId',2)
//            ->where(function($q){
//                $q->orWhere('contactedUserId',0)
//                    ->orWhere('contactedUserId',null);
//            })
//            ->where('leadAssignStatus',0)
//            ->select('leads.*')->get();
       $time=(new Test())->test();
        return $time;




    }
    public function anyData(Request $r)
    {
//        $possibility=Possibility::get();
//
//        $pBefore='<select class="form-control" id="drop" ';
//        $pAfter=' name="possibility" ><option value="">Select</option>';
//        foreach ($possibility as $pos){
//            $pAfter.='<option value="'.$pos->possibilityId.'">'.$pos->possibilityName.'</option>';
//        }
//        $pAfter.='</select>';
//
//        $leads=Lead::select('leadId','companyName','personName','email','contactNumber','created_at');
//        return DataTables::of($leads,$pBefore,$pAfter)
//            ->addColumn('action', function ($lead) {
//                return '<a href="'.$lead->leadId.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
//            })
//            ->addColumn('drop', function ($lead,$pBefore,$pAfter) {
//                return $pBefore.$lead->leadId.' "'.$pAfter;
//            })
//            ->make(true);

        $leads = Lead::with('mined')
        ->where('statusId',5)->get();

        return DataTables::of($leads)->make(true);



    }
}
