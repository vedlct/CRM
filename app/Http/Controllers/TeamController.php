<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\User;
use Auth;
class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myTeam(){
        $users=User::where('teamId',Auth::user()->teamId)->get();
        $team=Team::findOrFail(Auth::user()->teamId);





        return view('layouts.myTeam')
            ->with('users',$users)
            ->with('team',$team);
    }



}
