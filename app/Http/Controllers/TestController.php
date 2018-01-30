<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Lead;
class TestController extends Controller
{
    public function index(){
        return view('layouts.lead.testList');
    }

    public function modal(){
    $v="value";
        return view('modal')->with('v',$v);
    }

    public function test(){
        return view('test');
    }
    public function anyData(Request $r)
    {
        $leads=Lead::select('leadId','companyName','personName','email','contactNumber','created_at');
        return DataTables::of($leads)
            ->addColumn('action', function ($lead) {
                return '<a href="'.$lead->leadId.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->make(true);
    }
}
