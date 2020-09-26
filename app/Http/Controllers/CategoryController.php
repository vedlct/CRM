<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Subcategory;
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
        $this->validate($request, [
            'categoryName' => 'required',
            'type' => 'required'
        ]);

        if($request->parentCategoryId){
            $subcategory = new Subcategory();
            $subcategory->subcategoryName = $request->categoryName;
            $subcategory->parentCategoryId = $request->parentCategoryId;
            $subcategory->type = $request->type;
            $subcategory->save();
            Session::flash('message', 'Category successfully created');
            return back();
        }else{
            $category = new Category();
            $category->categoryName = $request->categoryName;
            $category->type = $request->type;
            $category->save();
            Session::flash('message', 'Category successfully created');
            return back();
        }




//        $this->validateInput($request);
//        // Category::create([
//        DB::table('categories')->insert([
//            'categoryName' => $request['categoryName'],
//            'type' => $request['type']
//        ]);






    }

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


    public function destroy($id)
    {
        Category::where('categoryId', $id)->delete();
        Session::flash('message', 'Category successfully deleted');

         return back();
    }



    private function validateInput($request) {
        $this->validate($request, [
        'categoryName' => 'required|max:60|unique:categories',
        'type' => 'required|max:3'
    ]);
    }
}
