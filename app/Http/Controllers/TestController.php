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
        $leads=Lead::select('companyName','personName','email','contactNumber','created_at')->get();
        return DataTables::of($leads)->make(true);
    }
}
