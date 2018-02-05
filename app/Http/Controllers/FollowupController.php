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
use Session;
use App\Lead;


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
        //access for user
        $User_Type=Session::get('userType');
        if($User_Type=='USER' || $User_Type=='MANAGER' ||$User_Type=='SUPERVISOR') {
            $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
            ->where('followUpDate', date('Y-m-d'))
            ->where('followup.userId',Auth::user()->id)->get();

            $callReports=Callingreport::get();
		 /// return $callReports;
            $possibilities=Possibility::get();
            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports, 'possibilities' => $possibilities]);}
        return Redirect()->route('home');

    }


    public function show(){

        $User_Type=Session::get('userType');
        if($User_Type=='USER' || $User_Type=='MANAGER' ||$User_Type=='SUPERVISOR') {
            $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
                ->where('followUpDate', date('Y-m-d'))
                ->where('followup.userId',Auth::user()->id)->get();

            $callReports=Callingreport::get();
            /// return $callReports;
            $possibilities=Possibility::get();
            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports, 'possibilities' => $possibilities]);}
        return Redirect()->route('home');

    }


    public function destroy($id){
        $lead=Lead::findOrFail($id);
        $lead->delete();
        Session::flash('message', 'Lead deleted successfully');
        return back();
    }



    public function search(Request $request) {

//        $followups = DB::table('followup')
//            ->leftJoin('leads', 'followup.leadId', '=', 'leads.leadId')
//            ->leftJoin('categories', 'categories.categoryId', '=', 'leads.categoryId')
//            ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
//            ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
//            ->leftJoin('users', 'users.id', '=', 'leads.minedBy')
//            ->where('followup.userId',Auth::user()->id)
//            ->whereBetween('followup.followUpDate', [$request->fromdate, $request->todate])
//            ->select('followup.*', 'users.*', 'leads.*', 'countries.*', 'categories.*')
//            ->get();


//        $followups= Followup::where('userId',Auth::user()->id)
//                ->whereBetween('followUpDate', [$request->fromdate, $request->todate])->get();

        $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
            ->whereBetween('followUpDate', [$request->fromdate, $request->todate])
            ->where('followup.userId',Auth::user()->id)->get();

        $callReports=Callingreport::get();
        /// return $callReports;
        $possibilities=Possibility::get();

        Session::flash('message', 'From '.$request->fromdate.' To '.$request->todate.'');

        return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports, 'possibilities' => $possibilities]);
    }
}
