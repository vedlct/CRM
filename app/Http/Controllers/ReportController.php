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



    //select users.firstName,count(workprogress.userId)
    // from users LEFT JOIN workprogress on users.id=workprogress.userId GROUP BY workprogress.userId

        $users= User::select('users.firstName',DB::raw('count(workprogress.userId) as total'))
            ->leftJoin('workprogress','users.id','workprogress.userId')
            ->where(DB::raw('DATE(workprogress.created_at)'),'2018-01-28')
            ->groupBy('workprogress.userId')
            ->get();

        return $users;


        return view('report.index')->with('users',$users);

    }

    public function individualCall($id){
        $report=Workprogress::where('userId',$id)->count();
       return $report;
  }




}
