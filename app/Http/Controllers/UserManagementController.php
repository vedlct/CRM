<?php

namespace App\Http\Controllers;

use App\LocalUserTarget;
use App\UsertargetByMonth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Image;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Lead;
use App\User;
use App\Usertype;
use App\Usertarget;
use App\Targetlog;
use App\Designation;
use App\Workprogress;
use App\Followup;
use App\NewFile;

use Yajra\DataTables\DataTables;


class UserManagementController extends Controller
{
    protected $redirectTo = '/user-management';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getLocalUserTarget(Request $r){

        $userName=User::findOrFail($r->userId)->firstName;
        try{
            $target=LocalUserTarget::findOrFail($r->userId);
        }
        catch (ModelNotFoundException $ex) {
            $target=new LocalUserTarget();
            $target->local_user_targetId=$r->userId;
            $target->earn=0;
            $target->meeting=0;
            $target->followup=0;
            $target->save();
        }

        return view('users-mgmt.getLocalUserTarget',compact('target','userName'));
    }

    public function setLocalUserTarget(Request $r){

        $target=LocalUserTarget::findOrFail($r->userId);
        $target->earn= $r->earn;
        $target->meeting=$r->meeting;
        $target->followup=$r->followup;
        $target->save();
        Session::flash('message', 'Target Updated Successfully');
        return redirect()->route('user-management.index');
    }

    public function index()
    {
        $User_Type=Session::get('userType');
		if($User_Type=='ADMIN' || $User_Type=='SUPERVISOR' || $User_Type=='MANAGER' || $User_Type=='HR') {

		    //Manager have ony access to his team
		    if($User_Type=='MANAGER'){
                $users = User::with('target')
                    ->where('teamId',Auth::user()->teamId)
                    ->get();
            }else{
                $users = User::with('target')
                    ->get();
            }

            $userTypes = Usertype::get();

            return view('users-mgmt/index')
                ->with('users', $users)
                ->with('userTypes', $userTypes);
        }
        return Redirect()->route('home');
    }

    public function create()
    {
        $User_Type=Session::get('userType');
		if($User_Type== 'ADMIN'){


        $userTypes=Usertype::get();
//        return $Types;
        return view('users-mgmt/create')
            ->with('userTypes', $userTypes);}

        return Redirect()->route('home');
    }

