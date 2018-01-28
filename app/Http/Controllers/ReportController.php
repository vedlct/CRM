<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workprogress;
use App\User;
use Auth;
use DB;

class ReportController extends Controller
{
    public function index(){

//        select users.firstName,count(*) from users,workprogress where users.id=workprogress.userId GROUP BY workprogress.userId
//        $user=User::leftJoin('workprogress', 'users.id', '=', 'workprogress.userId')
//            ->select('users.firstName',DB::raw('count(*) as total'))
//            ->groupBy('workprogress.userId')->get();

        $user = User::with('work')
            ->select('firstName','userId')
            ->groupBy('userId')
            ->get();
        return $user;

        $users=User::get();
        return view('report.index')->with('users',$users);

    }

    public function individualCall($id){
        $report=Workprogress::where('userId',$id)->count();
       return $report;
  }




}
