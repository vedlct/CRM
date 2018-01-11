<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Usertype;

class UserController extends Controller
{
    public  function index(){

        $user =User::get();


        return view('test')->with('user',$user);

    }
}
