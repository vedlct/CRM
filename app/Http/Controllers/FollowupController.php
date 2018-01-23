<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\User;
use App\Usertype;
use Image;
use Auth;


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
        $followups = DB::where('type', 2)table('followup')
        ->leftJoin('leads', 'followup.leadId', '=', 'leads.leadId')
        ->leftJoin('categories', 'categories.categoryId', '=', 'leads.categoryId')
        ->leftJoin('countries', 'countries.countryId', '=', 'leads.countryId')
        ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
        ->leftJoin('users', 'users.id', '=', 'leads.minedBy')
        ->select('followup.*', 'users.userId as userId',  'leads.website as website', 'leads.companyName as companyName', 'leads.personName as personName', 'countries.countryName as countryName', 'categories.categoryName as categoryName')
        ->paginate(5);

        return view('follow-up/index', ['followups' => $followups]);
    }


    public function destroy($id){
        $lead=Lead::findOrFail($id);
        $lead->delete();
        Session::flash('message', 'Lead deleted successfully');
        return back();
    }



}
