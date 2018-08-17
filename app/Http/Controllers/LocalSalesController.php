<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use App\LocalCompany;
use App\LocalLeadAssign;
use App\LocalLead;
use App\LocalSales;
use Yajra\DataTables\DataTables;
use Session;
use DB;
class LocalSalesController extends Controller
{
    public function index(){
        $companies=LocalCompany::select('local_companyId','companyName')
            ->get();

        return view('local-sale.index',compact('companies'));
    }

    public function getLeads(Request $r){


        $leads=LocalLeadAssign::select('local_lead.local_leadId','local_lead.leadName','companyName','local_company.website','local_company.mobile','local_company.tnt','categoryName')
            ->leftJoin('local_lead','local_lead.local_leadId','local_lead_assign.local_leadId');

        if($r->companyId){
            $leads=$leads->where('local_lead.local_companyId',$r->companyId);
        }

        $leads=$leads->where('local_lead_assign.userId',Auth::user()->id)
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->get();

//        return $leads;
        $datatables = Datatables::of($leads);
        return $datatables->make(true);
    }

    public function getPaymentInfo(Request $r){
        $totalPayment=LocalSales::where('local_leadId',$r->leadId)
            ->sum('total');

        $bill=LocalLead::findorFail($r->leadId)->bill;

        $payments=LocalSales::select('firstName','total','local_sales.created_at')
            ->where('local_leadId',$r->leadId)
            ->leftJoin('users','users.id','local_sales.userId')
            ->get();

        return view('local-sale.getPaymentInfo')
            ->with('leadId',$r->leadId)
            ->with('totalPayment',$totalPayment)
            ->with('payments',$payments)
            ->with('bill',$bill);
    }

    public function insertPayment(Request $r){
        $payment=new LocalSales();
        $payment->local_leadId=$r->leadId;
        $payment->total=$r->total;
        $payment->userId=Auth::user()->id;
        $payment->save();
        Session::flash('message', 'Payment Added successfully');

        return back();
    }
}
