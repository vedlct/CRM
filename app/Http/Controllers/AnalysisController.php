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
                

                return view('analysis.duplicateLeadList')
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
                    'maxTotalLeadMining' => $maxTotalLeadMining
                ]);
            }

            


            public function randomReportsAll () {

                $User_Type = Session::get('userType');
                            
                if ($User_Type == 'ADMIN' || $User_Type == 'SUPERVISOR' || $User_Type == 'MANAGER') {

                    $fromDay = "2023-01-01";
                    $tillToday = Carbon::today()->toDateString();
                    $users = User::get()->where('crmType', '!=', 'local')->where('active', '1');

                    
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

                    return view('analysis.randomReportsAll')
                            ->with('users', $users);

                } else {

                    return view('analysis.analysisHome');
                }


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

