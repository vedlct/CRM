<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Status;

class StatusController extends Controller
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
        $statuses = Status::paginate(5);

        return view('system-mgmt/status/index', ['statuses' => $statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/status/create');
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
        // Status::create([
        DB::table('leadstatus')->insert([
            'statusName' => $request['statusName']
        ]);

        return redirect()->intended('system-management/status');
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
        $status = Status::find($id);
        // Redirect to status list if updating status wasn't existed
        if ($status == null || count($status) == 0) {
            return redirect()->intended('/system-management/status');
        }

        return view('system-mgmt/status/edit', ['status' => $status]);
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
        $status = Status::findOrFail($id);
        $input = [
            'statusName' => $request['statusName']
        ];
        $this->validate($request, [
        'statusName' => 'required|max:60'
        ]);
        Status::where('statusId', $id)
            ->update($input);
        
        return redirect()->intended('system-management/status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Status::where('statusId', $id)->delete();
         return redirect()->intended('system-management/status');
    }

    /**
     * Search status from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'statusName' => $request['statusName']
            ];

       $statuses = $this->doSearchingQuery($constraints);
       return view('system-mgmt/status/index', ['statuses' => $statuses, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = status::query();
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
        'statusName' => 'required|max:60|unique:leadstatus'
    ]);
    }
}
