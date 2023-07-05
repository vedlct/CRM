<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Usertype;
use App\Test;
use App\Designation;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public  function index(){

        $user =User::get();

        $designations = Designation::get();


        return view('test')->with('user',$user)->with('designations', '$designations');

    }


    public function test(){

      $table=Test::get();



        return view('layouts.assignreport')->with('table',$table);


    }


}
