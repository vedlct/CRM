<?php
namespace App\Http\Controllers;
use App\NewCall;
use App\NewFile;
use App\Probability;
use App\Status;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use phpDocumentor\Reflection\Types\Null_;
use Session;
use Psy\Exception\ErrorException;
use App\Category;
use App\Possibility;
use App\Country;
use App\Lead;
use App\User;
use App\Leadassigned;
use App\Possibilitychange;
use App\Callingreport;
use App\Workprogress;
use App\Activities;
use App\Followup;
use App\Leadstatus;
use App\SalesPipeline;
use DataTables;

use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SelectedAnalysisCommentsExport;
use App\Exports\LongTimeNoCallExport;
use App\Exports\fredChasingLeadsExport;

use Goutte\Client;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\Client as BrowserKitClient;
use Symfony\Component\DomCrawler\Crawler;

use Intervention\Image\Facades\Image;





class LeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allLeads(Request $r){
        $leads=Lead::with('country','category','mined','status','contact','possibility', 'probability')
            ->orderBy('leadId','desc');

        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                if($lead->leadAssignStatus == 0 && ($lead->statusId==2 ||  $lead->statusId==1) && Session::get('userType')!='RA'){
                //    if (empty($lead->mined->firstName )){
                //        $minedby = "";
                //    }else{
                //        $minedby =  $lead->mined->firstName;
                //    }

                    return ' <form method="post" action="'.route('addContacted').'">
                                        <input type="hidden" name="_token" id="csrf-token" value="'.csrf_token().'" />
                                        <input type="hidden" value="'.$lead->leadId.'" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                    <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"

                                           data-lead-category="'.$lead->category->categoryId.'"
                                            data-lead-country="'.$lead->countryId.'"
                                            data-lead-designation="'.$lead->designation.'"
                                            data-lead-linkedin="'.$lead->linkedin.'"
                                            data-lead-founded="'.$lead->founded.'"
                                            data-lead-process="'.$lead->process.'"
                                            data-lead-volume="'.$lead->volume.'"
                                            data-lead-frequency="'.$lead->frequency.'"
                                            data-lead-employee="'.$lead->employee.'"
                                            data-lead-ipp="'.$lead->ippStatus.'"
                                            data-lead-comments="'.$lead->comments.'"
                                            data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"><i class="fa fa-comments"></i></a>

                                            <a href="#lead_activities" data-toggle="modal" class="btn btn-warning btn-sm"
                                            data-lead-id="'.$lead->leadId.'"
                                            data-lead-name="'.$lead->companyName.'"><i class="fa fa-tasks"></i></a>
                                            </form>';
                }
                else{


                    if($lead->contactedUserId==Auth::user()->id){
                        return '<a href="#call_modal" data-toggle="modal" class="btn btn-success btn-sm"
                                   data-lead-id="'.$lead->leadId.'"
                                   data-lead-possibility="'.$lead->possibilityId.'"
                                   data-lead-probability="'.$lead->probabilityId.'">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                            <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"

                                           data-lead-category="'.$lead->category->categoryId.'"
                                            data-lead-country="'.$lead->countryId.'"
                                            data-lead-designation="'.$lead->designation.'"
                                            data-lead-linkedin="'.$lead->linkedin.'"
                                            data-lead-founded="'.$lead->founded.'"
                                            data-lead-process="'.$lead->process.'"
                                            data-lead-volume="'.$lead->volume.'"
                                            data-lead-frequency="'.$lead->frequency.'"
                                            data-lead-employee="'.$lead->employee.'"
                                            data-lead-ipp="'.$lead->ippStatus.'"
                                            data-lead-comments="'.$lead->comments.'"
                                            data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"><i class="fa fa-comments"></i></a>

                                                <a href="#lead_activities" data-toggle="modal" class="btn btn-warning btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"><i class="fa fa-tasks"></i></a>';

                    }
                    else{

                        return '<a href="#" class="btn btn-danger btn-sm" >
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                            <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"

                                           data-lead-category="'.$lead->category->categoryId.'"
                                           data-lead-country="'.$lead->countryId.'"
                                           data-lead-designation="'.$lead->designation.'"
                                           data-lead-linkedin="'.$lead->linkedin.'"
                                           data-lead-founded="'.$lead->founded.'"
                                           data-lead-process="'.$lead->process.'"
                                           data-lead-volume="'.$lead->volume.'"
                                           data-lead-frequency="'.$lead->frequency.'"
                                           data-lead-employee="'.$lead->employee.'"
                                           data-lead-ipp="'.$lead->ippStatus.'"
                                           data-lead-comments="'.$lead->comments.'"
                                           data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"

                                         ><i class="fa fa-comments"></i></a>
                                            <a href="#lead_activities" data-toggle="modal" class="btn btn-warning btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"

                                         ><i class="fa fa-tasks"></i></a>

                                            <a href="." class="btn btn btn-primary btn-sm lead-view-btn"
                                                data-lead-id="'.$lead->leadId.'"
                                         ><i class="fa fa-eye"></i></a>';
                    }}
            })
            ->make(true);
    }
    public function add(){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }

        $cats=Category::where('type', 1)->get();
        $countries=Country::get();
        $possibilities=Possibility::get();
        $probabilities=Probability::get();
        $callReports = Callingreport::get();
        $user = User::get()->where('crmType', '!=', 'local')->where('active', '1');
        return view('layouts.lead.add')
            ->with('categories',$cats)
            ->with('countries',$countries)
            ->with('possibilities',$possibilities)
            ->with('probabilities',$probabilities)
            ->with('callReports',$callReports)
            ->with('user',$user);
    }

    public function addNightShift(){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }

        $cats=Category::where('type', 1)->get();
        $countries=Country::get();
        $possibilities=Possibility::get();
        $callReports = Callingreport::get();
        $user = User::get()->where('crmType', '!=', 'local')->where('active', '1');

        return view('layouts.lead.addNightShift')
            ->with('categories',$cats)
            ->with('countries',$countries)
            ->with('possibilities',$possibilities)
            ->with('callReports',$callReports)
            ->with('user',$user);
    }

    public function showRelease(){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }

        $cats=Category::where('type', 1)->get();
        $countries=Country::get();
        $possibilities=Possibility::get();
        $probabilities=Probability::get();
        $callReports = Callingreport::get();
        $user = User::get()->where('crmType', '!=', 'local')->where('active', '1');

        return view('layouts.lead.release')
            ->with('categories',$cats)
            ->with('countries',$countries)
            ->with('possibilities',$possibilities)
            ->with('probabilities',$probabilities)
            ->with('callReports',$callReports)
            ->with('user',$user);
    }
    public function getallrelease(Request $r){

        $leads=Lead::with('country','category','mined','status','contact','possibility', 'probability', 'release')
            ->where('releaselead', '!=' ,"")
            ->orderBy('leadId','desc');
        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                if($lead->leadAssignStatus == 0 && ($lead->statusId==2 ||  $lead->statusId==1) && Session::get('userType')!='RA'){
                    return ' <form method="post" action="'.route('addContacted').'">
                                        <input type="hidden" name="_token" id="csrf-token" value="'.csrf_token().'" />
                                        <input type="hidden" value="'.$lead->leadId.'" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                    <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                            data-lead-country="'.$lead->countryId.'"
                                            data-lead-designation="'.$lead->designation.'"
                                            data-lead-comments="'.$lead->comments.'"
                                            data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"

                                            ><i class="fa fa-comments"></i></a></form>';
                }
                else{
                    if($lead->contactedUserId==Auth::user()->id){
                        return '<a href="#call_modal" data-toggle="modal" class="btn btn-success btn-sm"
                                   data-lead-id="'.$lead->leadId.'"
                                   data-lead-possibility="'.$lead->possibilityId.'"
                                   data-lead-probability="'.$lead->probabilityId.'">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                            <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                            data-lead-country="'.$lead->countryId.'"
                                            data-lead-designation="'.$lead->designation.'"
                                            data-lead-comments="'.$lead->comments.'"
                                            data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"

                                            ><i class="fa fa-comments"></i></a>';

                    }
                    else{
                        return '<a href="#" class="btn btn-danger btn-sm" >
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                            <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                           data-lead-country="'.$lead->countryId.'"
                                           data-lead-designation="'.$lead->designation.'"
                                           data-lead-comments="'.$lead->comments.'"
                                           data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"

                                         ><i class="fa fa-comments"></i></a>';
                    }}
            })
            ->make(true);

    }

    public function numberCheck(Request $r){
        $number=Lead::where('contactNumber',$r->number)->count();
        return Response($number);
    }
    public function websiteCheck(Request $r){
        $website=Lead::where('website',$r->website)->count();
        return Response($website);
    }
    public function comapanyNameCheck(Request $r){
        $comapanyname=Lead::where('companyName',$r->companyName)->count();
        return Response($comapanyname);
    }

    public function store(Request $r){
        //Validating The input Filed
        $this->validate($r,[
            'companyName' => 'required|max:100',
            'website' => 'required|max:100',
            'email' => 'max:100',
            'personName' => 'max:100',
            'personNumber' => 'required|max:25|unique:leads,contactNumber|regex:/^[\0-9\-\(\)\s]*$/',
            'designation'=>'max:100'
        ]);
        //Inserting Data To Leads TAble


        // if(isset($r->user)){
        //     $userId = $r->user;
        // }else{
        //     $userId = Auth::user()->id;
        // }

        $l=new Lead;

        $l->possibilityId=$r->possibility;
        $l->probabilityId=$r->probability;
        $l->categoryId = $r->category;
        $l->companyName = $r->companyName;
        $l->personName= $r->personName;
        $l->designation=$r->designation;
        $l->website = $r->website;
        $l->email= $r->email;
        $l->contactNumber = $r->personNumber;
        $l->countryId = $r->country;
        $l->linkedin=$r->linkedin;
        $l->founded=$r->founded;
        $l->employee=$r->employee;
        $l->volume=$r->volume;
        $l->frequency=$r->frequency;
        $l->process=$r->process;
        $l->comments = $r->comment;
        $l->ippStatus = 0;
        //getting Loggedin User id
        // $l->statusId = 1;
        $l->minedBy = Auth::user()->id;
        $l->save();

       // if($r->contact){
            $l->statusId = 7;
            $l->contactedUserId=Auth::user()->id;

            $pChange=new Possibilitychange;
            $pChange->leadId=$l->leadId;
            $pChange->userId=Auth::user()->id;
            $pChange->possibilityId= $l->possibilityId;
        //}

        //Save an activity
        $activity=new Activities;
        $activity->leadId=$l->leadId;
        $activity->userId=Auth::user()->id;
        $activity->activity=Auth::user()->userId . ' mined a lead - ' . $l->companyName;
        $activity->save();               

        $l->save();
        $pChange->save();

        //for Flash Meassage
        Session::flash('message', 'Lead Added successfully');
        return back();
    }



    public function storeLeadAdmin(Request $r){

        //Validating The input Filed
        $this->validate($r,[
            'companyName' => 'required|max:100',
            'website' => 'max:100',
            'email' => 'required|max:100',
            'personName' => 'max:100',
            'personNumber' => 'required|max:25|unique:leads,contactNumber|regex:/^[\0-9\-\(\)\s]*$/',
            'designation'=>'max:100'
        ]);
        //Inserting Data To Leads TAble
        $l=new Lead;
//        if($r->contact){
//            $l->statusId = 7;
//            $l->contactedUserId=Auth::user()->id;
//        }
//        else{

        if(isset($r->user)){
            $userId = $r->user;
        }else{
            $userId = Auth::user()->id;
        }

        $l->statusId = 6;
//        }
        $l->possibilityId=$r->possibility;
        $l->probabilityId=$r->probability;
        $l->categoryId = $r->category;
        $l->companyName = $r->companyName;
        $l->personName= $r->personName;
        $l->designation=$r->designation;
        $l->website = $r->website;
        $l->email= $r->email;
        $l->contactNumber = $r->personNumber;
        $l->countryId = $r->country;
        $l->comments=$r->comment;
        $l->ippStatus=0;
        //getting Loggedin User id
        $l->minedBy = $userId;
        $l->save();
        //for Flash Meassage
        Session::flash('message', 'Lead Added successfully');
        return back();
    }


    public function assignShow(){
        $User_Type=Session::get('userType');
        if($User_Type == 'RA' || $User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR'){
            //getting only first name of users
            if($User_Type == 'RA' || $User_Type == 'SUPERVISOR'){
                $users=User::select('id','firstName','lastName')
                    ->where('id','!=',Auth::user()->id)
                    ->where('typeId',5)
                    ->orWhere('typeId',2)
                    ->orWhere('typeId',3)
                    ->get();
            }
            else{
                $users=User::select('id','firstName','lastName')
                    ->where('teamId',Auth::user()->teamId)
                    ->where('teamId','!=',null)
                    ->get();
            }
            return view('layouts.lead.assignLead')
                ->with('users',$users);}
        return Redirect()->route('home');
    }


    public function assignAllShow(){
        $User_Type=Session::get('userType');
        if($User_Type == 'RA' || $User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN' ){
            //getting only first name of users
            if($User_Type == 'RA' || $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN' || $User_Type == 'MANAGER'){
                $users=User::select('id','firstName','lastName')
                    ->where('id','!=',Auth::user()->id)
                    ->where('typeId',5)
                    ->orWhere('typeId',2)
                    ->orWhere('typeId',3)
                    ->get();
            }
            else{
                $users=User::select('id','firstName','lastName')
                    ->where('teamId',Auth::user()->teamId)
                    ->where('teamId','!=',null)
                    ->get();
            }

            $cats=Category::where('type', 1)->get();
            $countries=Country::get();
            $possibilities=Possibility::get();
            $probabilities=Probability::get();
            $callReports = Callingreport::get();
            return view('layouts.lead.assignAllLead',compact('cats','countries','possibilities','probabilities','callReports','User_Type'))
                ->with('users',$users);}
            return Redirect()->route('home');
    }


    public function getAssignLeadData(){
        $leads=(new Lead())->showNotAssignedLeads();
        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="'.$lead->leadId.'">';
            })
            ->make(true);

    }

    public function getAllAssignLeadData(Request $r){


        if($r->userId!=null){



        $leads=Lead::with('mined','category','country','possibility','probability','status','contact')
            ->where('contactedUserId',$r->userId)
            ->where('statusId','!=',6)
            ->orderBy('leadId','desc');


        }else{

            $leads=Lead::with('mined','category','country','possibility', 'probability','status','contact')
               // ->where('leadAssignStatus','!=',1)
                ->where('statusId','!=',6)
              //  ->where('statusId','!=',4)
             //   ->where('statusId','!=',5);
                 ->orderBy('leadId','desc');


        }



        // $leads=(new Lead())->showNotAssignedAllLeads()->where('contactedUserId',$r->userId);
        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) {
                return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="'.$lead->leadId.'">';
            })->addColumn('check', function ($lead) {
                $User_Type=Session::get('userType');
                if(  $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN' ) {
                    if ($lead->leadAssignStatus == 0 && ($lead->statusId == 2 || $lead->statusId == 1) && Session::get('userType') != 'RA') {
                        return ' <form method="post" action="' . route('addContacted') . '">
                                        <input type="hidden" name="_token" id="csrf-token" value="' . csrf_token() . '" />
                                        <input type="hidden" value="' . $lead->leadId . '" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                    <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="' . $lead->leadId . '"
                                           data-lead-name="' . $lead->companyName . '"
                                           data-lead-email="' . $lead->email . '"
                                           data-lead-number="' . $lead->contactNumber . '"
                                           data-lead-person="' . $lead->personName . '"
                                           data-lead-website="' . $lead->website . '"
                                           data-lead-mined="' . $lead->mined->firstName . '"
                                           data-lead-category="' . $lead->category->categoryId . '"
                                            data-lead-country="' . $lead->countryId . '"
                                            data-lead-designation="' . $lead->designation . '"
                                            data-lead-linkedin="' . $lead->linkedin . '"
                                            data-lead-founded="' . $lead->founded . '"
                                            data-lead-employee="' . $lead->employee . '"
                                            data-lead-volume="' . $lead->volume . '"
                                            data-lead-frequency="' . $lead->frequency . '"
                                            data-lead-process="' . $lead->process . '"
                                            data-lead-ipp="'.$lead->ippStatus.'"
                                            data-lead-comments="' . $lead->comments . '"
                                            data-lead-created="' . Carbon::parse($lead->created_at)->format('Y-m-d') . '"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="' . $lead->leadId . '"
                                                data-lead-name="' . $lead->companyName . '"

                                            ><i class="fa fa-comments"></i></a></form>';
                    } else {
                        if ($lead->contactedUserId == Auth::user()->id) {
                            return '<a href="#call_modal" data-toggle="modal" class="btn btn-success btn-sm"
                                   data-lead-id="' . $lead->leadId . '"
                                   data-lead-possibility="' . $lead->possibilityId . '"
                                   data-lead-probability="' . $lead->probabilityId . '">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                            <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="' . $lead->leadId . '"
                                           data-lead-name="' . $lead->companyName . '"
                                           data-lead-email="' . $lead->email . '"
                                           data-lead-number="' . $lead->contactNumber . '"
                                           data-lead-person="' . $lead->personName . '"
                                           data-lead-website="' . $lead->website . '"
                                           data-lead-mined="' . $lead->mined->firstName . '"
                                           data-lead-category="' . $lead->category->categoryId . '"
                                            data-lead-country="' . $lead->countryId . '"
                                            data-lead-designation="' . $lead->designation . '"
                                            data-lead-linkedin="' . $lead->linkedin . '"
                                            data-lead-founded="' . $lead->founded . '"
                                            data-lead-employee="' . $lead->employee . '"
                                            data-lead-volume="' . $lead->volume . '"
                                            data-lead-frequency="' . $lead->frequency . '"
                                            data-lead-process="' . $lead->process . '"
                                            data-lead-ipp="'.$lead->ippStatus.'"
                                            data-lead-comments="' . $lead->comments . '"
                                            data-lead-created="' . Carbon::parse($lead->created_at)->format('Y-m-d') . '"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="' . $lead->leadId . '"
                                                data-lead-name="' . $lead->companyName . '"

                                            ><i class="fa fa-comments"></i></a>';

                        } else {
                            return '<a href="#" class="btn btn-danger btn-sm" >
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>

                            <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="' . $lead->leadId . '"
                                           data-lead-name="' . $lead->companyName . '"
                                           data-lead-email="' . $lead->email . '"
                                           data-lead-number="' . $lead->contactNumber . '"
                                           data-lead-person="' . $lead->personName . '"
                                           data-lead-website="' . $lead->website . '"
                                           data-lead-mined="' . $lead->mined->firstName . '"
                                           data-lead-category="' . $lead->category->categoryId . '"
                                           data-lead-country="' . $lead->countryId . '"
                                           data-lead-designation="' . $lead->designation . '"
                                           data-lead-linkedin="' . $lead->linkedin . '"
                                           data-lead-founded="' . $lead->founded . '"
                                           data-lead-employee="' . $lead->employee . '"
                                           data-lead-volume="' . $lead->volume . '"
                                           data-lead-frequency="' . $lead->frequency . '"
                                           data-lead-process="' . $lead->process . '"
                                           data-lead-ipp="'.$lead->ippStatus.'"
                                           data-lead-comments="' . $lead->comments . '"
                                           data-lead-created="' . Carbon::parse($lead->created_at)->format('Y-m-d') . '"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="' . $lead->leadId . '"
                                                data-lead-name="' . $lead->companyName . '"

                                         ><i class="fa fa-comments"></i></a>';
                        }
                    }
                }})

            ->rawColumns(['action','check'])
            ->make(true);
    }



    public function assignStore(Request $r){             
        if($r->ajax()){
            foreach ($r->leadId as $lead){


                $assignId=Leadassigned::select('assignId')
                ->where('leadId',$lead)
                ->where('leaveDate',null)
                ->get();

                    foreach ($assignId as $assignId){

                        $leave=Leadassigned::find($assignId->assignId);
                        $leave->workStatus='1';
                        $leave->leaveDate=date('Y-m-d');
                        $leave->save();
                    }


                $l=Lead::findOrFail($lead);
                $l->leadAssignStatus=1;
                $l->statusId=2;
                $l->contactedUserId=null;
                $l->ippStatus=0;
                $l->save();
                $leadAssigned=new Leadassigned;
                $leadAssigned->assignBy=Auth::user()->id;
                $leadAssigned->assignTo=$r->userId;
                $leadAssigned->leadId=$lead;
                $leadAssigned->save();

                $userName=User::select('userId')->where('id',$r->userId)->first()->userId;

                $activity=new Activities;
                $activity->leadId=$lead;
                $activity->userId=Auth::user()->id;
                $activity->activity=Auth::user()->userId .' '. 'assigned this lead to' .' '. $userName; //$this->returnUserName($r->userId); 
                $activity->save();               


                $pipeline = SalesPipeline::whereIn('leadId', $r->leadId)->get();

                if ($pipeline->isNotEmpty()) {
                    SalesPipeline::whereIn('leadId', $r->leadId)
                        ->update(['workStatus' => 0]);
                }


            }
            return Response('true');
            // return Response($r->leadId);
        }
    }



    public function assignStore2(Request $r){
        if($r->ajax()){
            
            foreach ($r->leadId as $lead){

                $l=Lead::findOrFail($lead);
                $l->leadAssignStatus=1;
                $l->statusId=2;
                $l->contactedUserId=null;
                $l->ippStatus=0;
                $l->save();

                Leadassigned::where('leadId', '=', $lead)->where('assignTo',Auth::user()->id)
                ->update(['assignTo' => $r->userId,'assignBy'=>Auth::user()->id]);

                $userName=User::select('userId')->where('id',$r->userId)->first()->userId;

                $activity=new Activities;
                $activity->leadId=$lead;
                $activity->userId=Auth::user()->id;
                $activity->activity=Auth::user()->userId .' '. 'assigned this lead to' .' '. $userName; //$this->returnUserName($r->userId); 
                $activity->save();


                $pipeline = SalesPipeline::whereIn('leadId', $r->leadId)->get();

                if ($pipeline->isNotEmpty()) {
                    SalesPipeline::whereIn('leadId', $r->leadId)
                        ->update(['workStatus' => 0]);
                }


            }
            return Response('true');
            // return Response($r->leadId);
        }
    }

  



    public function update(Request $r){


        $this->validate($r,[
            'companyName' => 'max:100',
            'website' => 'max:100',
            'email' => 'max:100',
            'personName' => 'max:100',
            'number' => 'required|max:15|regex:/^[\+0-9\-\(\)\s]*$/',


        ]);

        if(isset($r->user)){
            $userId = $r->user;
        }else{
            $userId = Auth::user()->id;
        }

        $lead=Lead::findOrFail($r->leadId);
        $lead->companyName=$r->companyName;
        $lead->email=$r->email;
        $lead->categoryId=$r->category;
        $lead->personName=$r->personName;
        $lead->contactNumber=$r->number;
        $lead->website=$r->website;
        $lead->linkedin=$r->linkedin;

        if($r->country){
            $lead->countryId=$r->country;
        }
        if($r->designation){
            $lead->designation=$r->designation;
        }
        if(!empty($r->comments)){
            $lead->comments=$r->comments;
        }

        $lead->founded=$r->founded;
        $lead->employee=$r->employee;
        $lead->volume=$r->volume;
        $lead->frequency=$r->frequency;
        $lead->process=$r->process;
        $lead->ippStatus=$r->ippStatus;

        if($r->status==5){
//         For Report
            $activity=new Activities;
            $activity->leadId=$lead->leadId;
            $activity->userId=$userId;
            $activity->activity=Auth::user()->userId .' '. 'Rejected this lead';
            $activity->save();

            $lead->statusId=5;
            $lead->contactedUserId=null;
            $lead->leadAssignStatus=0;
        }

        elseif($r->status==6){
            $activity=new Activities;
            $activity->leadId=$lead->leadId;
            $activity->userId=Auth::user()->id;
            $activity->activity=Auth::user()->userId .' '. 'marked it as CLIENT';
            $activity->save();

            $lead->statusId=$r->status;
            $lead->contactedUserId=null;
            $lead->leadAssignStatus=0;
        }

        elseif($r->status==8){
            $activity=new Activities;
            $activity->leadId=$lead->leadId;
            $activity->userId=Auth::user()->id;
            $activity->activity=Auth::user()->userId .' '. 'marked it as Duplicate Lead';
            $activity->save();

            $lead->statusId=$r->status;
            $lead->contactedUserId=null;
            $lead->leadAssignStatus=0;
        }

        else {
            $activity=new Activities;
            $activity->leadId=$lead->leadId;
            $activity->userId=Auth::user()->id;
            $activity->activity=Auth::user()->userId .' '. ' updated this lead';
            $activity->save();

        }

        $lead->save();
       // Session::forget(['callreportsession']);
        //Session::flash('message', 'Lead Edited successfully');

        //return back();

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
            $probabilities=Probability::get();
            $status=Leadstatus::where('statusId','!=',7)
                ->get();

            $country=Country::get();

            Session::flash('message', 'From '.$r->fromDate.' To '.$r->toDate.'');

            return view('follow-up/index', ['leads' => $leads, 'callReports' => $callReports,
                'possibilities' => $possibilities,  'probabilities' => $probabilities,'categories'=>$categories,'status'=>$status,'fromDate'=>$r->fromDate,'toDate'=> $r->toDate,'country'=>$country]);

        }
        else
            return back();
    }


    public function filter(){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }

        $categories=Category::where('type',1)
            ->get();
        $country=Country::get();

        return view('layouts.lead.filterLead')
            ->with('categories',$categories)
            ->with('country',$country);
    }

    

    public function contactedStatus(Request $r){

        if($r->ajax()){
            foreach ($r->leadId as $lead){



                $l=Lead::findOrFail($lead);
                $l->statusId=$r->status;
                if($l->contactedUserId == Auth::user()->id){
                    $l->contactedUserId =null;
                    //$lead->save();
                }

                if($l->ippStatus == 1){
                    $l->ippStatus = 0;
                    //$lead->save();
                }

                    $activity=new Activities;
                    $activity->leadId=$l->leadId;
                    $activity->userId=Auth::user()->id;

                    if($l->statusId==2){           
                        $activity->activity=Auth::user()->userId .' '. 'Filtered this lead (from Table)';
                    }
                    if($l->statusId==3){
                        $activity->activity=Auth::user()->userId .' '. 'marked this lead as Not Interested and left (from Table)';
                    }
                    if($l->statusId==4){
                        $activity->activity=Auth::user()->userId .' '. 'left this lead as Bad Lead (from Table)';
                    }
                    if($l->statusId==5){
                        $activity->activity=Auth::user()->userId .' '. 'Rejected this lead (from Table)';
                    }    
                    if($l->statusId==6){
                        $activity->activity=Auth::user()->userId .' '. 'marked it as Client and left the lead (from Table)';
                    }    
                    if($l->statusId==8){
                        $activity->activity=Auth::user()->userId .' '. 'marked it as Duplicate lead (from Table)';
                    }    


                    $activity->save();
                $l->save();

                
                $assignId=Leadassigned::select('assignId')
                    ->where('leadId',$lead)
                    ->where('assignTo',Auth::user()->id)
                    ->where('leaveDate',null)
                    ->get();


                foreach ($assignId as $assignId){

                    $leave=Leadassigned::find($assignId->assignId);
                    $leave->leaveDate=date('Y-m-d');
                    $leave->save();
                    $l=Lead::findOrFail($leave->leadId);
                    $l->leadAssignStatus=0;
                    $l->save();
                }


                $pipeline = SalesPipeline::whereIn('leadId', $r->leadId)->get();

                if ($pipeline->isNotEmpty()) {
                    SalesPipeline::whereIn('leadId', $r->leadId)
                        ->update(['workStatus' => 0]);
                }
            }

            return Response('true');
        }
    }




    public function getFilterLeads(Request $request){

        $leads=(new Lead())->showNotAssignedLeads();
        return DataTables::eloquent($leads)
            ->addColumn('check', function ($lead) {
                return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="'.$lead->leadId.'">';
            })->addColumn('action', function ($lead) {
                if(Session::get('userType')=='RA'){
                    return '<a href="#my_modal" data-toggle="modal"   class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                           data-lead-country="'.$lead->countryId.'"
                                           data-lead-designation="'.$lead->designation.'"
                                           data-lead-comments="'.$lead->comments.'"
                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                 <form method="post" action="'.route('rejectStore').'">
                                        <input type="hidden" name="_token" id="csrf-token" value="'.csrf_token().'" />
                                        <input type="hidden" value="'.$lead->leadId.'" name="leadId">
                                    <button class="btn btn-danger btn-sm">X</button></form>
                                    ';
                }
                else{
                    return '<form method="post" action="'.route('addContacted').'">
                                        <input type="hidden" name="_token" id="csrf-token" value="'.csrf_token().'" />
                                        <input type="hidden" value="'.$lead->leadId.'" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                        
                                            <a href="#lead_comments" data-toggle="modal" class="btn btn-info btn-sm"
                                                data-lead-id="'.$lead->leadId.'"
                                                data-lead-name="'.$lead->companyName.'"

                                            ><i class="fa fa-comments"></i></a>
                                    </form>


                                    ';}})
            ->rawColumns(['action','check'])
            ->make(true);
    }


    public function assignedLeads(){
        //will return the leads assigned to you
        //for user
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR') {
            $leads = (new Lead())->myLeads2()->where('contactedUserId',null);
            $callReports = Callingreport::get();
            $possibilities = Possibility::get();
            $probabilities = Probability::get();
            $categories=Category::where('type',1)->get();
            $status=Leadstatus::where('statusId','!=',7)
                ->where('statusId','!=',1)
                ->get();

                $users=User::select('id','firstName','lastName')
                // ->orderBy('userId','DESC')
                ->where('id','!=',Auth::user()->id)
                ->orwhere('typeId',5)
                ->orWhere('typeId',2)
                ->orWhere('typeId',3)
                ->get();

                $outstatus=Leadstatus::where('statusId','!=',7)
                ->where('statusId','!=',1)
                ->where('statusId','!=',6)
                ->get();

            $country=Country::get();
            return view('layouts.lead.myAssignedLead')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories',$categories)
                ->with('country',$country)
                ->with('status',$status)
                ->with('users',$users)
                ->with('outstatus',$outstatus);
        }
        return Redirect()->route('home');}



    public function getComments(Request $r){

        $dt = Carbon::now();

        if($r->ajax()){
            $comments=Workprogress::select(['users.firstName','callingreports.report','comments','workprogress.created_at'])
                ->where('workprogress.leadId',$r->leadId)
                ->leftJoin('users','users.id','workprogress.userId')
                ->leftJoin('callingreports','callingreports.callingReportId','workprogress.callingReport')
                ->get();

            $counter = Workprogress::select('users.userId as userId', DB::raw('count(*) as userCounter'))
                ->join('users', 'workprogress.userId', 'users.id')
                ->where('leadId', $r->leadId)
                ->groupBy('workprogress.userId')
                ->get();
                
            $previousFollowups = Followup::select('followup.*', 'users.firstName', 'users.lastName')
                ->leftjoin ('users', 'followup.userID', 'users.id')
                ->where('leadId', $r->leadId)
                ->orderBy ('followUpDate', 'asc')
                ->get();


            $latestFollowups = Followup::select('leadId', DB::raw('MAX(followUpDate) as lastFollowUpDate'))
                ->where('leadId', $r->leadId)    
                ->groupBy('leadId')
                ->get();                


            $text='';

            foreach ($comments as $comment){
                $text.='<li class="list-group-item list-group-item-action"><b>'.$comment->comments.'</b> <div style="color:blue;">-<span style="color: green">('.$comment->report.')</span>-By '.$comment->firstName.' ('.$comment->created_at.')</div>'.'</li>';
            }

            $followupText='';

            foreach ($previousFollowups as $previousFollowup){
                $workStatus = ($previousFollowup->workStatus == 1) ? 'Worked' : 'Not Worked';

                    $followupText .= '<li class="list-group-item list-group-item-action">'.$previousFollowup->followUpDate.' <span style="color: blue"> ('.$workStatus.')</span> <div style="color:black;">by '.$previousFollowup->firstName. ' ' .$previousFollowup->lastName.' set at '. $dt->toDateString($previousFollowup->created_at).'</div>'.'</li>';
            }

            return response()->json([
                'comments' => $text,
                'counter' => $counter,
                'previousFollowups' => $followupText,
                'latestFollowups' => $latestFollowups
            ]);
        }
    }


    public function getLatestFollowup(Request $r){

        if($r->ajax()){

            $latestFollowups = Followup::select('leadId', DB::raw('MAX(followUpDate) as lastFollowUpDate'))
                ->where('leadId', $r->leadId)    
                ->groupBy('leadId')
                ->get();                


            return response()->json([
                'latestFollowups' => $latestFollowups
            ]);
        }
    }


    
    public function getFollowupsCounter (Request $r){

        if($r->ajax()){

            $counter = Workprogress::select('users.userId as userId', DB::raw('count(*) as userCounter'))
                ->join('users', 'workprogress.userId', 'users.id')
                ->where('leadId', $r->leadId)
                ->groupBy('workprogress.userId')
                ->get();
                
            $previousFollowups = Followup::select('followup.*', 'users.firstName', 'users.lastName')
                ->leftjoin ('users', 'followup.userID', 'users.id')
                ->where('leadId', $r->leadId)
                ->orderBy ('followUpDate', 'asc')
                ->get();
                
            $followupText='';

            foreach ($previousFollowups as $previousFollowup){
                $workStatus = ($previousFollowup->workStatus == 1) ? 'Worked' : 'Not Worked';

                $followupText .= '<li class="list-group-item list-group-item-action">'.$previousFollowup->followUpDate.' <span style="color: blue"> ('.$workStatus.')</span> <div style="color:black;">by '.$previousFollowup->firstName. ' ' .$previousFollowup->lastName.' set at '. $previousFollowup->created_at.'</div>'.'</li>';
            }

            return response()->json([
                'counter' => $counter,
                'previousFollowups' => $followupText
            ]);
        }
    }


    public function getActivities(Request $r){
        if($r->ajax()){
            $activities=Activities::select(['users.firstName','activity','activities.created_at'])
                ->where('activities.leadId',$r->leadId)
                ->leftJoin('users','users.id','activities.userId')
                ->get();

            $text='';

            foreach ($activities as $activity){
                $text.='<li class="list-group-item list-group-item-action"><b>'.$activity->activity.'</b> <div style="color:blue;">-By '.$activity->firstName.' ('.$activity->created_at.')</div>'.'</li>';
            }
            return Response($text);
        }
    }




    public function getCallingReport(Request $r){
        if($r->ajax()){

            $workprocess = Workprogress::where('callingReport' , '11')
                ->where('userId',Auth::user()->id )
                ->where('leadId',$r->leadId )
                ->get();
            $text='';
            $callReports = Callingreport::get();
            if ($workprocess->isEmpty()){



                echo "<option value=''><b>(select one)</b></option>";

                foreach ($callReports as $clR){


                    echo  "<option value=".$clR->callingReportId.">".$clR->report."</option>";






                }

            }else{
                echo "<option value=''><b>(select one)</b></option>";
                foreach ($callReports as $clR){

                    if ($clR->callingReportId !=11){

                        echo  "<option value=".$clR->callingReportId.">".$clR->report."</option>";
                    }


                }
            }

            //  return Response($text);
        }
    }
    public function tempLeads(){
        //For Ra
        $User_Type=Session::get('userType');
        if($User_Type=='RA' ||$User_Type=='USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR' || $User_Type=='ADMIN'){
            $categories=Category::where('type',1)->get();
            $countries=Country::get();
            return view('layouts.lead.temp')
                ->with('categories',$categories)
                ->with('countries',$countries);}
        return Redirect()->route('home');
    }
    public function tempData(Request $request){

        $possibility=Possibility::get();
        $pBefore='<select class="form-control" id="drop" ';
        $pAfter=' name="possibility" ><option value="">Select</option>';
        foreach ($possibility as $pos){
            $pAfter.='<option value="'.$pos->possibilityId.'">'.$pos->possibilityName.'</option>';
        }
        $pAfter.='</select>';
        $leads=(new Lead())->getTempLead();
        return DataTables::eloquent($leads)
            ->addColumn('action', function ($lead) use ($pAfter,$pBefore){
                return $pBefore.'data-lead-id="'.$lead->leadId.'"'.$pAfter;
            })
            ->addColumn('edit', function ($lead) use ($pAfter,$pBefore){
                return '<form method="post" action="'.route('addContactedTemp').'">
                                        <input type="hidden" name="_token" id="csrf-token" value="'.csrf_token().'" />
                                        <input type="hidden" value="'.$lead->leadId.'" name="leadId">
                                        <button class="btn btn-info btn-sm"><i class="fa fa-bookmark" aria-hidden="true"></i></button>
                                        <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                           data-lead-id="'.$lead->leadId.'"
                                           data-lead-name="'.$lead->companyName.'"
                                           data-lead-email="'.$lead->email.'"
                                           data-lead-number="'.$lead->contactNumber.'"
                                           data-lead-person="'.$lead->personName.'"
                                           data-lead-website="'.$lead->website.'"
                                           data-lead-mined="'.$lead->mined->firstName.'"
                                           data-lead-category="'.$lead->category->categoryId.'"
                                           data-lead-country="'.$lead->countryId.'"
                                           data-lead-designation="'.$lead->designation.'"
                                           data-lead-comments="'.$lead->comments.'"

                                           >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    </form>';
            })
            ->rawColumns(['edit', 'action'])
            ->make(true);
    }
    public function changePossibility(Request $r){
        if($r->ajax()){
            $lead=Lead::findOrFail($r->leadId);
            $lead->possibilityId=$r->possibility;
            $lead->filteredPossibility=$r->possibility;
            $lead->statusId=2;
            $lead->save();

            return Response('true');
        }
    }
    public function storeReport(Request $r){
        $this->validate($r,[
            'leadId'=>'required',
            'report' => 'required',
            'comment' => 'required',
        ]);



        $workStatus=Leadassigned::where('leadId',$r->leadId)
            ->where('assignTo',Auth::user()->id)
            ->where('workStatus',0)
            ->first();

        if($workStatus != null){
            $leadAssigned=Leadassigned::findOrFail($workStatus->assignId);
            $leadAssigned->workStatus=1;
            $leadAssigned->save();
        }
        if($r->followup !=null){
            $followUp=New Followup;
            $followUp->leadId=$r->leadId;
            $followUp->userId=Auth::user()->id;
            $followUp->time=$r->time;
            $followUp->followUpDate=$r->followup;
            $followUp->save();
        }
        //posssibility Change
        $lead=Lead::findOrFail($r->leadId);
        $leadPrevStatus= $lead->statusId;
        $currentPossibility=$lead->possibilityId;
        $lead->possibilityId=$r->possibility;
        $lead->probabilityId=$r->probability;
        $lead->leadAssignStatus=0;
        if($r->progress=="Closing"){
            $lead->statusId=6;
        }
        $lead->save();
        if($r->report ==1 ||$r->report ==3||$r->report ==4||$r->report ==5) {
//            $r->report !=2 ||$r->report !=6
//            if ($currentPossibility != $r->possibility) {

            $chk=Possibilitychange::where('leadId',$lead->leadId)
                ->where('userId',Auth::user()->id)
                ->where('possibilityId',3)
//                                    ->whereDate('created_at',strftime('%F'))
                ->count();

            if($chk ==0 )
            {
                $log = new Possibilitychange;
                $log->leadId = $r->leadId;
                $log->possibilityId = $r->possibility;
                $log->probabilityId = $r->probability;
                $log->userId = Auth::user()->id;
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




        $countNewCallContact=Workprogress::where('userId',Auth::user()->id)
            ->where('leadId',$r->leadId)
            ->where('callingReport',5)
            ->count();



        if($countNewCallContact==0 && $r->report ==5){
            $newCalll=new NewCall();
            $newCalll->leadId=$r->leadId;
            $newCalll->userId=Auth::user()->id;
            $newCalll->progressId=$progress->id;
            $newCalll->save();
        }

//        if($countNewCallContact<2){
//            $newCalll=new NewCall();
//            $newCalll->leadId=$r->leadId;
//            $newCalll->userId=Auth::user()->id;
//            $newCalll->progressId=$progress->id;
//            $newCalll->save();
//        }
//        else{
//            if($r->report ==2 ||$r->report ==6 ){
//                $countNewCall=Workprogress::where('userId',Auth::user()->id)
//                    ->where('leadId',$r->leadId)
//                    ->whereIn('callingReport',[2,6])
//                    ->count();
//
//                if($countNewCall<4 ){
//                    $newCalll=new NewCall();
//                    $newCalll->leadId=$r->leadId;
//                    $newCalll->userId=Auth::user()->id;
//                    $newCalll->progressId=$progress->id;
//                    $newCalll->save();
//                }
//
//            }
//        }






        Session::flash('message', 'Report Updated Successfully');
        return back();
    }
    public function ajax(Request $r){
        if($r->ajax()){
            foreach ($r->leadId as $lead){
                $leadAssigned=new Leadassigned;
                $leadAssigned->assignBy=Auth::user()->id;
                $leadAssigned->assignTo=$r->userId;
                $leadAssigned->leadId=$lead;
                $leadAssigned->save();
            }
            return Response('true');
        }
    }
    public function testLeads(){
        //select * from leads where leadId in(select leadId from workprogress where progress ='Test job')
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->leftJoin('workprogress','workprogress.leadId','=','leads.leadId')
                ->where('workprogress.progress','Test Job')
                ->with('category','country','mined')
                ->where('workprogress.userId',Auth::user()->id)
                ->distinct('workprogress.leadId')
                ->get();
            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);}
        return Redirect()->route('home');
    }
    public function closeLeads(){
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->with('category','country')
                ->leftJoin('workprogress','workprogress.leadId','=','leads.leadId')
                ->where('workprogress.progress','Closing')
                ->where('workprogress.userId',Auth::user()->id)
                ->distinct('workprogress.leadId')
                ->get();
            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);}
        return Redirect()->route('home');
    }
    public function rejectlist(){
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR') {
            $leads=Lead::select('leads.*','workprogress.comments','workprogress.created_at','users.firstName')
                ->with('category','country')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','workprogress.userId','users.id')
                ->where('workprogress.progress','Reject')
                ->where('minedBy',Auth::user()->id)
                ->where('statusId',5)->get();
            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            return view('layouts.lead.rejectList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);
        }
        return Redirect()->route('home');
    }
    public function starLeads(){
        $User_Type=Session::get('userType');
        if($User_Type == 'USER' || $User_Type=='MANAGER' || $User_Type=='SUPERVISOR'){
            $leads=Lead::select('leads.*')
                ->where('possibilityId',4)
                ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
                ->where(function($q){
                    $q->where('leadassigneds.assignTo',Auth::user()->id)
                        ->where('leadassigneds.leaveDate',null)
                        ->orWhere('contactedUserId',Auth::user()->id);
                })
                ->get();
            $callReports=Callingreport::get();
            $possibilities=Possibility::get();
            $categories=Category::where('type',1)->get();
            return view('layouts.lead.testList')
                ->with('leads',$leads)
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('categories',$categories);}
        return Redirect()->route('home');}


    //Click on Blue Badge on Assigned Leads to Make Single Lead as My Lead
    public function addContacted(Request $r){

        $lead=Lead::findOrFail($r->leadId);
        $lead->contactedUserId=Auth::user()->id;
        $lead->statusId=7;
        $lead->save();

        $activity=new Activities;
        $activity->leadId=$r->leadId;
        $activity->userId=Auth::user()->id;
        $activity->activity=Auth::user()->userId .' '. 'made this as My Lead';
        $activity->save();

        Session::flash('message', 'Lead Added To Contacted List');
        return back();
    }


    //Click on Make My Lead button on Assigned Leads page to Make Multiple Leads as My Lead
    public function addmyContacted(Request $r){
        foreach ($r->leadId as $lead){
            $lead=Lead::findOrFail($lead);
            $lead->contactedUserId=Auth::user()->id;
            $lead->statusId=7;
            $lead->save();

            $activity=new Activities;
            $activity->leadId=$lead->leadId;
            $activity->userId=Auth::user()->id;
            $activity->activity=Auth::user()->userId .' '. 'made this as My Lead';
            $activity->save();

        }
//        Session::flash('message', 'Leads are added to you My Leads');
        return Response('true');

    }


