<?php
namespace App\Http\Controllers;

use App\NewCall;
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
use App\Country;
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

            $date = Carbon::now()->format('Y-m-d');
            $lastDate=Carbon::now()->subDay(5)->format('Y-m-d');

            $leads=Lead::leftJoin('followup', 'leads.leadId', '=', 'followup.leadId')
                ->groupBy('leads.leadId')
                ->whereBetween('followUpDate', [$lastDate,$date])
                ->where('leads.contactedUserId',Auth::user()->id)
                ->where('followup.workStatus',0)
                ->orderBy('followup.followUpDate','desc')
                ->get();



            $country=Country::get();
            $callReports=Callingreport::get();
            $categories=Category::where('type',1)->get();
            $possibilities=Possibility::get();
            $status=Leadstatus::where('statusId','!=',7)
                ->get();
            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
                'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status,'country'=>$country]);
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


        $update = Followup::findOrFail($r->followId);
        $update->workStatus = 1;
        $update->save();
        DB::table('followup')
//            ->where('userId',Auth::user()->id)
            ->where('leadId',$update->leadId)
            ->update(['workStatus' => 1]);

        if($r->followup !=null) {

            $followUp=New Followup;
            $followUp->leadId=$r->leadId;
            $followUp->userId=Auth::user()->id;
            $followUp->time=$r->time;
            $followUp->followUpDate=$r->followup;
            $followUp->save();
        }



        //posssibility Change
        $lead=Lead::findOrFail($r->leadId);
        $currentPossibility=$lead->possibilityId;
        $lead->possibilityId=$r->possibility;
        $lead->save();

        if($r->report ==1 ||$r->report ==3||$r->report ==4||$r->report ==5){
//             if($currentPossibility !=$r->possibility){
            $chk=Possibilitychange::where('leadId',$lead->leadId)
                ->where('userId',Auth::user()->id)
                ->where('possibilityId',3)
                ->whereDate('created_at',strftime('%F'))->count();
            if($chk ==0)
            {
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

        if($r->report ==2 ||$r->report ==6 ){
            $countNewCall=Workprogress::where('userId',Auth::user()->id)
                ->where('leadId',$r->leadId)
                ->whereIn('callingReport',[2,6])
                ->count();
            if($countNewCall<3 ){
                $newCalll=new NewCall();
                $newCalll->leadId=$r->leadId;
                $newCalll->userId=Auth::user()->id;
                $newCalll->progressId=$progress->id;
                $newCalll->save();
            }

        }
        else{
            $countNewCallContact=Workprogress::where('userId',Auth::user()->id)
                ->where('leadId',$r->leadId)
                ->where('callingReport',5)
                ->count();

            if($countNewCallContact<2){
                $newCalll=new NewCall();
                $newCalll->leadId=$r->leadId;
                $newCalll->userId=Auth::user()->id;
                $newCalll->progressId=$progress->id;
                $newCalll->save();
            }

        }


        Session::flash('message', 'Report Updated Successfully');





        ////this is for back to search result///////////
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

            $country=Country::get();

            Session::flash('message', 'From '.$r->fromDate.' To '.$r->toDate.'');

            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
                'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status,'fromDate'=>$r->fromDate,'toDate'=> $r->toDate,'country'=>$country]);

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
        $country=Country::get();

        Session::flash('message', 'From '.$request->fromdate.' To '.$request->todate.'');

        return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
            'possibilities' => $possibilities,'categories'=>$categories,'status'=>$status,'fromDate'=>$request->fromdate,'toDate'=> $request->todate,'country'=>$country]);
    }

}