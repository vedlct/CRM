<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Possibility;

class PossibilityController extends Controller
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
        $possibilities = Possibility::paginate(5);

        return view('system-mgmt/possibility/index', ['possibilities' => $possibilities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/possibility/create');
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
        // Possibility::create([
        DB::table('possibilities')->insert([
            'possibilityName' => $request['possibilityName'],
        ]);

        return redirect()->intended('system-management/possibility');
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
        $possibility = Possibility::find($id);
        // Redirect to possibility list if updating possibility wasn't existed
        if ($possibility == null || count($possibility) == 0) {
            return redirect()->intended('/system-management/possibility');
        }

        return view('system-mgmt/possibility/edit', ['possibility' => $possibility]);
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
        $possibility = Possibility::findOrFail($request->possibilityId);
        $input = [
            'possibilityName' => $request['possibilityName'],
        ];
        $this->validate($request, [
        'possibilityName' => 'required|max:60'
        ]);
        Possibility::where('possibilityId', $request->possibilityId)
            ->update($input);
        
        return redirect()->intended('system-management/possibility');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Possibility::where('possibilityId', $id)->delete();
         return redirect()->intended('system-management/possibility');
    }

    /**
     * Search possibility from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'possibilityName' => $request['possibilityName']
            ];

       $possibilities = $this->doSearchingQuery($constraints);
       return view('system-mgmt/possibility/index', ['possibilities' => $possibilities, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = possibility::query();
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
        'possibilityName' => 'required|max:60|unique:possibilities',
    ]);
    }
}