// Add Contacted From Temp
    public function addContactedTemp(Request $r){
        $lead=Lead::findOrFail($r->leadId);
        $lead->contactedUserId=Auth::user()->id;
        $lead->filteredPossibility=$lead->possibilityId;
        $lead->statusId=7;
        $lead->save();
        Session::flash('message', 'Lead Added To Contacted List');
        return back();
    }

    public function contacted(){
//        $leads=Lead::with('mined','category','country','possibility')
////            ->select('workprogress.callreport','leads.*')
//            ->where('contactedUserId',Auth::user()->id)
//            ->whereNOTIn('leads.leadId',function($query){
//                $query->select('leadId')->from('workprogress')
//                    ->where('workprogress.userId', Auth::user()->id);
//            })
//            ->orderBy('leads.leadId','desc')->get();
//       return count($leads);

        //For user
        $User_Type=Session::get('userType');
        if($User_Type=='SUPERVISOR' || $User_Type=='USER' || $User_Type=='MANAGER'){

            if($User_Type == 'RA' || $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN' || $User_Type == 'MANAGER'){
                $users=User::select('id','firstName','lastName')
                    ->where('id','!=',Auth::user()->id)
                    ->orwhere('typeId',5)
                    ->orWhere('typeId',2)
                    ->orWhere('typeId',3)
                    ->get();

            }
            else{
                $users=User::select('id','firstName','lastName')
                    ->where('teamId',Auth::user()->teamId)
                    ->where('teamId','!=',null)
                    ->where('active','1')
                    ->where('crmType','!=','local')
                    ->get();

            }
            $assignto=User::select('id','firstName','lastName')
                // ->where('active', 1)
                ->where('typeId',5)
                ->OrWhere('typeId',2)
                ->OrWhere('typeId',3)
                ->get();

            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();

            $possibilities=Possibility::get();
            $probabilities = Probability::get();

            $status=Leadstatus::where('statusId','!=',7)
                ->where('statusId','!=',1)
                ->get();

                $outstatus=Leadstatus::where('statusId','!=',7)
                ->where('statusId','!=',1)
                ->where('statusId','!=',6)
                ->get();
            $country=Country::get();

            $usersforminded=User::select('id','firstName','lastName')
                // ->where('active','1')
                ->where('typeId',5)
                ->OrWhere('typeId',2)
                ->OrWhere('typeId',3)
                ->OrWhere('typeId',4)
                ->get();


            return view('layouts.lead.contact')
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('probabilities',$probabilities)
                ->with('categories',$categories)
                ->with('status',$status)
                ->with('country',$country)
                ->with('outstatus',$outstatus)
                ->with('users',$users)
                ->with('assignto',$assignto)
                ->with('usersforminded',$usersforminded);

        }
        return Redirect()->route('home');
    }

    public function Mycontacted(){
        //For user
        //   $workprogress = Workprogress::where('userId',Auth::user()->id)->where('callingReport',5)->groupBy('leadId')->pluck('workprogress.leadId')->all();

//
//        $leads=Lead::with('mined','category','country','possibility')
//            ->where('contactedUserId',Auth::user()->id)
//            ->whereIn('leads.leadId', $workprogress)
//            ->orderBy('leadId','desc')->get();
//
        //  return count($workprogress);


        $User_Type=Session::get('userType');
        if($User_Type=='SUPERVISOR' || $User_Type=='USER' || $User_Type=='MANAGER'){
            $categories=Category::where('type',1)->get();
            $callReports=Callingreport::get();


            $possibilities=Possibility::get();
            $probabilities=Probability::get();
            $status=Leadstatus::where('statusId','!=',7)
                ->where('statusId','!=',1)
                ->get();
            $country=Country::get();


            return view('layouts.lead.mycontactlead')
                ->with('callReports',$callReports)
                ->with('possibilities',$possibilities)
                ->with('probabilities',$probabilities)
                ->with('categories',$categories)
                ->with('status',$status)
                ->with('country',$country);


        }
        return Redirect()->route('home');
    }


    public function getContacedData(Request $r){
        $leads=Lead::with('mined','category','country','possibility', 'probability','workprogress', 'status')
//            ->select('workprogress.callreport','leads.*')
            ->where('contactedUserId',Auth::user()->id)
            ->orderBy('leads.leadId','desc');

        if ($r->status){

            if ($r->status == "newlead"){

                $leads=$leads->whereNOTIn('leads.leadId',function($query){
                        $query->select('leadId')->from('workprogress')
                        ->where('workprogress.userId', Auth::user()->id);
                    });

            }else {
                
                $leads = $leads->whereHas('lastCallingReport', function ($query) use ($r) {
                    return $query->where('callingReport', '=', $r->status) 
                    ->where('workprogress.userId', Auth::user()->id);
//                    ->orderBy('created_at', 'DESC');
//                    ->groupBy('workprogress.leadId')
//                    ->limit(1);
                });
            }

          //  return $leads = $leads->where('callingReport', '=', $r->status);
        }
        if ($r->minedby){
            $leads = $leads->where('minedBy', $r->minedby);
        }

        return DataTables::eloquent($leads)
            ////for modal view/////////
            ->addColumn('action', function ($lead) {
                return '<a href="#my_modal" data-toggle="modal"  class="btn btn-success btn-sm"
                                   data-lead-id="'.$lead->leadId.'"
                                   data-lead-possibility="'.$lead->possibilityId.'"
                                   data-lead-probability="'.$lead->probabilityId.'">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>
                                <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                    data-lead-id="'.$lead->leadId.'"
                                    data-lead-name="'.$lead->companyName.'"
                                    data-lead-email="'.$lead->email.'"
                                    data-lead-number="'.$lead->contactNumber.'"
                                    data-lead-person="'.$lead->personName.'"
                                    data-lead-website="'.$lead->website.'"
                                    data-lead-linkedin="'.$lead->linkedin.'"
                                    data-lead-mined="'.$lead->mined->firstName.'"
                                    data-lead-category="'.$lead->category->categoryId.'"
                                    data-lead-country="'.$lead->countryId.'"
                                    data-lead-designation="'.$lead->designation.'"
                                    data-lead-founded="'.$lead->founded.'"
                                    data-lead-employee="'.$lead->employee.'"
                                    data-lead-volume="'.$lead->volume.'"
                                    data-lead-frequency="'.$lead->frequency.'"
                                    data-lead-process="'.$lead->process.'"
                                    data-lead-comments="'.$lead->comments.'"
                                    data-lead-ipp="'.$lead->ippStatus.'"
                                    data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                    >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true" ></i></a>
                                    
                                    <a href="#lead_activities" data-toggle="modal" class="btn btn-warning btn-sm"
                                    data-lead-id="'.$lead->leadId.'"
                                    data-lead-name="'.$lead->companyName.'"
                                    ><i class="fa fa-tasks"></i></a>

                                    <a href="." class="btn btn btn-primary btn-sm lead-view-btn"
                                        data-lead-id="'.$lead->leadId.'"
                                    ><i class="fa fa-eye"></i></a>';

            })
            ->addColumn('call', function ($lead){
                return '<a href='.'"skype:'.$lead->contactNumber.'?call">'.$lead->contactNumber.'</a>';
            })
            ->addColumn('check', function ($lead) {
                return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="'.$lead->leadId.'">';
            })

           ->addColumn('callreport', function ($lead) use($r){
                $callingreport = DB::table('workprogress')
                    ->select('report')
                    ->leftjoin('callingreports','callingreports.callingReportId','workprogress.callingReport')
                    ->where('workprogress.leadId',$lead->leadId)
                    ->orderBy('created_at', 'DESC')
                    ->limit(1);
                    if ($r->status){
                        $callingreport = $callingreport->where('workprogress.callingReport', '=', $r->status);
                    }

                $callingreport = $callingreport->get();
                if (($callingreport->isEmpty())) {

                    return $test="New Lead";

                }else{
                    return $test= collect($callingreport)[0]->report;
                }

            })
            ->addColumn('minedby', function ($lead){
                return $lead->mined->firstName;
            })

//            ->filterColumn('callreport', function ($query,$keyword ,$lead){
//                return $query->leftjoin('workprogress','leads.leadId','workprogress.leadId')
//                    ->leftjoin('callingreports','callingreports.callingReportId','workprogress.callingReport')
//
//                    //->where('workprogress.leadId',$lead->leadId)
//
//                    //->orderBy('created_at', 'DESC')
//                    ->where('callreport','like', '%'.$keyword.'%');
//
//            })
            ->rawColumns(['call', 'action','check','minedby'])



            ->make(true);
    }

    public function getMyContacedData(){
//        $workprogress = DB::table('workprogress')->select('leadId')->get()->toArray();
        $workprogress = Workprogress::where('userId',Auth::user()->id)
        ->where('callingReport',5)->orwhere('callingReport',11)
        ->groupBy('leadId')->pluck('workprogress.leadId')->all();

        $leads=Lead::with('mined','category','country','possibility', 'probability', 'status')
            ->where('contactedUserId',Auth::user()->id)
            ->whereIn('leads.leadId', $workprogress)
            ->orderBy('leadId','desc');
        return DataTables::eloquent($leads)
            ////for modal view/////////
            ->addColumn('action', function ($lead) {
                return '<a href="#my_modal" data-toggle="modal"  class="btn btn-success btn-sm"
                                   data-lead-id="'.$lead->leadId.'"
                                   data-lead-possibility="'.$lead->possibilityId.'"
                                   data-lead-probability="'.$lead->probabilityId.'">
                                    <i class="fa fa-phone" aria-hidden="true"></i></a>
                                    <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                    data-lead-id="'.$lead->leadId.'"
                                    data-lead-name="'.$lead->companyName.'"
                                    data-lead-email="'.$lead->email.'"
                                    data-lead-number="'.$lead->contactNumber.'"
                                    data-lead-person="'.$lead->personName.'"
                                    data-lead-website="'.$lead->website.'"
                                    data-lead-mined="'.$lead->mined->firstName.'"
                                    data-lead-category="'.$lead->category->categoryId.'"
                                    data-lead-country="'.$lead->countryId.'"
                                    data-lead-designation="'.$lead->designation.'"
                                    data-lead-linkedin="'.$lead->linkedin.'"
                                    data-lead-process="'.$lead->process.'"
                                    data-lead-founded="'.$lead->founded.'"
                                    data-lead-frequency="'.$lead->frequency.'"
                                    data-lead-volume="'.$lead->volume.'"
                                    data-lead-employee="'.$lead->employee.'"
                                    data-lead-ipp="'.$lead->ippStatus.'"
                                    data-lead-comments="'.$lead->comments.'"
                                    data-lead-created="'.Carbon::parse($lead->created_at)->format('Y-m-d').'"
                                    >
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
            })
            ->addColumn('call', function ($lead){
                return '<a href='.'"skype:'.$lead->contactNumber.'?call">'.$lead->contactNumber.'</a>';
            })

            ->addColumn('callreport', function ($lead){
                $callingreport = DB::table('workprogress', 'workprogress.created_at as workprogress_created_at')
                    ->select('report')
                    ->leftjoin('callingreports','workprogress.callingreport','callingreports.callingReportId')
                    ->leftjoin('leads', 'workprogress.leadId', 'leads.leadId')
                    ->where('workprogress.leadId',$lead->leadId)
                    // ->where('workprogress.callingReport','5')
                    // ->orwhere('workprogress.callingReport','11')
                    ->where('leads.contactedUserId', Auth::user()->id)
                    ->latest('workprogress.created_at', 'DESC')
                    ->groupBy('workprogress.leadId')
                    ->get();


//                if (($callingreport->isEmpty())) {
//
//                    return $test="New Lead";
//                }else{

                return $test=$callingreport->first()->report;
                //   }
            })

            ->rawColumns(['call', 'action'])
            ->filterColumn('callreport',function ($query,$keyword){

                return $query->where('callreport','like', '%'.$keyword. '%');

            })
            ->make(true);
    }


    public function  editcontactmodalshow (Request $r){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }

        $follow=Followup::select('followUpDate')
            ->where('leadId', $r->leadId)
            ->where('userId',Auth::user()->id)
            ->where('workStatus',0)
            ->orderBy('followId','desc')
