<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use Session;

class CategoryController extends Controller
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
        $categories = Category::get();

        return view('system-mgmt/category/index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system-mgmt/category/create');
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
        // Category::create([
        DB::table('categories')->insert([
            'categoryName' => $request['categoryName'],
            'type' => $request['type']
        ]);

        Session::flash('message', 'Category successfully created');
        return redirect()->intended('system-management/category');
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
        $category = Category::find($id);
        // Redirect to category list if updating category wasn't existed
        if ($category == null || count($category) == 0) {
			//return $category;
            return redirect()->intended('/system-management/category');
        }

        return view('system-mgmt/category', ['category' => $category]);
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
		//return $request->categoryId;
        $category = Category::findOrFail($request->categoryId);
        $input = [
            'categoryName' => $request['categoryName'],
            'type' => $request['type']
        ];
        $this->validate($request, [
        'categoryName' => 'required|max:60'
        ]);
        Category::where('categoryId', $request->categoryId)
            ->update($input);
        
        Session::flash('message', 'Category successfully updated');
        return redirect()->intended('system-management/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('categoryId', $id)->delete();
        Session::flash('message', 'Category successfully deleted');

         return redirect()->intended('system-management/category');
    }

    /**
     * Search category from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'categoryName' => $request['categoryName'],
            'type' => $request['type']
            ];

       $categories = $this->doSearchingQuery($constraints);
       return view('system-mgmt/category/index', ['categories' => $categories, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = category::query();
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
        'categoryName' => 'required|max:60|unique:categories',
        'type' => 'required|max:3'
    ]);
    }
}
