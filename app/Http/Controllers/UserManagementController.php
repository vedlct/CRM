<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\User;
use App\Usertype;
use Image;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;


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
    public function index()
    {
        $User_Type=Session::get('userType');
		if($User_Type=='ADMIN') {

            $users = User::get();
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

		$this->validateInput($request);
//        // Upload image
        if ($request->file('picture')) {
            $img = $request->file('picture');
            $filename=  Auth::user()->id.'.'.$request['userId'].'.'.$img->getClientOriginalExtension();
            $location = public_path('img/'.$filename);
            Image::make($img)->resize(300,200)->save($location);

        }else{
            $filename = '';
        }
      /*  User::create([

           // DB::table('users')->insert([
            'userId' => $request['userId'],
            'typeId' => $request['typeId'],
            'userEmail' => $request['userEmail'],
            'password' => bcrypt($request['password']),
            'rfID' => $request['rfID'],
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'phoneNumber' => $request['phoneNumber'],
            'picture' =>  $filename,
			//$request['picture'],
            'dob' => date('Y-m-d',strtotime($request['dob'])),
            'gender' => $request['gender'],
            'active' => $request['active'],
			
        ]);*/
		
		
		$keys = ['userId', 'typeId', 'rfID', 'userEmail', 'password', 'firstName', 'lastName', 'phoneNumber',
        'dob', 'gender', 'active'];
        $input = $this->createQueryInput($keys, $request);
        $input['picture'] = $filename;
        // Not implement yet
        // $input['company_id'] = 0;
		//return $request;
        User::create($input);
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

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
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
            $filename=  Auth::user()->id.'.'.$request['userId'].'.'.$img->getClientOriginalExtension();
            $location = public_path('img/'.$filename);
            Image::make($img)->resize(200,200)->save($location);
            $input['picture'] = $filename;

        }

        User::where('id', $id)
            ->update($input);

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
		'userId' => 'required|max:50|unique:users',
		'typeId' => 'required|max:11|numeric',
		'userEmail' => 'required|email|max:45|unique:users',
        'password' => 'required|min:6|max:20|confirmed',
        'firstName' => 'required|max:20',
        'lastName' => 'required|max:20',
        'rfID' => 'max:11|numeric',
        'phoneNumber' => 'max:15',
        'picture' => 'max:45',
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
