<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Session;
use App\Team;
use App\User;
use Auth;
use App\DB;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myTeam()
    {
        $type=Auth::user()->typeId;
        if(!$type==5 || !$type==4){
            return Redirect()->route('home');
        }
        $users = User::where('teamId', Auth::user()->teamId)->get();
        $team = Team::findOrFail(Auth::user()->teamId);

        return view('layouts.Team.myTeam')
            ->with('users', $users)
            ->with('team', $team);
    }

    public function teamManagement()
    {
                $users = User::where('teamId', null)->get();
                $teams = Team::with('user')->get();
                $userAssigneds=User::where('users.teamId','!=',null)
                    ->leftJoin('teams','users.teamId','=','teams.teamId')->get();

                return view('layouts.Team.teamManagement')
                    ->with('users', $users)
                    ->with('teams', $teams)
                    ->with('userAssigneds',$userAssigneds);




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
