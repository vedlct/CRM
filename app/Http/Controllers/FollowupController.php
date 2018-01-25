<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\User;
use App\Usertype;
use App\Followup;
use Image;
use Auth;
use App\Callingreport;
use App\Possibility;


class FollowupController extends Controller
{
       /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/follow-up';

         /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $followups = DB::table('followup')
		->where('followUpDate', date('Y-m-d'))
        ->leftJoin('leads', 'followup.leadId', '=', 'leads.leadId')
        ->leftJoin('categories', 'categories.categoryId', '=', 'leads.categoryId')
        ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
        ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
        ->leftJoin('users', 'users.id', '=', 'leads.minedBy')
        ->select('followup.*', 'users.*', 'leads.*', 'countries.*', 'categories.*')
        ->get();
		
		  $callReports=Callingreport::get();
		 /// return $callReports;
            $possibilities=Possibility::get();

        return view('follow-up/index', ['followups' => $followups, 'callReports' => $callReports, 'possibilities' => $possibilities]);
    }


    public function destroy($id){
        $lead=Lead::findOrFail($id);
        $lead->delete();
        Session::flash('message', 'Lead deleted successfully');
        return back();
    }


    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'fromdate' => $request['fromdate'],
            'todate' => $request['todate'],
            ];

        $followups = DB::table('followup')
			->whereBetween( 'followUpDate', array($constraints['fromdate'],$constraints['todate']))
			->leftJoin('leads', 'followup.leadId', '=', 'leads.leadId')
			->leftJoin('categories', 'categories.categoryId', '=', 'leads.categoryId')
			->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
			->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
			->leftJoin('users', 'users.id', '=', 'leads.minedBy')
			->select('followup.*', 'users.*', 'leads.*', 'countries.*', 'categories.*')
			->paginate(5);
       return view('follow-up/index', ['followups' => $followups, 'searchingVals' => $constraints]);
    }
}
