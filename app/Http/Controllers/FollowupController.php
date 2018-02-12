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
use App\Category;
use App\Workprogress;
use Carbon\Carbon;



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
//        $date = Carbon::now();
//
//
//
//        $leadid = array();
//        $workprogess= Workprogress::select('leadId')
//           // ->where('userId',Auth::user()->id)
//            ->get();
//        foreach ($workprogess as $workpr){
//            array_push($leadid , $workpr->leadId);
//        }
//
////        SELECT * FROM followup WHERE followup.leadId NOT IN (SELECT workprogress.leadId FROM workprogress) and followup.userId=2
//        $leads=Lead::select('leads.companyName')
//        ->leftJoin('followup','leads.leadId','followup.leadId')
//        ->leftJoin('workprogress','workprogress.leadId','followup.leadId')
//            ->whereNotIn('followup.leadId',$leadid)
//            ->whereBetween('followup.followUpDate',[$date->subDays(1)->format('Y-m-d'),$date->subDays(3)->format('Y-m-d')])
//
////          ->orderBy('workprogress.created_at','desc')
////            ->take(6)
//        ->where('followup.userId',Auth::user()->id)->get();
//
//
//        return $leads;

        //access for user
        $User_Type=Session::get('userType');
        if($User_Type=='USER' || $User_Type=='MANAGER' ||$User_Type=='SUPERVISOR') {
            $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
            ->where('followUpDate', date('Y-m-d'))
                ->where('leads.contactedUserId',Auth::user()->id)
                ->where('followup.workStatus',0)
                ->get();



            $callReports=Callingreport::get();
            $categories=Category::where('type',1)->get();
            $possibilities=Possibility::get();
            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports, 'possibilities' => $possibilities,'categories'=>$categories]);
        }
        return Redirect()->route('home');

    }

    public function followupCheck(Request $r){
        $followup=Followup::where('userId',Auth::user()->id)
                ->where('followUpDate',$r->currentdate)->count();


        return $followup;

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
            $categories=Category::where('type',1)->get();
            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports, 'possibilities' => $possibilities,'categories'=>$categories]);}
        return Redirect()->route('home');

    }


    public function destroy($id){
        $lead=Lead::findOrFail($id);
        $lead->delete();
        Session::flash('message', 'Lead deleted successfully');
        return back();
    }



    public function search(Request $request) {



        $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
            ->whereBetween('followUpDate', [$request->fromdate, $request->todate])
            ->where('followup.userId',Auth::user()->id)
            ->where('followup.workStatus',0)
            ->get();

        $callReports=Callingreport::get();
        /// return $callReports;
        $categories=Category::where('type',1)->get();
        $possibilities=Possibility::get();

        Session::flash('message', 'From '.$request->fromdate.' To '.$request->todate.'');

        return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports, 'possibilities' => $possibilities,'categories'=>$categories]);
    }
}
