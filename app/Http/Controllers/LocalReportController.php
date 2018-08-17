<?php

namespace App\Http\Controllers;

use App\LocalCompany;
use App\LocalSales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LocalReportController extends Controller
{
    public function index(){

        return view('local-report.index');
    }

    public function revenueClient(Request $r){

        $companies=LocalCompany::select('local_companyId','companyName')
            ->get();

        $Y=date('Y');
        $start=$Y.'-01-01';
        $end=$Y.'-12-31';


        $bills=LocalSales::select('local_company.local_companyId',DB::raw('Month(local_sales.created_at) as month'),DB::raw('sum(local_sales.total) as total'))
            ->leftJoin('local_lead','local_lead.local_leadId','local_sales.local_leadId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->groupBy(DB::raw('month(local_sales.created_at)'))
            ->groupBy('local_lead.local_companyId')
            ->whereBetween(DB::raw('date(local_sales.created_at)'),array([$start,$end]))
            ->get();
    }
}
