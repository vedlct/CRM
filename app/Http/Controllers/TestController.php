<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        return view('layouts.lead.testList');
    }

    public function modal(){
    $v="value";
        return view('modal')->with('v',$v);
    }
}
