<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Team;
use App\User;
use Auth;
use Mockery\Exception;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myTeam()
    {
        $users = User::where('teamId', Auth::user()->teamId)->get();
        $team = Team::findOrFail(Auth::user()->teamId);

        return view('layouts.Team.myTeam')
            ->with('users', $users)
            ->with('team', $team);
    }

    public function teamManagement()
    {
        $users = User::where('teamId', null)->get();
        $teams = Team::get();

        return view('layouts.Team.teamManagement')
            ->with('users', $users)
            ->with('teams', $teams);
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

}
