<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use App\Team;
use App\User;
use Auth;
use DB;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myTeam()
    {
        //for user and RA
//        $type=Auth::user()->typeId;
        $User_Type=Session::get('userType');

        if($User_Type=='USER'|| $User_Type=='RA' || $User_Type=='MANAGER'){

        $users = User::where('teamId', Auth::user()->teamId)->get();
//        $team = Team::findOrFail(Auth::user()->teamId);
            try {
                $team = Team::findOrFail(Auth::user()->teamId);
            } catch (ModelNotFoundException $ex) {
               return '<h1>You are not assigned into any team yet</h1>';
            }

        return view('layouts.Team.myTeam')
            ->with('users', $users)
            ->with('team', $team);
        }

    }

    public function teamManagement()
    {
        //for SuperVisor
        $User_Type=Session::get('userType');

        if($User_Type=='SUPERVISOR'){
        $users = User::where('teamId',null)
                ->where(function($q){
                $q->orWhere('typeId',2)
                    ->orWhere('typeId',5);
                    })
                ->get();
                $teams = Team::with('user')->get();

                $userAssigneds=User::where('users.teamId','!=',null)
                    ->leftJoin('teams','users.teamId','=','teams.teamId')->get();

                return view('layouts.Team.teamManagement')
                    ->with('users', $users)
                    ->with('teams', $teams)
                    ->with('userAssigneds',$userAssigneds);}
        return Redirect()->route('home');


                }

    public function teamAssign(Request $r)
    {
        $teamId=$r->teamId;

        if ($r->ajax()) {
            foreach ($r->userId as $userId) {


                    $user = User::findOrFail($userId);
                    $user->teamId = $teamId;
                    $user->save();

                    }

            return Response('true');

            }

        }



    public function removeUser(Request $r){
        $user= User::findOrFail($r->id);
        $user->teamId=null;
        $user->save();
        Session::flash('message', 'User Removed successfully');
        return back();
    }


    public function addTeam(){
        $teams=Team::get();

        return view('layouts.team.addTeam')
                ->with('teams',$teams);
    }


    public function insertTeam(Request $r){
        $this->validate($r,[
            'teamName'=>'required|max:50|unique:teams,teamName'
        ]);
        $team=new Team;
        $team->teamName=$r->teamName;
        $team->save();
        Session::flash('message', 'Team Added successfully');
        return back();
    }


    public function deleteTeam($id){
        $team=Team::findOrFail($id);
        $team->delete();
        Session::flash('message', 'Team Deleted successfully');
        return back();
    }

    public function teamUpdate(Request $r){
        $this->validate($r,[
            'teamName'=>'required|max:50|unique:teams,teamName',
            'teamId'=>'required'
        ]);

        $team=Team::findOrFail($r->teamId);
        $team->teamName=$r->teamName;
        $team->save();
        Session::flash('message', 'Team Updated successfully');
        return back();

    }

}
