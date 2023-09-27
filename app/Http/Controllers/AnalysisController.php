<?php
namespace App\Http\Controllers;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use phpDocumentor\Reflection\Types\Null_;
use Carbon\Carbon;
use Session;
use Auth;
use DataTables;

use App\Lead;
use App\User;
use App\SalesPipeline;
use App\Employees;
use App\Designation;
use App\ExcludeKeywords;
use App\Probability;
use App\Status;
use App\Category;
use App\Possibility;
use App\Country;
use App\Leadassigned;
use App\Possibilitychange;
use App\Callingreport;
use App\Workprogress;
use App\Activities;
use App\Followup;
use App\Leadstatus;
use App\NewCall;
use App\NewFile;

use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SelectedAnalysisCommentsExport;
use App\Exports\LongTimeNoCallExport;
use App\Exports\fredChasingLeadsExport;
use App\Exports\IppListExport;

use Goutte\Client;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\Client as BrowserKitClient;
use Symfony\Component\DomCrawler\Crawler;

use Intervention\Image\Facades\Image;





class AnalysisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function analysisHomePage ()
    {

        return view ('analysis.analysisHome');
    
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
                ->where('leads.statusId', '!=', 6)
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


            return view('analysis.ipp')
                ->with('leads', $leads)
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories',$categories)
                ->with('status',$status)
                ->with('country',$country);
              
        }


        public function exportIppList(){

            $User_Type=Session::get('userType');
            if($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR'){
           
                $leads=Lead::select(
                    'leads.leadId',
                    'leads.companyName',
                    'categories.categoryName as category_name',
                    'leads.website',
                    'countries.countryName as country_name',
                    'leads.contactNumber',
                    'leads.process',
                    'leads.volume',
                    'leads.frequency',
                    'users.userId',
                    'workprogress.created_at'
                    )
                ->leftJoin('workprogress', 'leads.leadId', 'workprogress.leadId')
                ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                ->leftJoin('categories', 'leads.categoryId', 'categories.categoryId')
                ->leftJoin('countries', 'leads.countryId', 'countries.countryId')
                ->leftJoin('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                ->where('leads.ippStatus', 1)
                ->where('leads.statusId', '!=', 6)
                ->groupBy('leads.leadId')
                ->orderBy('workprogress.created_at','desc')
                ->get();
            }else{
            $leads=[];
            }


            $categories=Category::where('type',1)->get();
            $country=Country::get();
            $status=Leadstatus::get();


            $export = new IppListExport($leads, $categories, $country, $status);

            return Excel::download($export, 'IppListExport.csv');
      
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
            return view('analysis.assignedButNotTaken')
            ->with('leads', $leads)
            ->with('callReports', $callReports)
            ->with('possibilities', $possibilities)
            ->with('probabilities', $probabilities)
            ->with('categories',$categories)
            ->with('status',$status)
            ->with('country',$country);

        } else {

            return view ('analysis.analysisHome');
        }


        }


  
        
        //This function finds the leads that have same  phone numbers, websites
        public function getallConversations(){

            $User_Type=Session::get('userType');
            if($User_Type == 'ADMIN' ||  $User_Type == 'SUPERVISOR'){
           
                $leads=Lead::select('leads.*','users.firstName','users.lastName', 'workprogress.created_at as workprogress_created_at')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                ->where('leads.statusId', '!=', 6)
                ->where('leads.statusId', '!=', 8)
                ->where('workprogress.callingReport', 11)
                ->groupBy('leads.leadId')
                ->orderBy('workprogress.created_at','desc')
                ->get();
           
            } else {
           
                $leads=Lead::select('leads.*','users.firstName','users.lastName', 'workprogress.created_at as workprogress_created_at')
                ->leftJoin('workprogress','leads.leadId','workprogress.leadId')
                ->leftJoin('users','leads.contactedUserId','users.id')
                ->where('users.id', Auth::user()->id)
                ->where('leads.statusId', '!=', 6)
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


            return view('analysis.allConversations')
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
                return view('analysis.analysisComments')
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
                $analysis = Lead::select('leads.*', 'users.userId')
                    ->where('leads.contactedUserId', Auth::user()->id)
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
            }
        
            $possibilities = Possibility::get();
            $probabilities = Probability::get();
            $callReports = Callingreport::get();
            $categories = Category::where('type', 1)->get();
            $country = Country::get();
            $status = Leadstatus::get();
        
            return view('analysis.analysisComments')
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
                    return view('analysis.analysisComments')
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

            return view('analysis.frequentlyFiltered', compact('recentLeads'))
                ->with('callReports', $callReports)
                ->with('possibilities', $possibilities)
                ->with('probabilities', $probabilities)
                ->with('categories', $categories)
                ->with('status', $status)
                ->with('country', $country)
                ->with('users', $users);

            } else {

                return view ('analysis.analysisHome');
            }

        }


        public function allActivities(Request $r)
        {

            return view('analysis.activities');

        }

        public function getAllActivities(Request $r)
        {
            $User_Type = Session::get('userType');
            if ($User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR' || $User_Type == 'ADMIN') {
                
                $activities=Activities::Select('activities.activityId', 'users.firstName', 'users.lastName', 'leads.leadId', 'leads.companyName', 'leadstatus.statusName', 'activities.activity','activities.created_at')
                        ->join('users', 'activities.userId', 'users.id')
                        ->where('activities.activity', 'NOT LIKE', '%Table%')
                        ->join('leads', 'activities.leadId', 'leads.leadId')
                        ->join('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                        // ->where('users.active', 1)
                        ->orderBy('activities.activityId', 'desc')
                        // ->latest()->paginate(10000);                      
                        ->get();
    
            } else {

                $activities = Activities::select('activities.activityId', 'users.firstName', 'users.lastName', 'leads.leadId', 'leads.companyName', 'leadstatus.statusName', 'activities.activity', 'activities.created_at')
                    ->join('users', 'activities.userId', 'users.id')
                    ->where('activities.userId', Auth::user()->id)
                    ->where('activities.activity', 'NOT LIKE', '%Table%')
                    ->join('leads', 'activities.leadId', 'leads.leadId')
                    ->join('leadstatus', 'leads.statusId', 'leadstatus.statusId')
                    ->orderBy('activities.activityId', 'DESC')
                    ->get();

                }

                    return DataTables::of($activities)
                        ->toJson();
        
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
        
        
                    return view('analysis.chasingLeads')
                        ->with('leads', $leads)
                        ->with('callReports', $callReports)
                        ->with('possibilities', $possibilities)
                        ->with('probabilities', $probabilities)
                        ->with('categories',$categories)
                        ->with('status',$status)
                        ->with('country',$country);

                     

                }    
    

                public function longTimeNoCall()
                {
                    $possibilities = Possibility::get();
                    $probabilities = Probability::get();
                    $callReports = Callingreport::get();
                    $categories = Category::where('type', 1)->get();
                    $country = Country::get();
                    $status = Leadstatus::get();

                    $outstatus=Leadstatus::where('statusId','!=',7)
                    ->where('statusId','!=',1)
                    ->where('statusId','!=',6)
                    ->get();

            
                return view('analysis.longTimeNoCall')
                    // ->with('leads', $leads)
                    ->with('callReports', $callReports)
                    ->with('possibilities', $possibilities)
                    ->with('probabilities', $probabilities)
                    ->with('categories', $categories)
                    ->with('status', $status)
                    ->with('country', $country)
                    ->with('outstatus', $outstatus);


                }

          
                public function getLongTimeNoCall()
                {
                    $User_Type = Session::get('userType');
                
                    if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR') {

                        $leads = Lead::with('country','category','status','contact','possibility', 'probability')
                            ->select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as workprogress_created_at')
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
                        $leads = Lead::with('country','category','status','contact','possibility', 'probability')
                            ->select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as workprogress_created_at')
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

                            return DataTables::of($leads)
                            ->addColumn('action', function ($lead) {
                                return '<a href="#" class="btn btn-primary btn-sm lead-view-btn"
                                    data-lead-id="'.$lead->leadId.'"><i class="fa fa-eye"></i></a>';
                            })
                            ->toJson();
    
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
            
            
                        return view('analysis.fredChasingLeads')
                            ->with('leads', $leads)
                            ->with('callReports', $callReports)
                            ->with('possibilities', $possibilities)
                            ->with('probabilities', $probabilities)
                            ->with('categories',$categories)
                            ->with('status',$status)
                            ->with('country',$country)
                            ->with('wp',$wp);

                        } else {

                            return view ('analysis.analysisHome');
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
            
                        

                    public function testButNotClosedList(Request $r){
                       
                        $possibilities = Possibility::get();
                        $probabilities = Probability::get();
                        $categories = Category::where('type', 1)->get();
                        $country = Country::get();
                        $status = Leadstatus::get();

                       
                        return view('analysis.testButNotClosedList')
                            // ->with('leads', $leads)
                            ->with('possibilities', $possibilities)
                            ->with('probabilities', $probabilities)
                            ->with('categories', $categories)
                            ->with('status', $status)
                            ->with('country', $country)
                            ;
                    }    


                    public function getTestButNotClosedList()
                    {
                        $User_Type = Session::get('userType');
                    
                        if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR') {
    
                            $leads = Lead::with('country','category','status','contact','possibility', 'probability')
                                ->select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as wp_created_at', 'workprogress.comments as last_comment')
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

                            $leads = Lead::with('country','category','status','contact','possibility', 'probability')
                                ->select('leads.*', 'users.firstName', 'users.lastName', 'workprogress.created_at as wp_created_at', 'workprogress.comments as last_comment')
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
    
                        return DataTables::of($leads)
                        ->addColumn('action', function ($lead) {
                            return '<a href="#" class="btn btn-primary btn-sm lead-view-btn"
                                data-lead-id="'.$lead->leadId.'"><i class="fa fa-eye"></i></a>';
                        })
                        ->toJson();
                    

                    }
                        

                            
                        
                    public function getDuplicateLeads()
                    {
                        $User_Type = Session::get('userType');
                    
                        if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR' || $User_Type == 'MANAGER') {
                            
                            $categoryIdList = [1, 2, 3, 4, 5, 6];
                            $statusIdList = [2, 3, 5, 7];
                            
                            $leads = Lead::select('leads.*', 'users.firstName', 'users.lastName')
                                ->leftJoin('users', 'leads.contactedUserId', 'users.id')
                                // ->where('leads.contactedUserId', '!=', null)
                                ->whereIn('leads.categoryId', $categoryIdList)
                                ->whereIn('leads.statusId', $statusIdList)
                                ->where('leads.website', '<>', '')
                                ->whereIn(DB::raw('(SELECT COUNT(*) FROM leads AS l2 WHERE l2.website = leads.website)'), [2, 3, 4, 5, 6, 7, 8, 9, 10])
                                ->orderBy('leads.companyName', 'ASC')
                                ->get();
                        

                                $possibilities = Possibility::get();
                                $probabilities = Probability::get();
                                $callReports = Callingreport::get();
                                $categories = Category::where('type', 1)->get();
                                $country = Country::get();
                                $status = Leadstatus::get();
                                $users = User::get();

                                
                            return view('analysis.duplicateLeads')
                                ->with('leads', $leads)
                                ->with('callReports', $callReports)
                                ->with('possibilities', $possibilities)
                                ->with('probabilities', $probabilities)
                                ->with('categories', $categories)
                                ->with('status', $status)
                                ->with('country', $country)
                                ->with('users', $users)
                                ;
                        } else {
                            return view('analysis.analysisHome');
                        }
                    }
                                                         
                                                        



            public function randomReports()
            {
                $currentDay = date('N');
                $tillToday = Carbon::today()->toDateString();
                $firstDayOfWeek = date('Y-m-d', strtotime("-" . ($currentDay - 1) . " day"));
                $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
                $firstDayOfYear = Carbon::now()->startOfYear()->toDateString();
            
                //GETTING INDIVIDUAL DATA
                
                $dataWeekly = Workprogress::select(
                    DB::raw('COUNT(progressId) as weeklyOwnCall'),
                    DB::raw('COUNT(CASE WHEN callingReport = 5 THEN progressId END) as weeklyOwnContact'),
                    DB::raw('COUNT(CASE WHEN callingReport = 11 THEN progressId END) as weeklyOwnConvo'),
                    DB::raw('COUNT(CASE WHEN progress LIKE "%Test%" THEN progressId END) as weeklyOwnTest')
                )
                    ->where('userId', Auth::user()->id)
                    ->whereBetween('created_at', [$firstDayOfWeek, $tillToday])
                    ->first();
            
                $dataMonthly = Workprogress::select(
                    DB::raw('COUNT(progressId) as monthlyOwnCall'),
                    DB::raw('COUNT(CASE WHEN callingReport = 5 THEN progressId END) as monthlyOwnContact'),
                    DB::raw('COUNT(CASE WHEN callingReport = 11 THEN progressId END) as monthlyOwnConvo'),
                    DB::raw('COUNT(CASE WHEN progress LIKE "%Test%" THEN progressId END) as monthlyOwnTest')
                )
                    ->where('userId', Auth::user()->id)
                    ->whereBetween('created_at', [$firstDayOfMonth, $tillToday])
                    ->first();

                $dataYearly = Workprogress::select(
                    DB::raw('COUNT(progressId) as totalOwnCall'),
                    DB::raw('COUNT(CASE WHEN callingReport = 5 THEN progressId END) as totalOwnContact'),
                    DB::raw('COUNT(CASE WHEN callingReport = 11 THEN progressId END) as totalOwnConvo'),
                    DB::raw('COUNT(CASE WHEN progress LIKE "%Test%" THEN progressId END) as totalOwnTest')
                )
                    ->where('userId', Auth::user()->id)
                    ->whereBetween('created_at', [$firstDayOfYear, $tillToday])
                    ->first();




                //MAXIMUM SCORES IN CURRENT WEEK
                $maxThisWeekCall = Workprogress::select(DB::raw('COUNT(progressId) as maxThisWeekCall'))
                    ->whereBetween('created_at', [$firstDayOfWeek, $tillToday])
                    ->groupBy('userId')
                    ->orderByDesc('maxThisWeekCall')
                    ->value('maxThisWeekCall');


                $maxThisWeekContact = Workprogress::Select(DB::raw('COUNT(progressId) as maxThisWeekContact'))
                    ->whereBetween('created_at', [$firstDayOfWeek, $tillToday])
                    ->where('callingReport', '=', 5)
                    ->groupBy('userId')
                    ->orderByDesc('maxThisWeekContact')
                    ->value('maxThisWeekContact');

                $maxThisWeekConvo = Workprogress::Select(DB::raw('COUNT(progressId) as maxThisWeekConvo'))
                    ->whereBetween('created_at', [$firstDayOfWeek, $tillToday])
                    ->where('callingReport', '=', 11)
                    ->groupBy('userId')
                    ->orderByDesc('maxThisWeekConvo')
                    ->value('maxThisWeekConvo');

                $maxThisWeekTest = Workprogress::Select(DB::raw('COUNT(progress) as maxThisWeekTest'))
                    ->whereBetween('created_at', [$firstDayOfWeek, $tillToday])
                    ->where('progress', 'like', '%Test%')
                    ->groupBy('userId')
                    ->orderByDesc('maxThisWeekTest')
                    ->value('maxThisWeekTest');

                $maxThisWeekLeadMining = Lead::Select(DB::raw('COUNT(minedBy) as maxThisWeekLeadMining'))
                    ->whereBetween('created_at', [$firstDayOfWeek, $tillToday])
                    ->groupBy('minedBy')
                    ->orderByDesc('maxThisWeekLeadMining')
                    ->value('maxThisWeekLeadMining');



                //MAXIMUM SCORES IN CURRENT MONTH

                $maxThisMonthCall = Workprogress::select(DB::raw('COUNT(progressId) as maxThisMonthCall'))
                    ->whereBetween('created_at', [$firstDayOfMonth, $tillToday])
                    ->groupBy('userId')
                    ->orderByDesc('maxThisMonthCall')
                    ->value('maxThisMonthCall');


                $maxThisMonthContact = Workprogress::Select(DB::raw('COUNT(progressId) as maxThisMonthContact'))
                    ->whereBetween('created_at', [$firstDayOfMonth, $tillToday])
                    ->where('callingReport', '=', 5)
                    ->groupBy('userId')
                    ->orderByDesc('maxThisMonthContact')
                    ->value('maxThisMonthContact');

                $maxThisMonthConvo = Workprogress::Select(DB::raw('COUNT(progressId) as maxThisMonthConvo'))
                    ->whereBetween('created_at', [$firstDayOfMonth, $tillToday])
                    ->where('callingReport', '=', 11)
                    ->groupBy('userId')
                    ->orderByDesc('maxThisMonthConvo')
                    ->value('maxThisMonthConvo');

                $maxThisMonthTest = Workprogress::Select(DB::raw('COUNT(progress) as maxThisMonthTest'))
                    ->whereBetween('created_at', [$firstDayOfMonth, $tillToday])
                    ->where('progress', 'like', '%Test%')
                    ->groupBy('userId')
                    ->orderByDesc('maxThisMonthTest')
                    ->value('maxThisMonthTest');

                $maxThisMonthLeadMining = Lead::Select(DB::raw('COUNT(minedBy) as maxThisMonthLeadMining'))
                    ->whereBetween('created_at', [$firstDayOfMonth, $tillToday])
                    ->groupBy('minedBy')
                    ->orderByDesc('maxThisMonthLeadMining')
                    ->value('maxThisMonthLeadMining');



                //MAXIMUM SCORES IN CURRENT YEAR
                $maxTotalCall = Workprogress::Select(DB::raw('COUNT(progressId) as maxTotalCall'))
                    ->whereBetween('created_at', [$firstDayOfYear, $tillToday])
                    ->groupBy('userId')
                    ->orderByDesc('maxTotalCall')
                    ->value('maxTotalCall');

                $maxTotalContact = Workprogress::Select(DB::raw('COUNT(progressId) as maxTotalContact'))
                    ->whereBetween('created_at', [$firstDayOfYear, $tillToday])
                    ->where('callingReport', '=', 5)
                    ->groupBy('userId')
                    ->orderByDesc('maxTotalContact')
                    ->value('maxTotalContact');

                $maxTotalConvo = Workprogress::Select(DB::raw('COUNT(progressId) as maxTotalConvo'))
                    ->whereBetween('created_at', [$firstDayOfYear, $tillToday])
                    ->where('callingReport', '=', 11)
                    ->groupBy('userId')
                    ->orderByDesc('maxTotalConvo')
                    ->value('maxTotalConvo');

                $maxTotalTest = Workprogress::Select(DB::raw('COUNT(progress) as maxTotalTest'))
                    ->whereBetween('created_at', [$firstDayOfYear, $tillToday])
                    ->where('progress', 'like', '%Test%')
                    ->groupBy('userId')
                    ->orderByDesc('maxTotalTest')
                    ->value('maxTotalTest');

                $maxTotalLeadMining = Lead::Select(DB::raw('COUNT(minedBy) as maxTotalLeadMining'))
                    ->whereBetween('created_at', [$firstDayOfYear, $tillToday])
                    ->groupBy('minedBy')
                    ->orderByDesc('maxTotalLeadMining')
                    ->value('maxTotalLeadMining');

            
                $jsonResponse = $this->chasingCategories(); 
                $showCategories = json_decode($jsonResponse->getContent(), true);

                $showRandomStatistics = $this->randomStatistics(); 
                // $showJoiningDate = $showRandomStatistics ['joiningDate'];
                // $showClientNumber = $showRandomStatistics ['myClients'];



                return view('analysis.randomReports', [
                    'totalOwnCall' => $dataYearly->totalOwnCall,
                    'totalOwnContact' => $dataYearly->totalOwnContact,
                    'totalOwnConvo' => $dataYearly->totalOwnConvo,
                    'totalOwnTest' => $dataYearly->totalOwnTest,
            
                    'callToContact' => ($dataYearly->totalOwnCall != 0) ? ($dataYearly->totalOwnContact / $dataYearly->totalOwnCall) * 100 : 0,
                    'callToConvo' => ($dataYearly->totalOwnCall != 0) ? ($dataYearly->totalOwnConvo / $dataYearly->totalOwnCall) * 100 : 0,
                    'callToTest' => ($dataYearly->totalOwnCall != 0) ? ($dataYearly->totalOwnTest / $dataYearly->totalOwnCall) * 100 : 0,
                    'contactToTest' => ($dataYearly->totalOwnContact != 0) ? ($dataYearly->totalOwnTest / $dataYearly->totalOwnContact) * 100 : 0,
                    'convoToTest' => ($dataYearly->totalOwnConvo != 0) ? ($dataYearly->totalOwnTest / $dataYearly->totalOwnConvo) * 100 : 0,
            
                    'monthlyOwnCall' => $dataMonthly->monthlyOwnCall,
                    'monthlyOwnContact' => $dataMonthly->monthlyOwnContact,
                    'monthlyOwnConvo' => $dataMonthly->monthlyOwnConvo,
                    'monthlyOwnTest' => $dataMonthly->monthlyOwnTest,

                    'callToContactWeekly' => ($dataMonthly->monthlyOwnCall != 0) ? ($dataMonthly->monthlyOwnContact / $dataMonthly->monthlyOwnCall) * 100 : 0,
                    'callToConvoWeekly' => ($dataMonthly->monthlyOwnCall != 0) ? ($dataMonthly->monthlyOwnConvo / $dataMonthly->monthlyOwnCall) * 100 : 0,
                    'callToTestWeekly' => ($dataMonthly->monthlyOwnCall != 0) ? ($dataMonthly->monthlyOwnTest / $dataMonthly->monthlyOwnCall) * 100 : 0,
                    'contactToTestWeekly' => ($dataMonthly->monthlyOwnContact != 0) ? ($dataMonthly->monthlyOwnTest / $dataMonthly->monthlyOwnContact) * 100 : 0,
                    'convoToTestWeekly' => ($dataMonthly->monthlyOwnConvo != 0) ? ($dataMonthly->monthlyOwnTest / $dataMonthly->monthlyOwnConvo) * 100 : 0,

                    'weeklyOwnCall' => $dataWeekly->weeklyOwnCall,
                    'weeklyOwnContact' => $dataWeekly->weeklyOwnContact,
                    'weeklyOwnConvo' => $dataWeekly->weeklyOwnConvo,
                    'weeklyOwnTest' => $dataWeekly->weeklyOwnTest,

                    'callToContactMonthly' => ($dataWeekly->weeklyOwnCall != 0) ? ($dataWeekly->weeklyOwnContact / $dataWeekly->weeklyOwnCall) * 100 : 0,
                    'callToConvoMonthly' => ($dataWeekly->weeklyOwnCall != 0) ? ($dataWeekly->weeklyOwnConvo / $dataWeekly->weeklyOwnCall) * 100 : 0,
                    'callToTestMonthly' => ($dataWeekly->weeklyOwnCall != 0) ? ($dataWeekly->weeklyOwnTest / $dataWeekly->weeklyOwnCall) * 100 : 0,
                    'contactToTestMonthly' => ($dataWeekly->weeklyOwnContact != 0) ? ($dataWeekly->weeklyOwnTest / $dataWeekly->weeklyOwnContact) * 100 : 0,
                    'convoToTestMonthly' => ($dataWeekly->weeklyOwnConvo != 0) ? ($dataWeekly->weeklyOwnTest / $dataWeekly->weeklyOwnConvo) * 100 : 0,

                    'maxThisWeekCall' => $maxThisWeekCall,
                    'maxThisWeekContact' => $maxThisWeekContact,
                    'maxThisWeekConvo' => $maxThisWeekConvo,
                    'maxThisWeekTest' => $maxThisWeekTest,
                    'maxThisWeekLeadMining' => $maxThisWeekLeadMining,
            
                    'maxThisMonthCall' => $maxThisMonthCall,
                    'maxThisMonthContact' => $maxThisMonthContact,
                    'maxThisMonthConvo' => $maxThisMonthConvo,
                    'maxThisMonthTest' => $maxThisMonthTest,
                    'maxThisMonthLeadMining' => $maxThisMonthLeadMining,
            
                    'maxTotalCall' => $maxTotalCall,
                    'maxTotalContact' => $maxTotalContact,
                    'maxTotalConvo' => $maxTotalConvo,
                    'maxTotalTest' => $maxTotalTest,
                    'maxTotalLeadMining' => $maxTotalLeadMining,

                    'showCategories' => $showCategories,
                    'showRandomStatistics' => $showRandomStatistics
                    

                ]);
            }

            
          

                        public function chasingCategories()
                        {
                            
                            $categoryIds = [1, 4, 5, 66, 63, 74];
                            $categoryNames = ['Agency', 'Online Store', 'Brand', 'Jewelry', 'Boutique', 'Furniture'];
                            
                            $chasingCounts = Lead::where('leads.contactedUserId', Auth::user()->id)
                                ->whereIn('leads.categoryId', $categoryIds)
                                ->selectRaw('categoryId, COUNT(leadId) as count')
                                ->groupBy('categoryId')
                                ->get();
                        
                            $result = [];
                        
                            foreach ($chasingCounts as $count) {
                                $categoryIndex = array_search($count->categoryId, $categoryIds);
                                if ($categoryIndex !== false) {
                                    $categoryName = $categoryNames[$categoryIndex];
                                    $result[$categoryName] = $count->count;
                                }
                            }
                            
                            return response()->json($result);
                        }



                        public function randomStatistics(){

                            $joiningDate = User::where('id', Auth::user()->id)
                                ->value('created_at'); 
                        
                            $myClients = NewFile::where('userId', Auth::user()->id)
                                ->selectRaw('COUNT(DISTINCT leadId) as clientCount')
                                ->value('clientCount');
                        
                            $myTests = Workprogress::where('userId', Auth::user()->id)
                                ->where('progress', 'LIKE', '%Test%')
                                ->selectRaw('COUNT(DISTINCT leadId) as clientCount')
                                ->value('clientCount');

                            $joiningDate = Carbon::parse($joiningDate);
                            $today = Carbon::now();
                            $timeDifference = $joiningDate->diffForHumans($today);

                            return [
                                'joiningDate' => $joiningDate,
                                'myClients' => $myClients,
                                'myTests' => $myTests,
                                'timeDifference' => $timeDifference,
                            ];
                            
                        }








            public function randomReportsAll () {

                $User_Type = Session::get('userType');
                            
                if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR' || $User_Type == 'MANAGER') {

                    $fromDay = Carbon::now()->startOfYear();
                    $tillToday = Carbon::today()->toDateString();
                    $users = User::get()->where('crmType', '!=', 'local')->where('active', '1');

                    $clientAnalysis = $this->closedDealsAnalysis(); 
                    $clientCategoryCounts = $clientAnalysis['categoryCounts'];
                    $totalClinetCounts = $clientAnalysis['totalCount'];

                    
                    foreach ($users as $user) {
                        $user->totalOwnCall = Workprogress::Select(DB::raw('COUNT(progressId) as totalOwnCall'))
                            ->where('userId', $user->id)
                            ->whereBetween('created_at', [$fromDay, $tillToday])
                            ->value('totalOwnCall');
                    
                        $user->totalOwnContact = Workprogress::Select(DB::raw('COUNT(progressId) as totalOwnContact'))
                            ->where('userId', $user->id)
                            ->whereBetween('created_at', [$fromDay, $tillToday])
                            ->where('callingReport', '=', 5)
                            ->value('totalOwnContact');
                    
                        $user->totalOwnConvo = Workprogress::Select(DB::raw('COUNT(progressId) as totalOwnConvo'))
                            ->where('userId', $user->id)
                            ->whereBetween('created_at', [$fromDay, $tillToday])
                            ->where('callingReport', '=', 11)
                            ->value('totalOwnConvo');
                    
                        $user->totalOwnTest = Workprogress::Select(DB::raw('COUNT(progress) as totalOwnTest'))
                            ->where('progress', 'like', '%Test%')
                            ->whereBetween('created_at', [$fromDay, $tillToday])
                            ->where('userId', $user->id)
                            ->value('totalOwnTest');
                    
                        $user->callToContact = 0;
                        $user->callToConvo = 0;
                        $user->callToTest = 0;
                        $user->contactToTest = 0;
                        $user->convoToTest = 0;
                    
                        if ($user->totalOwnCall != 0) {
                            $user->callToContact = ($user->totalOwnContact / $user->totalOwnCall) * 100;
                            $user->callToConvo = ($user->totalOwnConvo / $user->totalOwnCall) * 100;
                            $user->callToTest = ($user->totalOwnTest / $user->totalOwnCall) * 100;
                        }
                    
                        if ($user->totalOwnContact != 0) {
                            $user->contactToTest = ($user->totalOwnTest / $user->totalOwnContact) * 100;
                        }
                    
                        if ($user->totalOwnConvo != 0) {
                            $user->convoToTest = ($user->totalOwnTest / $user->totalOwnConvo) * 100;
                        }
                    }


                    $totalCallYearly= Workprogress::Select(DB::raw('COUNT(progressId) as totalYearlyCall'))
                        ->whereBetween('created_at', [$fromDay, $tillToday])
                        ->value('totalYearlyCall');

                    $totalContactYearly= Workprogress::Select(DB::raw('COUNT(progressId) as totalYearlyContact'))
                        ->whereBetween('created_at', [$fromDay, $tillToday])
                        ->where('callingReport', '=', 5)
                        ->value('totalYearlyContact');

                    $totalConvoYearly= Workprogress::Select(DB::raw('COUNT(progressId) as totalYearlyConvo'))
                        ->whereBetween('created_at', [$fromDay, $tillToday])
                        ->where('callingReport', '=', 11)
                        ->value('totalYearlyConvo');

                    $totalTestYearly =  Workprogress::Select(DB::raw('COUNT(progress) as totalYearlyTest'))
                        ->where('progress', 'like', '%Test%')
                        ->whereBetween('created_at', [$fromDay, $tillToday])
                        ->value('totalYearlyTest');

                    $totalClosingYearly = Workprogress::Select(DB::raw('COUNT(progress) as totalYearlyClosing'))
                        ->where('progress', 'like', '%Closing%')
                        ->whereBetween('created_at', [$fromDay, $tillToday])
                        ->value('totalYearlyClosing');

                    $totalLeadMiningYearly = Lead::Select(DB::raw('COUNT(leadId) as totalYearlyLeadMining'))
                        ->whereBetween('created_at', [$fromDay, $tillToday])
                        ->value('totalYearlyLeadMining');


                    $jsonResponse = $this->chasingCategoriesAll(); 
                    $showCategories = json_decode($jsonResponse->getContent(), true);
    
                    $jsonResponseYearlyStat = $this->getYearlyStats(); 
                    $showYearlyStat = json_decode($jsonResponseYearlyStat->getContent(), true);


                    return view('analysis.randomReportsAll')
                            ->with('users', $users)
                            ->with('clientCategoryCounts', $clientCategoryCounts)
                            ->with('totalClinetCounts', $totalClinetCounts)
                            ->with('showCategories', $showCategories)
                            ->with('showYearlyStat', $showYearlyStat)
                            ;


                } else {

                    return view('analysis.analysisHome');
                }


            }


                    public function chasingCategoriesAll()
                    {
                        
                        $categoryIds = [1, 4, 5, 66, 63, 74];
                        $categoryNames = ['Agency', 'Online Store', 'Brand', 'Jewelry', 'Boutique', 'Furniture'];
                        
                        $chasingCounts = Lead::where('leads.contactedUserId', '!=' , Null)
                            ->whereIn('leads.categoryId', $categoryIds)
                            ->selectRaw('categoryId, COUNT(leadId) as count')
                            ->groupBy('categoryId')
                            ->get();
                    
                        $result = [];
                    
                        foreach ($chasingCounts as $count) {
                            $categoryIndex = array_search($count->categoryId, $categoryIds);
                            if ($categoryIndex !== false) {
                                $categoryName = $categoryNames[$categoryIndex];
                                $result[$categoryName] = $count->count;
                            }
                        }
                        
                        return response()->json($result);
                    }


                    public function getYearlyStats()
                    {
                        $fromDay = Carbon::now()->startOfYear();
                        $tillToday = Carbon::today()->toDateString();
                    
                        $totalCallYearly = Workprogress::whereBetween('created_at', [$fromDay, $tillToday])->count();
                        $totalContactYearly = Workprogress::whereBetween('created_at', [$fromDay, $tillToday])
                            ->where('callingReport', '=', 5)
                            ->count();
                        $totalConvoYearly = Workprogress::whereBetween('created_at', [$fromDay, $tillToday])
                            ->where('callingReport', '=', 11)
                            ->count();
                        $totalTestYearly = Workprogress::where('progress', 'like', '%Test%')
                            ->whereBetween('created_at', [$fromDay, $tillToday])
                            ->count();
                        $totalClosingYearly = Workprogress::where('progress', 'like', '%Closing%')
                            ->whereBetween('created_at', [$fromDay, $tillToday])
                            ->count();
                        $totalLeadMiningYearly = Lead::whereBetween('created_at', [$fromDay, $tillToday])->count();
                    
                        $result = [
                            'totalYearlyCall' => $totalCallYearly,
                            'totalYearlyContact' => $totalContactYearly,
                            'totalYearlyConvo' => $totalConvoYearly,
                            'totalYearlyTest' => $totalTestYearly,
                            'totalYearlyClosing' => $totalClosingYearly,
                            'totalYearlyLeadMining' => $totalLeadMiningYearly,
                        ];
                    
                        return response()->json($result);
                    }


                    public function closedDealsAnalysis()
                    {
                        $categoryCounts = Lead::with('category')
                            ->select('categoryId', DB::raw('COUNT(*) as count'))
                            ->where('statusId', 6)
                            ->groupBy('categoryId')
                            ->get();

                        $totalCount = $categoryCounts->sum('count');

                        return ['categoryCounts' => $categoryCounts, 'totalCount' => $totalCount];
                    }

       


            public function myHourReport(Request $r)
            {
                $User_Type = Session::get('userType');
                if ($User_Type == 'USER' || $User_Type == 'MANAGER' || $User_Type == 'SUPERVISOR') {
                    $selectedDay = date('Y-m-d'); // or use $r->selectedDay if available
                    $userId = Auth::user()->id; // Get the logged-in user's ID
                    
                    $wp = User::where('id', Auth::user()->id)->select('id', 'userId')->get();
                    $work = collect(DB::select(DB::raw("SELECT userId as userid, time(created_at) as createtime FROM workprogress WHERE date(created_at) = '" . $selectedDay . "' AND userId = " . $userId)));
            
                    // Find the values with the lowest and highest differences
                    $highlightedTimes = [];
                    $highlightedTimesMax = [];
                    $previousTime = null;
                    foreach ($work as $entry) {
                        $currentTime = strtotime($entry->createtime);
                        if ($previousTime !== null) {
                            $timeDiff = abs($currentTime - $previousTime) / 60; // Difference in minutes
                            if ($timeDiff <= 1) { // Two minutes or less
                                $highlightedTimes[] = $entry->createtime;
                            } elseif ($timeDiff >= 15) { // Fifteen minutes or more
                                $highlightedTimesMax[] = $entry->createtime;
                            }
                        }
                        $previousTime = $currentTime;
                    }
            
                    return view('analysis.myHourReport', compact('work', 'wp', 'highlightedTimes', 'highlightedTimesMax'));
                }
            }
              
            


            public function customHourReport()
            {
                $users = User::select('id','firstName')->where('active', 1)->where('typeId', 5)->get();
    
                $startDate = Carbon::now()->subMonths(2);
                $endDate = Carbon::now();
    
                $activityData = WorkProgress::whereBetween('created_at', [$startDate, $endDate])
                    ->get();
    
                $hourlyActivityData = [];
    
                foreach ($activityData as $activity) {
                    $userId = $activity->userId;
                    $hour = Carbon::parse($activity->created_at)->hour;
    
                    if (!isset($hourlyActivityData[$hour][$userId])) {
                        $hourlyActivityData[$hour][$userId] = 0;
                    }
    
                    $hourlyActivityData[$hour][$userId]++;
                }
    
    
                $userMaxValues = [];
    
                foreach ($hourlyActivityData as $hour => $userData) {
                    foreach ($userData as $userId => $activityCount) {
                        if (!isset($userMaxValues[$userId]) || $activityCount > $userMaxValues[$userId]) {
                            $userMaxValues[$userId] = $activityCount;
                        }
                    }
                }
    
                    
                return view('analysis.customHourReport', compact('users', 'hourlyActivityData', 'userMaxValues'));
            }
       


            public function followUpAnalysis ()
            {

                    return view('analysis.followUpAnalysis');
            }


            public function getFollowUpAnalysis(Request $request)
            {

                $User_Type = Session::get('userType');
                
                if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR') {

                $followUpData = Followup::select('followup.*', 'leads.companyName', 'leads.website', 'leads.contactNumber', 'leads.contactedUserId', 'users.firstName', 'users.lastName', 'users.id' ) 
                        ->leftJoin('leads', 'followup.leadId', 'leads.leadId')
                        ->leftJoin('users', 'followup.userId', 'users.id')
                        ->where('followup.workStatus', 0)
                        ->orderBy('followup.followUpDate', 'DESC')             
                        ->get();

                } else {

                    $followUpData = [];
                }

                
                return DataTables::of($followUpData)
                ->addColumn('currentMarketer', function ($followUpData) {
                    if ($followUpData->contactedUserId) {
                        $currentMarketer = User::find($followUpData->contactedUserId);
                        return $currentMarketer ? $currentMarketer->firstName : '';
                    }
                    return '';
                })
                ->addColumn('action', function ($followUpData) {
                    return '<a href="#" class="btn btn-primary btn-sm lead-view-btn"
                        data-lead-id="'.$followUpData->leadId.'"><i class="fa fa-eye"></i></a>';
                })
                ->toJson();

            }
         


            public function updateFollwoUpWorkStatus(Request $request)
            {
                try {
                    $followId = $request->input('followId');
            
                    // Assuming you have a Followup model with a 'workStatus' field
                    $followup = Followup::find($followId);
            
                    if (!$followup) {
                        return response()->json(['success' => false, 'message' => 'Followup not found']);
                    }
            
                    // Update the workStatus to 1
                    $followup->workStatus = 1;
                    $followup->save();
            
                    return response()->json(['success' => true, 'message' => 'Work status updated successfully']);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'message' => $e->getMessage()]);
                }
            }
            



            public function graphicalPresentation()
            {
                $userType = Session::get('userType');
            
                if ($userType == 'ADMIN' || $userType == 'SUPERVISOR') {
                    $users = User::orderby('firstName', 'asc')->get();
            
                    return view('analysis.graphs')
                        ->with('users', $users);
                }
            }
            
            
            public function getUserDataPeriod(Request $request)
            {
                $userId = $request->input('marketer');
                $progressParam = $request->input('progress');
                $fromDate = $request->input('fromDate');
                $toDate = $request->input('toDate');
            
                $fromDate = Carbon::parse($fromDate);
                $toDate = Carbon::parse($toDate);
            
                // Initialize an array to store day-wise progress data
                $progressData = [];
            
                // Loop through each day within the selected range
                while ($fromDate->lte($toDate)) {
                    // Query the database to count progress records for the specific user and parameter for the current day
                    $progressCounter = DB::table('workprogress')
                        ->where('userId', $userId)
                        ->whereDate('created_at', '=', $fromDate->format('Y-m-d'));
            
                    $followupCounter = DB::table('followup')
                        ->where('userId', $userId)
                        ->whereDate('created_at', '=', $fromDate->format('Y-m-d'));

                    $leadMiningCounter = Lead::where('minedBy', $userId)
                        ->whereDate('created_at', '=', $fromDate->format('Y-m-d'));


                        // Add additional conditions based on the selected parameter
                    if ($progressParam === 'totalcall') {
                        // Logic for total call
                    } elseif ($progressParam === 'contact') {
                        $progressCounter->where('callingReport', '5'); 
                    } elseif ($progressParam === 'conversation') {
                        $progressCounter->where('callingReport', '11'); 
                    } elseif ($progressParam === 'test') {
                        $progressCounter->where('progress', 'LIKE', '%Test%'); 
                    } elseif ($progressParam === 'closing') {
                        $progressCounter->where('progress', 'LIKE', '%Closing%'); 
                    } elseif ($progressParam === 'followup') {
                        $progressCounter = $followupCounter; 
                    } elseif ($progressParam === 'leadmining') {
                        $progressCounter = $leadMiningCounter; 
                    }
            
                    // Count the progress records for the current day
                    $progressCount = $progressCounter->count();
            
                    // Add the count to the progressData array along with the formatted date
                    $progressData[] = [
                        'date' => $fromDate->format('d M y'), // Format the date as '12 Sep 23'
                        'count' => $progressCount,
                    ];
            
                    // Move to the next day
                    $fromDate->addDay();
                }
            
                return $progressData;

            }
            




            public function personalAnalysis()
            {
                $userType = Session::get('userType');
            
                if ($userType == 'ADMIN' || $userType == 'SUPERVISOR') {
                    
                    $users = User::orderby('firstName', 'asc')->get();
            
                    return view('analysis.personalAnalysis')
                        ->with('users', $users);
                }
            }
            
            
            public function getPersonalAnalysis(Request $request)
            {
                // Retrieve the selected values from the request
                $marketerId = $request->input('marketer');
                $fromDate = $request->input('fromDate');
                $toDate = $request->input('toDate');


                // These variables will be used in multiple places
                $workingDays = DB::table('workprogress')
                    ->select(DB::raw('COUNT(DISTINCT DATE(created_at)) as count'))
                    ->where('userId', $marketerId)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->first();

                $workingDaysCount = $workingDays->count;


                // Get all updates regarding CALLs
                $totalCall = Workprogress::where('userId', $marketerId)
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->select('leadId')
                    ->count();
                $lowlead = Workprogress::where('userId', $marketerId)
                    ->where('possibilityId', 1)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->leftjoin('leads','leads.leadId', 'workprogress.leadId')
                    ->select('leadId')
                    ->count();
                $mediumlead = Workprogress::where('userId', $marketerId)
                    ->where('possibilityId', 2)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->leftjoin('leads','leads.leadId', 'workprogress.leadId')
                    ->select('leadId')
                    ->count();
                $highlead = Workprogress::where('userId', $marketerId)
                    ->where('possibilityId', 3)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->leftjoin('leads','leads.leadId', 'workprogress.leadId')
                    ->select('leadId')
                    ->count();

                $totalcontact = Workprogress::where('userId', $marketerId)
                    ->where('callingReport', 5)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->select('leadId')
                    ->count();

                $contactcountry =DB::table('workprogress')
                    ->select(DB::raw('COUNT(workprogress.leadId) as totalcontact'), 'countries.countryName as countryName')
                    ->leftJoin('leads', 'leads.leadId', '=', 'workprogress.leadId')
                    ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
                    ->where('callingReport', 5)
                    ->where('userId', $marketerId)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->groupBy('leads.countryId')
                    ->orderBy('totalcontact', 'DESC')
                    ->limit(1)
                    ->get();

                $totalconversation = Workprogress::where('userId', $marketerId)
                    ->where('callingReport', 11)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->select('leadId')
                    ->count();

                $conversationcountry =DB::table('workprogress')
                    ->select(DB::raw('COUNT(workprogress.leadId) as totalcontact'), 'countries.countryName as countryName')
                    ->leftJoin('leads', 'leads.leadId', '=', 'workprogress.leadId')
                    ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
                    ->where('callingReport', 11)
                    ->where('userId', $marketerId)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->groupBy('leads.countryId')
                    ->orderBy('totalcontact', 'DESC')
                    ->limit(1)
                    ->get();

                $totalfollowup = Workprogress::where('userId', $marketerId)
                    ->where('callingReport', 4)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->select('leadId')
                    ->count();

                $followupcountry =DB::table('workprogress')
                    ->select(DB::raw('COUNT(workprogress.leadId) as totalcontact'), 'countries.countryName as countryName')
                    ->leftJoin('leads', 'leads.leadId', '=', 'workprogress.leadId')
                    ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
                    ->where('callingReport', 4)
                    ->where('userId', $marketerId)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->groupBy('leads.countryId')
                    ->orderBy('totalcontact', 'DESC')
                    ->limit(1)
                    ->get();

                $totalgatekeepers  = Workprogress::where('userId', $marketerId)
                    ->where('callingReport', 9)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->select('leadId')
                    ->count();

                $gatekeeperscountry =DB::table('workprogress')
                    ->select(DB::raw('COUNT(workprogress.leadId) as totalcontact'), 'countries.countryName as countryName')
                    ->leftJoin('leads', 'leads.leadId', '=', 'workprogress.leadId')
                    ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
                    ->where('callingReport', 9)
                    ->where('userId', $marketerId)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->groupBy('leads.countryId')
                    ->orderBy('totalcontact', 'DESC')
                    ->limit(1)
                    ->get();

                $totalunavailable  = Workprogress::where('userId', $marketerId)
                    ->where('callingReport', 2)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->select('leadId')
                    ->count();

                $unavailablecountry =DB::table('workprogress')
                    ->select(DB::raw('COUNT(workprogress.leadId) as totalcontact'), 'countries.countryName as countryName')
                    ->leftJoin('leads', 'leads.leadId', '=', 'workprogress.leadId')
                    ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
                    ->where('callingReport', 2)
                    ->where('userId', $marketerId)
                    ->whereBetween('workprogress.created_at', [$fromDate, $toDate])
                    ->groupBy('leads.countryId')
                    ->orderBy('totalcontact', 'DESC')
                    ->limit(1)
                    ->get();

                $averageCall = 0; 

                $highestCall = 0; //also add the date

                $lowestCall = 0; // also add the date 

                $peakHour = 0; //get the total call divided by hours of each day


                $busiestDay = 0; //Day and number of total calls at that day

                $slowestDay = 0 ; //Day and number of total calls at that day



                //Get all updates regarding CONVERSATIONS
                $conversationHighLead = 0;

                $conversationMedumLead = 0;

                $conversationLowLead = 0;

                $highestConvoCountry = 0;

                $lowestConvoCountry = 0;

                $missingInfoInConvo = 0; //need the leads name where either process or frequency or volume is missing

                $avgAttemptsInConvo = 0; //we will check how many times the user appears in the workprogress table for those leadId that have coversation and get the average(total attempts / total leadId)


                //Get all updates regarding FOLLOWUPS









                //Get all updates regarding TESTS










                
                
                //Get all updates regarding CLOSINGS









                //Get all updates regarding LEAD MINING









                //Get the CURRENT STATUS
                





                


                // Prepare the data to be returned as JSON
                $data = [
                    'workingDaysCount' => $workingDaysCount,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,
                    'totalCall' => $totalCall,
                    'lowlead' => $lowlead,
                    'mediumlead' => $mediumlead,
                    'highlead' => $highlead,
                    'totalcontact' => $totalcontact,
                    'contactcountry' => $contactcountry[0]->countryName,
                    'totalconversation' => $totalconversation,
                    'conversationcountry' => $conversationcountry[0]->countryName,
                    'totalfollowup' => $totalfollowup,
                    'followupcountry' => $followupcountry[0]->countryName,
                    'totalgatekeepers' => $totalgatekeepers,
                    'gatekeeperscountry' => $gatekeeperscountry[0]->countryName,
                    'totalunavailable' => $totalunavailable,
                    'unavailablecountry' => $unavailablecountry[0]->countryName,

                    // Add other calculated values here
                ];

                // Return the data as JSON
                return response()->json($data);
            }






            


        //THIS FUNCTION BELONGS TO MINING FOLDER. BUT NOT TRANSFERRING DUE TO DEPENDENCIES
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
    
                // $excludedKeywords = ExcludeKeywords::pluck('designationName')->toArray();
                
                // $excludedQuery = '';
                // foreach ($excludedKeywords as $keyword) {
                //     $excludedQuery .= ' -' . $keyword;
                // }
            

                // Array of excluded keywords
                $excludedKeywords = [
                    'soundcloud', 'medium', 'nytimes', 'yelp', 'facebook', 'pinterest', 'instagram', 'wikipedia',
                    'walmart', 'nike', 'next', 'quora', 'reddit', 'Louis Vuitton', 'Gucci', 'Chanel', 'Adidas',
                    'Hermès', 'Zara', 'H&M', 'Cartier', 'uniqlo', 'gap', 'amazon', 'schiesser', 'wolfordshop',
                    'jbc', 'lolaliza', 'xandres', 'mayerline', 'essentiel-antwerp', 'bellerose', 'zeb', 'riverwoods',
                    'belloya', 'terrebleue', 'vila', 'pieces', 'noisymay', 'selected', 'only', 'veromoda', 'jackjones',
                    'mamalicious', 'mosscopenhagen', 'masai', 'parttwo', 'samsoe', 'baumundpferdgarten', 'gestuz',
                    'marimekko', 'lindex', 'ivanahelsinki', 'aboutyou', 'zalando', 'edited', 'mango', 'reserved',
                    'pimkie', 'asos', 'bershka', 'pullandbear', 'weekday', 'monki', 'stories', 'bonprix', 'veromoda',
                    'esprit', 'orsay', 'newyorker', 'snipes', 'engelhorn', 'soliver', 'cecil', 'gerryweber',
                    'vanlaack', 'richandroyal', 'zero', 'oneills', 'ovs', 'calzedonia', 'tezenis', 'carpisa',
                    'alcott', 'motivi', 'stradivarius', 'bershka', 'pullandbear', 'benetton', 'liujo', 'sisley',
                    'calliope', 'intimissimi', 'yamamay', 'goldenpoint', 'subdued', 'freddy', 'terranovastyle',
                    'steps', 'shoeby', 'msmode', 'riverisland', 'veromoda', 'jackjones', 'only', 'promiss',
                    'expresso', 'costesfashion', 'sandwichfashion', 'claudiastrater', 'wefashion', 'paprika',
                    'reserved', 'mohito', 'housebrand', 'cropp', 'desigual', 'spf', 'bershka', 'pullandbear',
                    'stradivarius', 'mango', 'adolfodominguez', 'amichi', 'womensecret', 'scalpers', 'tendam',
                    'pullandbear', 'bimbaylola', 'oysho', 'uterque', 'ginatricot', 'weekday', 'monki', 'stories',
                    'lindex', 'cubus', 'kappahl', 'oddmolly', 'acnestudios', 'jlindeberg', 'nudiejeans', 'bjornborg',
                    'missyempire', 'inthestyle', 'isawitfirst', 'rebelliousfashion', 'femmeluxefinery', 'nastygal',
                    'ohpolly', 'silkfred', 'pinkboutique', 'selectfashion', 'isawitfirst', 'romanoriginals',
                    'littlewoods', 'chichiclothing', 'goddiva', 'wantthattrend', 'foreverunique', 'rarelondon',
                    'nobodyschild', 'axparis', 'apricotonline', 'school', 'college', 'varsity', 'education', 'government',
                    'statista', 'similarweb', 'diesel', 'dior', 'hugoboss', 'moncler', 'ray-ban', 'jewelry', 'Jewellery',
                    'USA', 'Switzerland', 'Norway','India','China','Hong Kong','Canada','Brazil', 'Africa', 'Nigeria', 
                    'Ghana', 'South Africa', 'New York', 'Massachusetts', 'Washington', 'California', 'North Dakota', 
                    'Connecticut', 'Delaware', 'Alaska', 'Nebraska', 'Illinois', 'Florida', 'linkedin', 'article', 'blog',
                    'course', 'hospital', 'medicine', 'porn', 'tiktok'

                ];

                // Convert the excluded keywords array into a string
                $excludedQuery = '';
                foreach ($excludedKeywords as $keyword) {
                    $excludedQuery .= ' -' . $keyword;
                }

                // $excludedRegions = ['USA', 'Switzerland', 'Norway','India','China','Hong Kong','Canada','Brazil', 'Africa', 
                // 'Nigeria', 'Ghana', 'South Africa','NY','MA','WA','CA','ND','CT','DE','AK','NE','IL','FL'];
                // $excludedRegionsQuery = '';
                // foreach ($excludedRegions as $region) {
                //     $excludedRegionsQuery .= ' -site:' . $region . '.*';
                // }
              

                // Add excluded file types
                $excludedFileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
                $excludedFileTypesQuery = '';
                foreach ($excludedFileTypes as $fileType) {
                    $excludedFileTypesQuery .= ' -filetype:' . $fileType;
                }

                // Build the full search query
                // $fullSearchQuery = $searchTerm . ' ' . $country . $excludedQuery . $excludedRegionsQuery . $excludedFileTypesQuery;
                $searchTerm = $searchTerm . ' ' . $country; 
                $fullSearchQuery = $searchTerm . $excludedQuery . $excludedFileTypesQuery;


                $results = [];
    
                for ($start = 1; $start <= 50; $start += 10) {
                    $parameters = [
                        'start' => $start,
                        'num' => 10,
                    ];
    
                    $fulltext = new LaravelGoogleCustomSearchEngine(); // initialize the plugin
                    $fulltext->setEngineId($engineKey); // gets the engine ID
                    $fulltext->setApiKey($apiKey); // gets the API key

                    // Modify the search query to include excluded keywords, regions, and file types
                    // $partialResults = $fulltext->getResults($searchTerm . $excludedQuery . $excludedRegionsQuery . $excludedFileTypesQuery, $parameters);

                    $partialResults = $fulltext->getResults($fullSearchQuery, $parameters);

                    // $partialResults = $fulltext->getResults($searchTerm . $excludedQuery . $excludedRegionsQuery, $parameters); // Exclude the specified keywords and regions from the search query
    
                    // Extract the domain from each search result URL
                    foreach ($partialResults as $result) {
                        $result->domain = $this->getDomainFromURL($result->link);
                        $result->availability = $this->checkLeadAvailability($result->domain);
                        $results[] = $result;
                    }
                }
    
                return view('mining.googleSearch')
                    ->with('results', $results)
                    ->with('fullSearchQuery', $fullSearchQuery)
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

