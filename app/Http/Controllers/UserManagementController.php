<?php

namespace App\Http\Controllers;

use App\LocalUserTarget;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Image;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Usertype;
use App\Usertarget;
use App\Targetlog;


class UserManagementController extends Controller
{
	
	
	
       /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user-management';

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
		if($User_Type=='ADMIN' || $User_Type=='SUPERVISOR' || $User_Type=='MANAGER') {

		    //Manager have ony access to his team
		    if($User_Type=='MANAGER'){
                $users = User::with('target')
                    ->where('teamId',Auth::user()->teamId)
                    ->get();
            }
            else{
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'crmType' => $crmType,

        ]);
		
        Session::flash('message', 'User Added successfully');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
		
        $this->validateInput($request);
        // Upload image
        $keys = ['userId', 'typeId', 'userEmail', 'rfID', 'firstName', 'lastName',
            'phoneNumber', 'dob', 'gender', 'active'];
        $input = $this->createQueryInput($keys, $request);

        if ($request['password'] != null && strlen($request['password']) > 0) {
            $constraints['password'] = 'required|min:6|confirmed';
            $input['password'] =  bcrypt($request['password']);
        }
        if ($request->file('picture')) {
            $img = $request->file('picture');
            $filename=  $request['userId'].'.'.$img->getClientOriginalExtension();
            $location = public_path('img/'.$filename);
            Image::make($img)->resize(200,200)->save($location);
            $input['picture'] = $filename;

        }

        User::where('id', $request->id)
            ->update($input);

        Session::flash('message', 'Successfully user\'s info updated ');
        return redirect()->intended('/user-management');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
         return redirect()->intended('/user-management');
    }

    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
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

    /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
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

    private function createQueryInput($keys, $request) {
        $queryInput = [];
        for($i = 0; $i < sizeof($keys); $i++) {
            $key = $keys[$i];
            $queryInput[$key] = $request[$key];
        }

        return $queryInput;
    }




    public function settings(){
        $user=User::findOrFail(Auth::user()->id);

        return view('users-mgmt.accountSetting')
                ->with('user',$user);
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

       }
       catch (ModelNotFoundException $ex) {
           $target=new Usertarget;
           $target->userId=$r->userId;
           $target->targetTest=0;


          //Target Type: 1. call, 2.HighPossibility , 3. Lead Mined, 4. Contact

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



       }





        $target->save();

        Session::flash('message', 'Target Set successfully');
        return back();
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
	
	
}