//            ->limit(1)
            ->first();

        return Response($follow);
    }

    public function rejectedLeads(){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }
        return view('layouts.lead.rejectedLead');
    }

    public function rejectData(Request $request)
    {
        $leads = Lead::with('mined')
            ->where('statusId',5);
        return DataTables::eloquent($leads)->make(true);
    }

    public function rejectStore(Request $r){
        $lead=Lead::findOrFail($r->leadId);
//        if($lead->statusId ==1){
        $lead->statusId=5;
        $lead->contactedUserId=null;
        $lead->leadAssignStatus=0;
        $lead->save();

        $activity=new Activities;
        $activity->leadId=$r->leadId;
        $activity->userId=Auth::user()->id;
        $activity->activity=$r->comment;
        $activity->activity=Auth::user()->userId .' '. 'Rejected this lead';
        $activity->save();
//        }

        $pipeline = SalesPipeline::where('leadId', $r->leadId)
        ->first();

        if ($pipeline) {
            $pipeline->workStatus = 0;
            $pipeline->save();
        }

        Session::flash('message', 'Lead Rejected Successfully');
        return back();
    }


    // When user changes the lead's status from Edit Lead to Leave the Lead
    public function leaveLead(Request $r){


        $pipeline = SalesPipeline::where('leadId', $r->leadId)->first();

        if ($pipeline) {
            $pipeline->workStatus = 0;
            $pipeline->save();
        }
        

        if($r->Status==6){
            $newFile=new NewFile();
            $newFile->leadId=$r->leadId;
            $newFile->fileCount=$r->newFile;
            $newFile->userId=Auth::user()->id;
            $newFile->save();
        }

        try {

        $assignId=Leadassigned::select('assignId')
            ->where('leadId',$r->leadId)
            ->where('assignTo',Auth::user()->id)
            ->where('leaveDate',null)
            ->limit(1)->first();
        if ($assignId){
            $leave=Leadassigned::find($assignId->assignId);
            $leave->leaveDate=date('Y-m-d');
            $leave->save();
            $l=Lead::findOrFail($leave->leadId);
            $l->leadAssignStatus=0;
            $l->save();
        }

        } catch(Exception $e){

        }

        $lead=Lead::findOrFail($r->leadId);
        $lead->statusId=$r->Status;
        if($lead->contactedUserId == Auth::user()->id){

            $lead->contactedUserId =null;
            $lead->ippStatus=0;
            $lead->leadAssignStatus = 0;
            $lead->save();

            $activity=new Activities;
            $activity->leadId=$r->leadId;
            $activity->userId=Auth::user()->id;

            if($lead->statusId==2){           
                $activity->activity=Auth::user()->userId .' '. 'Filtered this lead';
            } 
            elseif($lead->statusId==3){
                $activity->activity=Auth::user()->userId .' '. 'marked this lead as Not Interested and left';
            }
            elseif($lead->statusId==4){
                $activity->activity=Auth::user()->userId .' '. 'left this lead as Bad Lead';
            }
            elseif($lead->statusId==5){
                $activity->activity=Auth::user()->userId .' '. 'Rejected this lead';
            }
            elseif($lead->statusId==6){
                $activity->activity=Auth::user()->userId .' '. 'marked it as Client and left the lead';
            }
            elseif($lead->statusId==8){
                $activity->activity=Auth::user()->userId .' '. 'marked it as Duplicate lead';
            }
            $activity->save();


            return back();
        }

        $lead->save();


        Session::flash('message', 'You have Left The Lead successfully');
        return back();

    }


    public function destroy($id){
        $lead=Lead::findOrFail($id);
        $lead->delete();
        Session::flash('message', 'Lead deleted successfully');
        return back();
    }


    public function verifylead(){
        if(Auth::user()->crmType =='local'){
            return redirect()->route('home');
        }

        $cats=Category::where('type', 1)->get();
        $countries=Country::get();
        $possibilities=Possibility::get();
        $probabilities=Probability::get();
        $callReports = Callingreport::get();
        $user = User::get()->where('crmType', '!=', 'local')->where('active', '1');
        return view('layouts.lead.verify')
            ->with('categories',$cats)
            ->with('countries',$countries)
            ->with('possibilities',$possibilities)
            ->with('probabilities',$probabilities)
            ->with('callReports',$callReports)
            ->with('user',$user);
    }



    public function verifyallLeads(Request $r){
        $leads=Lead::with('country','category','mined','contact', 'status','workprogress')
            ->orderBy('leadId','desc');

        return DataTables::eloquent($leads)
            ->make(true);
 
        }


        public function ippList(){
            // $date = Carbon::now();

            $User_Type=Session::get('userType');
            if($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR'){
           
                $leads=Lead::select('leads.*', 'workprogress.created_at','users.firstName','users.lastName')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                // ->where('leads.contactedUserId', Auth::user()->id)
                ->where('leads.ippStatus', 1)
                ->groupBy('leads.leadId')
                ->orderBy('workprogress.created_at','desc')
                ->get();
            }else{
            $leads=Lead::select('leads.*', 'workprogress.created_at','users.firstName','users.lastName')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                ->where('leads.contactedUserId', Auth::user()->id)
                ->where('leads.ippStatus', 1)
                ->groupBy('leads.leadId')
                ->orderBy('workprogress.created_at','desc')
                ->get();
            }


            // $latestLead=Workprogress::select('created_at')->latest()->first();
            $possibilities = Possibility::get();
            $probabilities = Probability::get();
            $callReports = Callingreport::get();
            $categories=Category::where('type',1)->get();
            $country=Country::get();
            $status=Leadstatus::get();


            return view('layouts.lead.ipp')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories',$categories)
                ->with('status',$status)
                ->with('country',$country);
              
        }





        //ANALYSIS PART

        public function analysisHomePage ()
        {


            return view ('report.analysisHome');
        
        }
    


        public function allAssignedButNotMyleads()
        {

            // Retrieve user type from the session
            $User_Type=Session::get('userType');
            if($User_Type == 'ADMIN' || $User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR'){

           // Retrieve assigned leads with associated data 
            $leads = Lead::select('leads.*', 'leadassigneds.*', 'users.firstName', 'users.lastName')
            ->leftJoin('leadassigneds', function ($join) {
                $join->on('leads.leadId', '=', 'leadassigneds.leadId')
                     ->whereIn('leadassigneds.created_at', function ($query) {
                         $query->select(DB::raw('MAX(created_at)'))
                               ->from('leadassigneds')
                               ->whereRaw('leadassigneds.leadId = leads.leadId')
                               ->groupBy('leadassigneds.leadId');
                     });
            })
            ->leftJoin('users', 'leadassigneds.assignTo', 'users.id')
            ->where('leads.contactedUserId', NULL)
            ->where('leads.leadAssignStatus', 1)
            ->where('leadassigneds.workStatus', 0)
            ->where('leadassigneds.leaveDate', NULL)
            ->get();
        


            // Retrieve additional data
            $possibilities = Possibility::get();
            $probabilities = Probability::get();
            $callReports = Callingreport::get();
            $categories=Category::where('type',1)->get();
            $country=Country::get();
            $status=Leadstatus::get();

            
            // Return the view with the retrieved data
            return view('report.assignedButNotTaken')
            ->with('leads', $leads)
            ->with('callReports', $callReports)
            ->with('possibilities', $possibilities)
            ->with('probabilities', $probabilities)
            ->with('categories',$categories)
            ->with('status',$status)
            ->with('country',$country);

        } else {

            return view ('report.analysisHome');
        }


        }


        public function duplicateLeadList (Request $r)
        {

            $User_Type=Session::get('userType');
            if($User_Type == 'ADMIN' || $User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR'){
           
                $leads=Lead::select('leads.*','users.firstName','users.lastName')
                ->leftJoin('leadstatus','leads.statusId','leadstatus.statusId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                ->where('leads.statusId', 8)
                ->get();

   

                $possibilities = Possibility::get();
                $probabilities = Probability::get();
                $callReports = Callingreport::get();
                $categories=Category::where('type',1)->get();
                $country=Country::get();
                $status=Leadstatus::get();
                

                return view('report.duplicateLeadList')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories',$categories)
                ->with('status',$status)
                ->with('country',$country);

            } else {

                return view ('report.analysisHome');
            }
    
        }

  
        
        
        public function getallConversations(){

            $User_Type=Session::get('userType');
            if($User_Type == 'ADMIN' ||  $User_Type == 'SUPERVISOR'){
           
                $leads=Lead::select('leads.*','users.firstName','users.lastName', 'workprogress.created_at as workprogress_created_at')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                ->where('workprogress.callingReport', 11)
                ->groupBy('leads.leadId')
                ->orderBy('workprogress.created_at','desc')
                ->get();
           
            } else {
           
                $leads=Lead::select('leads.*','users.firstName','users.lastName', 'workprogress.created_at as workprogress_created_at')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                ->where('users.id', Auth::user()->id)
                ->where('workprogress.callingReport', 11)
                ->groupBy('leads.leadId')
                ->orderBy('workprogress.created_at','desc')
                ->get();
       
            }

            $possibilities = Possibility::get();
            $probabilities = Probability::get();
            $callReports = Callingreport::get();
            $categories=Category::where('type',1)->get();
            $country=Country::get();
            $status=Leadstatus::get();


            return view('report.allConversations')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories',$categories)
                ->with('status',$status)
                ->with('country',$country);
              
        }


        //ANALYZING COMMENTS TO GET SPECIFIC LEADS 

        public function analysisComments(Request $request)
        {
            
            
            $userType = Session::get('userType');
            $searchTerm = $request->input('searchTerm');
            $keywords = [];

        
            if (!empty($searchTerm)) {
                // Split the search term into an array of keywords
                $keywords = explode(',', $searchTerm);
                // Trim whitespace from each keyword
                $keywords = array_map('trim', $keywords);
                // Remove any empty keywords
                $keywords = array_filter($keywords);
            }
        
            if (empty($keywords)) {
                // Return the view without executing the search logic
                return view('report.analysisComments')
                    ->with('searchTerm', $searchTerm);
            }
            
            if ($userType == 'SUPERVISOR' || $userType == 'ADMIN') {
            
                $analysis = Lead::select('leads.*', 'users.userId')
                    ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                    ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                    ->whereIn('leads.categoryId', [1, 4, 5, 6, 63])
                    ->where('leads.statusId', '!=', 6)
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere('workprogress.comments', 'like', '%' . $keyword . '%');
                        }
                    })
                    ->groupBy('leads.leadId')
                    ->orderBy('workprogress.created_at', 'desc')
                    ->get();
            } else {
                $analysis = [];
            }
        
            $possibilities = Possibility::get();
            $probabilities = Probability::get();
            $callReports = Callingreport::get();
            $categories = Category::where('type', 1)->get();
            $country = Country::get();
            $status = Leadstatus::get();
        
            return view('report.analysisComments')
                ->with('analysis', $analysis)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories', $categories)
                ->with('status', $status)
                ->with('country', $country)
                ->with('searchTerm', $searchTerm);
        }

    
    


            public function exportAnalysisComments(Request $request)
            {
            
                $userType = Session::get('userType');
                $searchTerm = $request->input('searchTerm');
                $keywords = [];

            
                if (!empty($searchTerm)) {
                    // Split the search term into an array of keywords
                    $keywords = explode(',', $searchTerm);
                    // Trim whitespace from each keyword
                    $keywords = array_map('trim', $keywords);
                    // Remove any empty keywords
                    $keywords = array_filter($keywords);
                }
            
                if (empty($keywords)) {
                    // Return the view without executing the search logic
                    return view('report.analysisComments')
                        ->with('searchTerm', $searchTerm);
                }

                    $analysis = Lead::select(
                        'leads.leadId',
                        'leads.companyName',
                        'categories.categoryName as category_name',
                        'leads.website',
                        'leadstatus.statusName as status_name',
                        'countries.countryName as country_name',
                        'users.userId'
                    )
                    ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                    ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                    ->leftJoin('categories', 'leads.categoryId', 'categories.categoryId')
                    ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
                    ->leftJoin('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                    ->whereIn('leads.categoryId', [1, 4, 5, 6, 63])
                    ->where('leads.statusId', '!=', 6)
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere('workprogress.comments', 'like', '%' . $keyword . '%');
                        }
                    })
                    ->groupBy('leads.leadId')
                    ->orderBy('workprogress.created_at', 'desc')
                    ->get();
            

                    $categories = Category::where('type', 1)->get();
                    $country = Country::get();
                    $status = Leadstatus::get();
                
                    $export = new SelectedAnalysisCommentsExport($analysis, $categories, $country, $status);

                    return Excel::download($export, 'selected_analysis_comments.csv');
            }

    


        public function frequentlyFilteredLeads()
        {

            $User_Type = Session::get('userType');
            if ($User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN') {

            $recentLeads = Lead::select('leads.*','activities.created_at AS activities_created_at', 'leadstatus.statusName', 'users.userId')
                    ->whereBetween(DB::raw('date(leads.created_at)'), [Carbon::now()->subDays(30), date('Y-m-d')])
                    ->where('leads.contactedUserId', NULL)
                    ->join('activities', 'leads.leadId','activities.leadId')
                    ->where(function ($query) {
                        $query->where('activities.activity', 'like', '%Filtered%')
                            ->orWhere('activities.activity', 'like', '%Rejected%')
                            ->orWhere('activities.activity', 'like', '%Bad%')
                            ->orWhere('activities.activity', 'like', '%Duplicate%');
                    })
                    ->join('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                    ->join('users','leads.minedBy','users.id')
                    ->orderBy('leads.created_at', 'desc')
                    ->groupBy('activities.leadId')
                    ->get();


            $recentLeads = $recentLeads->map(function ($lead) {
                    $activitiesCreatedAt = Carbon::parse($lead->activities_created_at);
                    $leadCreatedAt = Carbon::parse($lead->created_at);
                    $lead->differences = $activitiesCreatedAt->diff($leadCreatedAt)->format('%d days, %h hours');
                    return $lead;
                   });

                $possibilities = Possibility::get();
                $probabilities = Probability::get();
                $callReports = Callingreport::get();
                $categories = Category::where('type', 1)->get();
                $country = Country::get();              
                $status = Leadstatus::get();
                $users = User::get();

            return view('report.frequentlyFiltered', compact('recentLeads'))
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories', $categories)
                ->with('status', $status)
                ->with('country', $country)
                ->with('users', $users);

            } else {

                return view ('report.analysisHome');
            }

        }


        public function reportAllActivties(Request $r)
        {
            $User_Type = Session::get('userType');
            if ($User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN') {
                
                $activities=Activities::Select('activities.activityId', 'users.firstName', 'users.lastName', 'leads.leadId', 'leads.companyName', 'leadstatus.statusName', 'activities.activity','activities.created_at')
                        ->join('users', 'activities.userId','users.id')
                        ->join('leads', 'activities.leadId', 'leads.leadId')
                        ->join('leadstatus', 'leads.statusId','leadstatus.statusId')
                        // ->where('users.active', 1)
                        ->orderBy('activityId', 'desc')
                        // ->latest()->paginate(50);                        
                        ->get();
    
                } else {

                    $activities = Activities::select('activities.activityId', 'users.firstName', 'users.lastName', 'leads.leadId', 'leads.companyName', 'leadstatus.statusName', 'activities.activity', 'activities.created_at')
                    ->join('users', 'activities.userId', 'users.id')
                    ->join('leads', 'activities.leadId', 'leads.leadId')
                    ->join('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                    ->where('activities.userId', Auth::user()->id)
                    ->orderBy('activities.created_at', 'DESC')
                    ->paginate(500);

                }

                return view('report.activities', compact('activities'));
        
        }        


       




                public function getAllChasingLeads(){

                    $User_Type=Session::get('userType');
                    if($User_Type == 'ADMIN' ||  $User_Type == 'SUPERVISOR'){

                        $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', DB::raw('COUNT(workprogress.progressId) AS progressCount'))
                        ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                        ->leftJoin('users', 'workprogress.userId', 'users.id')
                        ->whereNotNull('leads.contactedUserId')
                        ->where('leads.countryId', '!=', '49')
                        ->where('leads.statusId', '7')
                        ->where('users.active', '1')
                        ->havingRaw('progressCount > 10')
                        ->groupBy('leads.leadId', 'workprogress.userId')
                        ->orderBy('progressCount', 'desc')
                        ->get();
                    } else {
                        $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', DB::raw('COUNT(workprogress.progressId) AS progressCount'))
                        ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                        ->leftJoin('users', 'workprogress.userId', 'users.id')
                        ->where('users.id', Auth::user()->id)
                        ->whereNotNull('leads.contactedUserId')
                        ->where('leads.countryId', '!=', '49')
                        ->where('leads.statusId', '7')
                        ->where('users.active', '1')
                        ->havingRaw('progressCount > 10')
                        ->groupBy('leads.leadId', 'workprogress.userId')
                        ->orderBy('progressCount', 'desc')
                        ->get();
                    }

                    $possibilities = Possibility::get();
                    $probabilities = Probability::get();
                    $callReports = Callingreport::get();
                    $categories=Category::where('type',1)->get();
                    $country=Country::get();
                    $status=Leadstatus::get();
        
        
                    return view('report.chasingLeads')
                        ->with('leads', $leads)
                        ->with('callReports', $callReports)
                        ->with('possibilities', $possibilities)
                        ->with('probabilities', $probabilities)
                        ->with('categories',$categories)
                        ->with('status',$status)
                        ->with('country',$country);

                     

                }    
    


          
                public function getLongTimeNoCall()
                {
                    $User_Type = Session::get('userType');
                
                    if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR') {

                        $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as workprogress_created_at')
                            ->leftJoin(DB::raw('(SELECT leadId, MAX(created_at) as latest_created_at
                                            FROM workprogress
                                            GROUP BY leadId) AS wp'), function ($join) {
                                $join->on('leads.leadId', '=', 'wp.leadId');
                            })
                            ->leftJoin('workprogress', function ($join) {
                                $join->on('wp.leadId', '=', 'workprogress.leadId')
                                    ->on('wp.latest_created_at', '=', 'workprogress.created_at');
                            })
                            // ->leftJoin('users', 'workprogress.userId', '=', 'users.id')
                            ->leftJoin('users', function ($join) {
                                $join->on('workprogress.userId', '=', 'users.id')
                                    ->whereColumn('leads.contactedUserId', '=', 'users.id');
                            })
                            ->where('leads.contactedUserId', '!=', null)
                            ->whereNotIn('leads.countryId', ['8', '49', '50', '51', '52'])
                            ->where('leads.statusId', 7)
                            ->whereDate('workprogress.created_at', '<=', now()->subDays(180))
                            ->orderBy('workprogress.created_at', 'desc')
                            ->get();

                    } else {    
                            $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as workprogress_created_at')
                            ->leftJoin(DB::raw('(SELECT leadId, MAX(created_at) as latest_created_at
                                            FROM workprogress
                                            GROUP BY leadId) AS wp'), function ($join) {
                                $join->on('leads.leadId', '=', 'wp.leadId');
                            })
                            ->leftJoin('workprogress', function ($join) {
                                $join->on('wp.leadId', '=', 'workprogress.leadId')
                                    ->on('wp.latest_created_at', '=', 'workprogress.created_at');
                            })
                            // ->leftJoin('users', 'workprogress.userId', '=', 'users.id')
                            ->leftJoin('users', function ($join) {
                                $join->on('workprogress.userId', '=', 'users.id')
                                    ->whereColumn('leads.contactedUserId', '=', 'users.id');
                            })
                            ->where('users.id', Auth::user()->id)
                            ->where('leads.contactedUserId', '!=', null)
                            ->whereNotIn('leads.countryId', ['8', '49', '50', '51', '52'])
                            ->where('leads.statusId', 7)
                            ->whereDate('workprogress.created_at', '<=', now()->subDays(90))
                            ->orderBy('workprogress.created_at', 'desc')
                            ->get();

                    }        

                        $outstatus=Leadstatus::where('statusId','!=',7)
                            ->where('statusId','!=',1)
                            ->where('statusId','!=',6)
                            ->get();
        
                        $possibilities = Possibility::get();
                        $probabilities = Probability::get();
                        $callReports = Callingreport::get();
                        $categories = Category::where('type', 1)->get();
                        $country = Country::get();
                        $status = Leadstatus::get();
                
                    return view('report.longTimeNoCall')
                        ->with('leads', $leads)
                        ->with('callReports', $callReports)
                        ->with('possibilities', $possibilities)
                        ->with('probabilities', $probabilities)
                        ->with('categories', $categories)
                        ->with('status', $status)
                        ->with('country', $country)
                        ->with('outstatus', $outstatus);
                }
                 

                public function exportLongTimeNoCall()
                {
                    $User_Type = Session::get('userType');
                
                    if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR') {

                        $leads = Lead::select(
                            'leads.leadId',
                            'leads.companyName',
                            'categories.categoryName as category_name',
                            'leads.website',
                            'leads.contactNumber',
                            'leadstatus.statusName as status_name',
                            'countries.countryName as country_name',
                            'users.userId',
                            'workprogress.created_at as workprogress_created_at'
                            )

                            ->leftJoin(DB::raw('(SELECT leadId, MAX(created_at) as latest_created_at
                                            FROM workprogress
                                            GROUP BY leadId) AS wp'), function ($join) {
                                $join->on('leads.leadId', '=', 'wp.leadId');
                            })
                            ->leftJoin('workprogress', function ($join) {
                                $join->on('wp.leadId', '=', 'workprogress.leadId')
                                    ->on('wp.latest_created_at', '=', 'workprogress.created_at');
                            })
                        
                            // ->leftJoin('users', 'workprogress.userId', '=', 'users.id')
                            ->leftJoin('users', function ($join) {
                                $join->on('workprogress.userId', '=', 'users.id')
                                    ->whereColumn('leads.contactedUserId', '=', 'users.id');
                            })
                            ->leftJoin('categories', 'leads.categoryId', 'categories.categoryId')
                            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
                            ->leftJoin('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                            ->where('leads.contactedUserId', '!=', null)
                            ->whereNotIn('leads.countryId', ['8', '49', '50', '51', '52'])
                            ->where('leads.statusId', 7)
                            ->whereDate('workprogress.created_at', '<=', now()->subDays(180))
                            ->orderBy('workprogress.created_at', 'desc')
                            ->get();

                    }        

                        $categories = Category::where('type', 1)->get();
                        $country = Country::get();
                        $status = Leadstatus::get();
                
                 
                        $export = new LongTimeNoCallExport ($leads, $categories, $country, $status);

                        return Excel::download($export, 'LongTimeNoCallExport.csv');
                        }



                    public function getFredChasingLeads(){

                        $User_Type=Session::get('userType');
                        if($User_Type == 'SUPERVISOR'){
    
                            $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', DB::raw('COUNT(workprogress.progressId) AS progressCount'))
                            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                            ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                            ->where('leads.statusId', '!=', '6' )
                            ->where('workprogress.userId', '2')
                            ->havingRaw('progressCount > 10')
                            ->groupBy('leads.leadId', 'workprogress.userId')
                            ->orderBy('progressCount', 'desc')
                            ->get();

    
                        $leadIds = $leads->pluck('leadId')->toArray();

                        $wp = Workprogress::whereIn('leadId', $leadIds)
                            ->where(function ($query) {
                                $query->where('comments', 'LIKE', '%TEST%')
                                    ->orWhere('comments', 'LIKE', '%CLOSED%')
                                    ->orWhere('comments', 'LIKE', '%CLIENT%');
                            })
                            ->get();
                    

                        $possibilities = Possibility::get();
                        $probabilities = Probability::get();
                        $callReports = Callingreport::get();
                        $categories=Category::where('type',1)->get();
                        $country=Country::get();
                        $status=Leadstatus::get();
            
            
                        return view('report.fredChasingLeads')
                            ->with('leads', $leads)
                            ->with('callReports', $callReports)
                            ->with('possibilities', $possibilities)
                            ->with('probabilities', $probabilities)
                            ->with('categories',$categories)
                            ->with('status',$status)
                            ->with('country',$country)
                            ->with('wp',$wp);

                        } else {

                            return view ('report.analysisHome');
                        }
                
                    }    


                                public function exportFredChasingLeads()
                                {
                                    $User_Type = Session::get('userType');
                                    if ($User_Type == 'SUPERVISOR') {
                                        // Retrieve leads
                                        $leads = Lead::select('leads.leadId',
                                            'leads.companyName',
                                            'categories.categoryName as category_name',
                                            'leads.website',
                                            'leads.contactNumber',
                                            'leadstatus.statusName as status_name',
                                            'countries.countryName as country_name',
                                            'users.userId',
                                            DB::raw('COUNT(workprogress.progressId) AS progressCount')
                                        )
                                            ->leftJoin('categories', 'leads.categoryId', 'categories.categoryId')
                                            ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
                                            ->leftJoin('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                                            ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                                            ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                                            ->where('leads.statusId', '!=', '6')
                                            ->where('workprogress.userId', '2')
                                            ->havingRaw('progressCount > 10')
                                            ->groupBy('leads.leadId', 'workprogress.userId')
                                            ->orderBy('progressCount', 'desc')
                                            ->get();
                                    }
                                
                                    $leadIds = $leads->pluck('leadId')->toArray();
                                
                                    // Retrieve workprogress comments
                                    $wp = Workprogress::whereIn('leadId', $leadIds)
                                        ->where(function ($query) {
                                            $query->where('comments', 'LIKE', '%TEST%')
                                                ->orWhere('comments', 'LIKE', '%CLOSED%')
                                                ->orWhere('comments', 'LIKE', '%CLIENT%');
                                        })
                                        ->get();
                                
                                    $categories = Category::where('type', 1)->get();
                                    $country = Country::get();
                                    $status = Leadstatus::get();
                                
                                    $export = new fredChasingLeadsExport($leads, $wp);
                                
                                    return Excel::download($export, 'fredChasingLeadsExport.csv');
                                }
                    
                                
                                

                            public function getTestButNotClosedList()
                            {
                                $User_Type = Session::get('userType');
                            
                                if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR') {
            
                                    $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as wp_created_at', 'workprogress.comments as last_comment')
                                        ->leftJoin('workprogress', 'leads.leadId', '=', 'workprogress.leadId')
                                        ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                                        ->where('leads.statusId', '!=', 6)
                                        ->where('workprogress.progress', 'LIKE', '%Test%')
                                        ->whereNotExists(function ($query) {
                                            $query->select(DB::raw(1))
                                                ->from('workprogress as wp2')
                                                ->whereRaw('wp2.leadId = leads.leadId')
                                                ->where('wp2.progress', 'LIKE', '%Closing%');
                                        })
                                        ->orderBy('workprogress.created_at', 'desc')
                                        ->groupBy('leads.leadId')
                                        ->get();
                                            
                                } else {

                                    $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as wp_created_at', 'workprogress.comments as last_comment')
                                        ->leftJoin('workprogress', 'leads.leadId', '=', 'workprogress.leadId')
                                        ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                                        ->where('users.id', Auth::user()->id)
                                        ->where('leads.statusId', '!=', 6)
                                        ->where('workprogress.progress', 'LIKE', '%Test%')
                                        ->whereNotExists(function ($query) {
                                            $query->select(DB::raw(1))
                                                ->from('workprogress as wp2')
                                                ->whereRaw('wp2.leadId = leads.leadId')
                                                ->where('wp2.progress', 'LIKE', '%Closing%');
                                        })
                                        ->orderBy('workprogress.created_at', 'desc')
                                        ->groupBy('leads.leadId')
                                        ->get();
                                                
                                }        
            
                    
                                    $possibilities = Possibility::get();
                                    $probabilities = Probability::get();
                                    $callReports = Callingreport::get();
                                    $categories = Category::where('type', 1)->get();
                                    $country = Country::get();
                                    $status = Leadstatus::get();
                            
                                return view('report.testButNotClosedList')
                                    ->with('leads', $leads)
                                    ->with('callReports', $callReports)
                                    ->with('possibilities', $possibilities)
                                    ->with('probabilities', $probabilities)
                                    ->with('categories', $categories)
                                    ->with('status', $status)
                                    ->with('country', $country)
                                    ;
                            }
                                

                                    
                              








                //Single Account/Lead View Page Functions

                public function accountView($leadId) {
                    $User_Type = Session::get('userType');
 
                    $lead = Lead::find($leadId);

                    // Check if the lead exists
                    if (!$lead) {
                        abort(404);
                    }

                    // Check if the current user is authorized to view the lead
                    if ($User_Type !== 'SUPERVISOR' &&  $User_Type !== 'ADMIN' && $lead->contactedUserId !== auth()->id()) {
                        abort(404);
                    }

                    $latestUpdate = $lead->activities()
                        ->select('activities.*', 'users.firstName', 'users.lastName', 'activities.created_at AS activities_created_at')
                        ->where('activity', 'LIKE', '%updated%')
                        ->leftJoin('users', 'activities.userId', 'users.id')
                        ->orderBy('activities.created_at', 'desc')
                        ->first();

                    $didTestWithUs = $lead->workprogress()
                        ->select('progress', 'created_at')
                        ->where('progress', 'LIKE', '%Test%')
                        ->get();
                    
                    $allComments = $lead->Workprogress()
                        ->select('users.firstName','users.lastName','callingreports.report','comments','workprogress.created_at')
                        ->leftJoin('users','users.id','workprogress.userId')
                        ->leftJoin('callingreports','callingreports.callingReportId','workprogress.callingReport')
                        ->orderby('workprogress.created_at', 'desc')
                        ->get();


                    $previousFollowups =  $lead->followup()
                        ->select('followup.*', 'users.firstName', 'users.lastName')
                        ->leftjoin ('users', 'followup.userID', 'users.id')
                        // ->where('leadId', $r->leadId)
                        ->orderBy ('followUpDate', 'desc')
                        ->get();

                    $latestFollowups = $lead->followup()
                        ->select('leadId', DB::raw('MAX(followUpDate) as lastFollowUpDate'))
                        // ->where('leadId', $r->leadId)    
                        ->groupBy('leadId')
                        ->get();       

                    $followupCounter = $lead->Workprogress()
                        ->select('users.userId as userId', DB::raw('count(*) as userCounter'))
                        ->join('users', 'workprogress.userId', 'users.id')
                        // ->where('leadId', $r->leadId)
                        ->groupBy('workprogress.userId')
                        ->get();

                    $pipeline = $lead->SalesPipeline()
                        ->select('salespipeline.*')
                        // ->join('leads', 'salespipeline.leadId', 'leads.leadId')
                        ->where('salespipeline.workStatus', 1)
                        ->get();

                    $users = User::select('users.firstName', 'users.lastName')
                        ->Join('leads', 'users.id', 'leads.contactedUserId')
                        ->where('leads.leadId', $leadId)
                        ->get();  
                        
                        

                    $possibilities = Possibility::get();
                    $probabilities = Probability::get();
                    $categories = Category::where('type',1)->get();
                    $country = Country::get();
                    $status = Leadstatus::get();
        
                    return view('layouts.lead.accountView')
                        ->with('lead', $lead)
                        ->with('possibilities', $possibilities)
                        ->with('probabilities', $probabilities)
                        ->with('categories',$categories)
                        ->with('status',$status)
                        ->with('country',$country)
                        ->with('latestUpdate',$latestUpdate)
                        ->with('didTestWithUs',$didTestWithUs)
                        ->with('allComments',$allComments)
                        ->with('previousFollowups',$previousFollowups)
                        ->with('latestFollowups',$latestFollowups)
                        ->with('followupCounter',$followupCounter)
                        ->with('pipeline',$pipeline)
                        ->with('users',$users)

                        ;

                }



                

























                public function googleSearch(Request $request)
                {
                    $searchTerm = $request->input('searchTerm');
                    $country = $request->input('country');
                    $results = [];
                
                    // Store the engine key and API key in the session
                    $engineKey = $request->input('engineKey');
                    $apiKey = $request->input('apiKey');
                    Session::put('engineKey', $engineKey);
                    Session::put('apiKey', $apiKey);
                
                    if (empty($searchTerm)) {
                        // Return the view without executing the search logic
                        return view('mining.googleSearch')->with('searchTerm', $searchTerm);
                    }
        
                    $excludedKeywords = DB::table('excludeKeywords')->pluck('keyword')->toArray();
                    
                    $excludedQuery = '';
                    foreach ($excludedKeywords as $keyword) {
                        $excludedQuery .= ' -' . $keyword;
                    }
                
                    $excludedRegions = ['USA', 'Switzerland', 'Norway','India','China','Hong Kong','Canada','Brazil', 'Africa', 'Nigeria', 'Ghana', 'South Africa','NY','MA','WA','CA','ND','CT','DE','AK','NE','IL','FL']; // Specify the regions to exclude
        
                    $excludedRegionsQuery = '';
                    foreach ($excludedRegions as $region) {
                        $excludedRegionsQuery .= ' -site:' . $region . '.*';
                    }
                
                    $searchTerm = $searchTerm . ' ' . $country; // Append the selected country to the search term
        
                    $results = [];
        
                    for ($start = 1; $start <= 40; $start += 10) {
                        $parameters = [
                            'start' => $start,
                            'num' => 10,
                        ];
        
                        $fulltext = new LaravelGoogleCustomSearchEngine(); // initialize the plugin
                        $fulltext->setEngineId($engineKey); // gets the engine ID
                        $fulltext->setApiKey($apiKey); // gets the API key
                        $partialResults = $fulltext->getResults($searchTerm . $excludedQuery . $excludedRegionsQuery, $parameters); // Exclude the specified keywords and regions from the search query
        
                        // Extract the domain from each search result URL
                        foreach ($partialResults as $result) {
                            $result->domain = $this->getDomainFromURL($result->link);
                            $result->availability = $this->checkLeadAvailability($result->domain);
                            $results[] = $result;
                        }
                    }
        
                    return view('mining.googleSearch')
                        ->with('results', $results)
                        ->with('searchTerm', $searchTerm);
                    }
                
                        private function getDomainFromURL($url)
                        {
                            preg_match('/^(?:https?:\/\/)?(?:www\.)?([^.]+)\.[^.]+/i', $url, $matches);
                            return $matches[1] ?? null;
                        }
                        
                        private function checkLeadAvailability($domain)
                        {
                            $lead = Lead::where('website', 'LIKE', '%' . $domain . '%')->first();
                            return $lead ? 'Yes' : 'No';
                        }
                
        

}

