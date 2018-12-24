<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Usertype;

class UsertypeController extends Controller
{
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
        $usertypes = Usertype::paginate(5);

        return view('system-mgmt/usertype/index', ['usertypes' => $usertypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/usertype/create');
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
        // Usertype::create([
        DB::table('usertypes')->insert([
            'typeName' => $request['typeName'],
        ]);

        return redirect()->intended('system-management/usertype');
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
        $usertype = Usertype::find($id);
        // Redirect to usertype list if updating usertype wasn't existed
        if ($usertype == null || count($usertype) == 0) {
            return redirect()->intended('/system-management/usertype');
        }

        return view('system-mgmt/usertype/edit', ['usertype' => $usertype]);
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
        $usertype = Usertype::findOrFail($request->typeId);
        $input = [
            'typeName' => $request['typeName']
        ];
        $this->validate($request, [
        'typeName' => 'required|max:60'
        ]);
        Usertype::where('typeId', $request->typeId)
            ->update($input);
        
        return redirect()->intended('system-management/usertype');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Usertype::where('typeId', $id)->delete();
         return redirect()->intended('system-management/usertype');
    }

    /**
     * Search usertype from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'typeName' => $request['typeName']
            ];

       $usertypes = $this->doSearchingQuery($constraints);
       return view('system-mgmt/usertype/index', ['usertypes' => $usertypes, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = usertype::query();
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
    private function validateInput($request) {
        $this->validate($request, [
        'typeName' => 'required|max:60|unique:usertypes'
    ]);
    }
}
