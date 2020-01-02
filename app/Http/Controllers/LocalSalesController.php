<?php

namespace App\Http\Controllers;

use App\LocalOldSales;
use App\LocalOldSalesDetails;
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
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $companies=LocalCompany::select('local_companyId','companyName')
            ->get();

        return view('local-sale.index',compact('companies'));
    }

    public function getLeads(Request $r){
        $User_Type=Session::get('userType');

        $leads=LocalLeadAssign::select('local_lead.local_leadId','local_lead.leadName','companyName','local_company.website','local_company.mobile','local_company.tnt','categoryName')
            ->leftJoin('local_lead','local_lead.local_leadId','local_lead_assign.local_leadId')
            ->where('local_lead.statusId','!=',4);

        if($r->companyId){
            $leads=$leads->where('local_lead.local_companyId',$r->companyId);
        }
        if($User_Type!=='ADMIN'){
            $leads=$leads->where('local_lead_assign.userId',Auth::user()->id);
        }

        $leads=$leads->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->get();
        return $datatables = Datatables::of($leads)
        ->addColumn('pending', function($leads){
            $totalPayment=LocalSales::where('local_leadId',$leads->local_leadId)
                ->sum('total');

            $bill=LocalLead::findorFail($leads->local_leadId)->bill;
            return $bill-$totalPayment  ;

        })
        ->rawColumns(['pending', 'pending'])
            ->toJson();
    }

    public function getOldSalesData(Request $r){
        $oldSales= LocalOldSales::select('local_old_sales.local_old_salesId','local_old_sales.title','companyName','bill')
            ->leftJoin('local_company','local_company.local_companyId','local_old_sales.local_companyId')
            ->get();
        $datatables = Datatables::of($oldSales);
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

    public function insertOldSale(Request $r){
        $sales=new LocalOldSales();
        $sales->title=$r->title;
        $sales->local_companyId=$r->local_companyId;
        $sales->bill=$r->bill;
        $sales->userId=Auth::user()->id;
        $sales->save();
        Session::flash('message', 'Sales Added successfully');
        return redirect()->route('local.sales');
    }

    public function getOldPaymentInfo(Request $r){
        $sales=LocalOldSales::findOrFail($r->leadId);

        $leadId=$r->leadId;

        $payments=LocalOldSalesDetails::select('users.firstName','local_old_sale_details.total','local_old_sale_details.date')
            ->where('local_old_sale_details.local_old_saleId',$r->leadId)
            ->leftJoin('local_old_sales','local_old_sales.local_old_salesId','local_old_sale_details.local_old_saleId')
            ->leftJoin('local_company','local_company.local_companyId','local_old_sales.local_companyId')
            ->leftJoin('users','users.id','local_old_sale_details.userId')
            ->get();

        $totalPayment=LocalOldSalesDetails::where('local_old_saleId',$r->leadId)
            ->sum('total');

        return view('local-sale.getOldPaymentInfo',compact('sales','payments','leadId','totalPayment'));
    }

    public function insertOldSalePayment(Request $r){
        $sale=new LocalOldSalesDetails();
        $sale->userId=Auth::user()->id;
        $sale->local_old_saleId=$r->leadId;
        $sale->total=$r->total;
        $sale->date=$r->date;
        $sale->save();

        Session::flash('message', 'Payment Added successfully');
        return redirect()->route('local.sales');
    }
}
