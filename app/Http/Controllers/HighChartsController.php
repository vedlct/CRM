<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Country;
use Session;

class HighChartsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	
	
	public function showchart()
	{
		$viewer = View::select(DB::raw("SUM(numberofview) as count"))
			->orderBy("created_at")
			->groupBy(DB::raw("year(created_at)"))
			->get()->toArray();
		
		$viewer = array_column($viewer, 'count');
		 
		$click = Click::select(DB::raw("SUM(numberofclick) as count"))
			->orderBy("created_at")
			->groupBy(DB::raw("year(created_at)"))
			->get()->toArray(); // get data into array
	 
		$click = array_column($click, 'count');
	 
		return view('showchart') //return view
				->with('viewer',json_encode($viewer,JSON_NUMERIC_CHECK))
				->with('click',json_encode($click,JSON_NUMERIC_CHECK));
	}
}
