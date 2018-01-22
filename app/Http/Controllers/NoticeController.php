<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notice;
use Auth;
use App\Category;

class NoticeController extends Controller
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
  /*  public function index()
    {
        $notices = Notice::paginate(5);
        ->leftJoin('city', 'notices.city_id', '=', 'city.id')

        return view('notice/index', ['notices' => $notices]);
    }*/
	
	
    public function index()
    {
        $notices = DB::table('notices')
        ->leftJoin('users', 'notices.userId', '=', 'users.id')
        ->leftJoin('categories', 'notices.categoryId', '=', 'categories.categoryId')
        ->select('notices.*', 'users.userId as userId', 'categories.categoryName as categoryName')
        ->paginate(5);

        return view('notice/index', ['notices' => $notices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::get();
        return view('notice/create')
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->validateInput($request);
            DB::table('notices')->insert([
       //  Notice::create([
                'msg' => $request['msg'],
                'categoryId' => $request['categoryId'],
                'userId' => Auth::user()->id
        ]);

        return redirect()->intended('notice');
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
        $notice = Notice::find($id);
        // Redirect to notice list if updating notice wasn't existed
        if ($notice == null || count($notice) == 0) {
            return redirect()->intended('/notice');
        }

       $categories = Category::get();
        return view('notice/edit', ['notice' => $notice, 'categories' => $categories]);
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
        $notice = Notice::findOrFail($id);
    //    $this->validateInput($request);
        $input = [
            'msg' => $request['msg'],
            'categoryId' => $request['categoryId'],
            'userId' => Auth::user()->id
        ];
        Notice::where('noticeId', $id)
            ->update($input);
        
        return redirect()->intended('notice');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notice::where('noticeId', $id)->delete();
         return redirect()->intended('notice');
    }

    /**
     * Search notice from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'msg' => $request['msg']
            ];

       $notices = $this->doSearchingQuery($constraints);
       return view('notice/index', ['notices' => $notices, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = notice::query();
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
        'msg' => 'required|max:60|unique:notice'
    ]);
    }
}
