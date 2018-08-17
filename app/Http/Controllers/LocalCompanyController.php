<?php

namespace App\Http\Controllers;

use App\LocalCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Area;
use Session;
class LocalCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function index(){
       $areas=Area::get();

       $companies=LocalCompany::get();

       return view('local-company.index',compact('areas','companies'));
   }

   public function addCompany(Request $r){
       if($r->local_companyId){
           $company=LocalCompany::findOrFail($r->local_companyId);

       }
       else{
           $company=new LocalCompany();
       }

       $company->companyName=$r->companyName;
       $company->website=$r->website;
       $company->contactPerson=$r->contactPerson;
       $company->email=$r->email;
       $company->mobile=$r->mobile;
       $company->tnt=$r->tnt;
       $company->areaId=$r->areaId;
       $company->address=$r->address;

       $company->save();

       if($r->local_companyId){
           Session::flash('message', 'Company Edited successfully');
       }
       else{
           Session::flash('message', 'Company Added successfully');
       }


       return redirect()
           ->route('local.company');
   }

   public function getCompanyModal(Request $r){
       $company=LocalCompany::findOrFail($r->companyId);
       $areas=Area::get();

       return view('local-company.getCompanyModal')
           ->with('company',$company)
           ->with('areas',$areas);
   }
}