    public function store(Request $request)
    {
	//return $request;
		$this->validateInput($request);
        $this->validate($request, [
		'userId' => 'required|max:50|unique:users',
		'userEmail' => 'required|email|max:45|unique:users'
		]);
//        // Upload image
        if ($request->file('picture')) {
            $img = $request->file('picture');
            $filename= $request['userId'].'.'.$img->getClientOriginalExtension();
            $location = public_path('img/'.$filename);
            Image::make($img)->resize(200,200)->save($location);

        }else{
            $filename = '';
        }
        // User::create([
		//return $request;
        $crmType=null;
        if($request['typeId']==6 || $request['typeId']==7 || $request['typeId']==8 || $request['typeId']==9){
            $crmType='local';
        }

           DB::table('users')->insert([
            'userId' => $request['userId'],
            'typeId' => $request['typeId'],
            'userEmail' => $request['userEmail'],
            'password' => bcrypt($request['password']),
            'rfID' => $request['rfID'],
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'phoneNumber' => $request['phoneNumber'],
            'picture' =>  $filename,
            'dob' => date('Y-m-d',strtotime($request['dob'])),
            'gender' => $request['gender'],
            'active' => $request['active'],
            'whitelist' => $request['whitelist'],
            'crmType' => $crmType,

        ]);
		
        Session::flash('message', 'User Added successfully');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $User_Type=Session::get('userType');
		if( $User_Type== 'ADMIN'){


        $user = User::find($id);
        // Redirect to user list if updating user wasn't existed
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/user-management');
        }

       $userTypes = Usertype::get();
        return view('users-mgmt/edit', ['user' => $user, 'userTypes' => $userTypes]);}
        return Redirect()->route('home');
    }


    
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
		
        $this->validateInputNew($request);
        // Upload image
        $keys = ['userId', 'typeId', 'userEmail', 'rfID', 'firstName', 'lastName',
            'phoneNumber', 'dob', 'gender', 'active', 'whitelist', 'designationId'];
        $input = $this->createQueryInput($keys, $request);

        if ($request['password'] != null && strlen($request['password']) > 0) {
            $constraints['password'] = 'required|min:6|confirmed';
            $input['password'] =  bcrypt($request['password']);
        }
        if ($request->file('picture')) {
            $img = $request->file('picture');
            $filename=  $request['userId'].'.'.$img->getClientOriginalExtension();
            $location = public_path('img/users/'.$filename);
            // Image::make($img)->resize(300,200)->save($location);
            Image::make($img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);
            $input['picture'] = $filename;

        }

        User::where('id', $request->id)
            ->update($input);

        Session::flash('message', 'Successfully user\'s info updated ');

        return redirect()->intended('/user-management');
    }



    public function destroy($id)
    {
        User::where('id', $id)->delete();
         return redirect()->intended('/user-management');
    }

    public function search(Request $request) {
        $constraints = [
            'userId' => $request['userId'],
            'firstName' => $request['firstName'],
            ];

       $users = $this->doSearchingQuery($constraints);
       return view('users-mgmt/index', ['users' => $users, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = User::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }
            $index++;
        }
        return $query->paginate(5);
    }

    public function load($name) {
        $path = storage_path().'/app/avatars/'.$name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    private function validateInput($request) {
        $this->validate($request, [
		'userId' => 'required|max:50',
		'typeId' => 'required|max:11|numeric',
		'userEmail' => 'required|email|max:45',
        'password' => 'max:20|confirmed',
        'firstName' => 'required|max:20',
        'lastName' => 'required|max:20',
        'rfID' => 'max:11',
        'phoneNumber' => 'max:15',
        'picture' => 'max:3000',
        'dob' => 'max:10',
        'gender' => 'max:1',
        'active' => 'required|max:1'
    ]);
    }

    private function validateInputNew ($request) {
        $this->validate($request, [
		'userId' => 'max:50',
		'typeId' => 'max:11|numeric',
		'userEmail' => 'required|email|max:45',
        'password' => 'max:20|confirmed',
        'firstName' => 'required|max:20',
        'lastName' => 'required|max:20',
        'rfID' => 'max:11',
        'phoneNumber' => 'max:15',
        'picture' => 'max:3000',
        'dob' => 'max:10',
        'gender' => 'max:1',
        'active' => 'max:1'
    ]);
    }

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }

        return $queryInput;
    }



    public function setTarget(Request $r){
       try{
           $target=Usertarget::findOrFail($r->userId);
           $target->targetTest=$r->targetTest;
           if($r->call !=null){
               $log=new Targetlog;
               $log->userId=$r->userId;
               $log->targetType=1;
               $log->save();

               $target->targetCall=$r->call;
           }

           if($r->highPossibility !=null){
               $log=new Targetlog;
               $log->userId=$r->userId;
               $log->targetType=2;
               $log->save();
               $target->targetHighPossibility=$r->highPossibility;
           }

           if($r->lead !=null){
               $log=new Targetlog;
               $log->userId=$r->userId;
               $log->targetType=3;
               $log->save();
               $target->targetLeadmine=$r->lead;
           }
           if($r->contact !=null){
//               $log=new Targetlog;
//               $log->userId=$r->userId;
//               $log->targetType=3;
//               $log->save();
               $target->targetContact=$r->contact;
           }
           if($r->contactUsa !=null){

               $target->targetUsa=$r->contactUsa;
           }

           if($r->targetFile !=null){
               $target->targetFile=$r->targetFile;
           }

           if($r->conversation !=null){
               $target->conversation=$r->conversation;
           }

           if($r->closelead !=null){
               $target->closelead=$r->closelead;
           }

           if($r->followup !=null){
               $target->followup=$r->followup;
           }

       }catch (ModelNotFoundException $ex) {
           $target=new Usertarget;
           $target->userId=$r->userId;
           $target->targetTest=0;

           if($r->call){
               $log=new Targetlog;
               $log->userId=$r->userId;
               $log->targetType=1;
               $log->save();

               $target->targetCall=$r->call;
           }

           if($r->highPossibility){
               $log=new Targetlog;
               $log->userId=$r->userId;
               $log->targetType=2;
               $log->save();
               $target->targetHighPossibility=$r->highPossibility;
           }

           if($r->lead){
               $log=new Targetlog;
               $log->userId=$r->userId;
               $log->targetType=3;
               $log->save();
               $target->targetLeadmine=$r->lead;
           }
           if($r->contact){

               $target->targetContact=$r->contact;
           }
           if($r->contactUsa ){

               $target->targetUsa=$r->contactUsa;
           }
           if($r->conversation !=null){
               $target->conversation=$r->conversation;
           }

           if($r->closelead !=null){
               $target->closelead=$r->closelead;
           }

           if($r->followup !=null){
               $target->followup=$r->followup;
           }
       }

       $target->save();
       /*UserTargetByMonth*/
        $targetMonthlyGet = UsertargetByMonth::where('userId',$r->userId)->whereYear('date', date('Y'))->whereMonth('date', date('m'))->first();
        if (!empty($targetMonthlyGet)){
            if (empty($targetMonthlyGet->date)){
                $targetMonthly = new UsertargetByMonth;
                $targetMonthly->userId = $r->userId;
                $targetMonthly->date=date("Y-m-d");
            }else{
                $targetMonthly = $targetMonthlyGet;
            }
        }else{
            $targetMonthly = new UsertargetByMonth;
            $targetMonthly->userId = $r->userId;
            $targetMonthly->date=date("Y-m-d");
        }
        $targetMonthly->targetTest=$r->targetTest;
        if($r->call !=null){
            $targetMonthly->targetCall=$r->call;
        }
        if($r->highPossibility !=null){
            $targetMonthly->targetHighPossibility=$r->highPossibility;
        }
        if($r->lead !=null){
            $targetMonthly->targetLeadmine=$r->lead;
        }
        if($r->contact !=null){
            $targetMonthly->targetContact=$r->contact;
        }
        if($r->contactUsa !=null){
            $targetMonthly->targetUsa=$r->contactUsa;
        }
        if($r->targetFile !=null){
            $targetMonthly->targetFile=$r->targetFile;
        }

        if($r->conversation !=null){
            $targetMonthly->conversation=$r->conversation;
        }

        if($r->closelead !=null){
            $targetMonthly->closelead=$r->closelead;
        }

        if($r->followup !=null){
            $targetMonthly->followup=$r->followup;
        }
        $targetMonthly->save();

       Session::flash('message', 'Target Set successfully');
       return back();
    }

    public function targetManagement(){
        return view('users-mgmt.targetManage');
    }

    public function targetManagementGet(Request $data){
        $model = UsertargetByMonth::select('usertargetsbymonth.*','users.userId as username')
        ->leftJoin('users', 'users.id', '=', 'usertargetsbymonth.userId');
        if(!empty($data->month)){
            $model = $model->whereMonth('date', '=', $data->month);
        }
        if(!empty($data->year)){
            $model = $model->whereYear('date', '=', $data->year);
        }
        return (new \Yajra\DataTables\DataTables)->eloquent($model)->orderColumn('targetId', '-targetId $1')->toJson();
    }

    public function changePass(Request $r){

        $this->validate($r,[
            'currentPassword' => 'required|min:6',
            'password' => 'required|min:6',

        ]);
        $user=User::findOrFail(Auth::user()->id);
        $currentPass= Hash::make($r->currentPassword);
        $newPass=Hash::make($r->password);
        if(Hash::check($r->currentPassword, $user->password)){
            $user->password= $newPass;
            $user->save();
            Session::flash('message', 'Password Changed successfully');
            return back();
        }
        Session::flash('message', 'Password did not match');
        return back();
    }

    


    public function settings()
    {

        $user = Auth::user();
        $User_Type = Session::get('userType');
        $userTypes = Usertype::get();

        $currentMonth = Carbon::now()->format('Y-m');
        $showCurrentMonth = Carbon::now()->format('F Y');

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $previousMonth = Carbon::now()->subMonth()->format('Y-m');
        $showPreviousMonth = Carbon::now()->subMonth()->format('F Y');
        
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();


    
        $userTargets = UsertargetByMonth::where('userId', Auth::user()->id)
            ->where('date', 'like', $currentMonth . '%')
            ->get();

        $totalProgressIds = Workprogress::where('userId', Auth::user()->id)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        $totalConversationCalls = Workprogress::where('userId', Auth::user()->id)
            ->where('callingReport', 11)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        $totalTestProgress = Workprogress::where('userId', Auth::user()->id)
            ->where('progress', 'LIKE', '%Test%')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        $totalClosingProgress = Workprogress::where('userId', Auth::user()->id)
            ->where('progress', 'LIKE', '%Closing%')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();    
      
        $totalLeadMining = Lead::where('minedBy', Auth::user()->id)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();    

        $totalFollowUp = Followup::where('userId', Auth::user()->id)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();    

        $totalRevenue = NewFile::where('userId', Auth::user()->id)
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('fileCount');    




        $userTargetPreviousMonth = UsertargetByMonth::where('userId', Auth::user()->id)
            ->where('date', 'like', $previousMonth . '%')
            ->get();

        $totalCallPreviousMonth = Workprogress::where('userId', Auth::user()->id)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $totalConvoPreviousMonth = Workprogress::where('userId', Auth::user()->id)
            ->where('callingReport', 11)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $totalTestPreviousMonth = Workprogress::where('userId', Auth::user()->id)
            ->where('progress', 'LIKE', '%Test%')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $totalClosingPreviousMonth = Workprogress::where('userId', Auth::user()->id)
            ->where('progress', 'LIKE', '%Closing%')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();    
      
        $totalLeadMiningPreviousMonth = Lead::where('minedBy', Auth::user()->id)
            ->whereBetween('created_at', [$previousMonthStart, $currentMonthEnd])
            ->count();    

        $totalFollowUpPreviousMonth = Followup::where('userId', Auth::user()->id)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();    

        $totalRevenuePreviousMonth = NewFile::where('userId', Auth::user()->id)
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('fileCount'); 



            
        return view('users-mgmt.accountSetting')
            ->with('user', $user)
            ->with('showCurrentMonth', $showCurrentMonth)
            ->with('userTargets', $userTargets)
            ->with('userTypes', $userTypes)
            ->with('totalProgressIds', $totalProgressIds)
            ->with('totalConversationCalls', $totalConversationCalls)
            ->with('totalTestProgress', $totalTestProgress)
            ->with('totalClosingProgress', $totalClosingProgress)
            ->with('totalLeadMining', $totalLeadMining)
            ->with('totalFollowUp', $totalFollowUp)
            ->with('totalRevenue', $totalRevenue)
            ->with('showPreviousMonth', $showPreviousMonth)
            ->with('userTargetPreviousMonth', $userTargetPreviousMonth)
            ->with('totalCallPreviousMonth', $totalCallPreviousMonth)
            ->with('totalConvoPreviousMonth', $totalConvoPreviousMonth)
            ->with('totalTestPreviousMonth', $totalTestPreviousMonth)
            ->with('totalClosingPreviousMonth', $totalClosingPreviousMonth)
            ->with('totalLeadMiningPreviousMonth', $totalLeadMiningPreviousMonth)
            ->with('totalFollowUpPreviousMonth', $totalFollowUpPreviousMonth)
            ->with('totalRevenuePreviousMonth', $totalRevenuePreviousMonth)
            ;
    }






        public function userProfile(Request $request)
    {
        $user_id = $request->id;
        $userType = Session::get('userType');
        $fromDay = Carbon::now()->startOfYear();
        $tillToday = Carbon::today()->toDateString();


        if ($userType == 'ADMIN' || $userType == 'SUPERVISOR' || $userType == 'MANAGER') {

            $profile = User::where('id', $user_id)->first(); 



            $totalCallTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('targetCall');

            $totalCallAchievedYear = Workprogress::select('progressId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('userId', $user_id)
                ->count();


            $totalContactTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('targetContact');

            $totalContactAchievedYear = Workprogress::select('progressId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('callingReport', 5)
                ->where('userId', $user_id)
                ->count();


            $totalConvoTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('conversation');

            $totalConvoAchievedYear = Workprogress::select('progressId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('callingReport', 11)
                ->where('userId', $user_id)
                ->count();


            $totalFollowupTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('followup');

            $totalFollowupAchievedYear = Workprogress::select('progressId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('callingReport', 4)
                ->where('userId', $user_id)
                ->count();



            $totalTestTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('targetTest');

            $totalTestAchievedYear = Workprogress::select('progressId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('userId', $user_id)
                ->where('progress', 'LIKE', '%Test%')
                ->count();


            $totalClosingTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('closelead');

            $totalClosingAchievedYear = Workprogress::select('progressId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('userId', $user_id)
                ->where('progress', 'LIKE', '%Closing%')
                ->count();


            $totalRevenueTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('targetFile');

            $totalRevenueAchievedYear = NewFile::whereBetween('created_at', [$fromDay, $tillToday])
                ->where('userId', $user_id)
                ->sum('fileCount');


            $totalLeadMineTargetYear = UserTargetByMonth::where('userId',$user_id)
                ->sum('targetLeadmine');

            $totalLeadMineAchievedYear = Lead::select('leadId')
                ->whereBetween('created_at', [$fromDay, $tillToday])
                ->where('minedBy', $user_id)
                ->count();





                return view('users-mgmt.userProfile')
                ->with('profile', $profile)
                ->with('totalCallTargetYear', $totalCallTargetYear)
                ->with('totalCallAchievedYear', $totalCallAchievedYear)
                ->with('totalContactTargetYear', $totalContactTargetYear)
                ->with('totalContactAchievedYear', $totalContactAchievedYear)
                ->with('totalConvoTargetYear', $totalConvoTargetYear)
                ->with('totalConvoAchievedYear', $totalConvoAchievedYear)
                ->with('totalFollowupTargetYear', $totalFollowupTargetYear)
                ->with('totalFollowupAchievedYear', $totalFollowupAchievedYear)
                ->with('totalTestTargetYear', $totalTestTargetYear)
                ->with('totalTestAchievedYear', $totalTestAchievedYear)
                ->with('totalClosingTargetYear', $totalClosingTargetYear)
                ->with('totalClosingAchievedYear', $totalClosingAchievedYear)
                ->with('totalRevenueTargetYear', $totalRevenueTargetYear)
                ->with('totalRevenueAchievedYear', $totalRevenueAchievedYear)
                ->with('totalLeadMineTargetYear', $totalLeadMineTargetYear)
                ->with('totalLeadMineAchievedYear', $totalLeadMineAchievedYear)
                ;
        } else {

            return back();

        }
    }




}
