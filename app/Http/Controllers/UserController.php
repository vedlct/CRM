<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Usertype;
use App\Test;

class UserController extends Controller
{
    public  function index(){

        $user =User::get();


        return view('test')->with('user',$user);

    }


    public function test(){

        $table=Test::get();


        return view('layouts.assignreport')->with('table',$table);


    }


}
