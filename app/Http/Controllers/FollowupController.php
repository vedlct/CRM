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
use App\Leadstatus;
use App\Possibilitychange;
use Carbon\Carbon;
use Redirect;



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
                ->where('leads.contactedUserId',Auth::user()->id)
                ->where('followup.workStatus',0)
                ->get();





            $callReports=Callingreport::get();
            $categories=Category::where('type',1)->get();
            $possibilities=Possibility::get();
            $status=Leadstatus::where('statusId','!=',7)
                ->get();
            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
                'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status]);
        }
        return Redirect()->route('home');

    }

    public function followupCheck(Request $r){
        $followup=Followup::where('userId',Auth::user()->id)
            ->where('followUpDate',$r->currentdate)
            ->where('workStatus',0)->count();

        return $followup;
    }




    public function storeFollowupReport(Request $r){

        if($r->followup !=null) {

            $update = Followup::findOrFail($r->followId);
            $update->workStatus = 1;
            $update->save();

            $followUp=New Followup;
            $followUp->leadId=$r->leadId;
            $followUp->userId=Auth::user()->id;
            $followUp->followUpDate=$r->followup;
            $followUp->save();
        }

        //posssibility Change
        $lead=Lead::findOrFail($r->leadId);
        $currentPossibility=$lead->possibilityId;
        $lead->possibilityId=$r->possibility;
        $lead->save();

        if($r->report !=2){
            if($currentPossibility !=$r->possibility){
                $log=new Possibilitychange;
                $log->leadId=$r->leadId;
                $log->possibilityId=$r->possibility;
                $log->userId=Auth::user()->id;
                $log->save();
            }

        }


        $progress=New Workprogress;
        $progress->callingReport=$r->report;
        $progress->leadId=$r->leadId;
        $progress->progress=$r->progress;
        $progress->userId=Auth::user()->id;
        $progress->comments=$r->comment;
        $progress->save();

        Session::flash('message', 'Report Updated Successfully');




//        return redirect()->route('follow-up.index',['fromDate'=>$r->fromdate,'toDate'=> $r->todate]);
//        return redirect()->route('follow-up.search' , ['fromdate'=>'2018-02-12','todate'=>'2018-02-14']);
        if($r->fromDate!= null && $r->toDate){

            $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
                ->whereBetween('followUpDate', [$r->fromDate, $r->toDate])
                ->where('followup.userId',Auth::user()->id)
                ->where('followup.workStatus',0)
                ->get();



            $callReports=Callingreport::get();
            /// return $callReports;
            $categories=Category::where('type',1)->get();
            $possibilities=Possibility::get();
            $status=Leadstatus::where('statusId','!=',7)
                ->get();

            Session::flash('message', 'From '.$r->fromDate.' To '.$r->toDate.'');

            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
                'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status,'fromDate'=>$r->fromDate,'toDate'=> $r->toDate]);

        }
        else
            return back();

    }


//    public function search($fromdate,$todate) {
//
//
//       $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
//            ->whereBetween('followUpDate', [$fromdate, $todate])
//            ->where('followup.userId',Auth::user()->id)
//            ->where('followup.workStatus',0)
//            ->get();
//
//
//        $callReports=Callingreport::get();
//        /// return $callReports;
//        $categories=Category::where('type',1)->get();
//        $possibilities=Possibility::get();
//        $status=Leadstatus::where('statusId','!=',7)
//            ->get();
//
//        Session::flash('message', 'From '.$fromdate.' To '.$todate.'');
//
//        return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
//            'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status]);
//    }

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
        $status=Leadstatus::where('statusId','!=',7)
            ->get();

        Session::flash('message', 'From '.$request->fromdate.' To '.$request->todate.'');

        return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
            'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status,'fromDate'=>$request->fromdate,'toDate'=> $request->todate]);
    }

}
