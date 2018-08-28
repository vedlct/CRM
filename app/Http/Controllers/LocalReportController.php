<?php

namespace App\Http\Controllers;

use App\LocalCompany;
use App\LocalLeadAssign;
use App\LocalSales;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LocalReportController extends Controller
{
    public function index(Request $r){
        if($r->startDate && $r->endDate){
            return view('local-report.index')
                ->with('startDate',$r->startDate)
                ->with('endDate',$r->endDate);
        }

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

        return view('local-report.revenueClient',compact('bills','companies'));
    }

    public function employeeReport(Request $r){
        $users=User::select('id','firstName','typeId')
            ->where('crmType','local')
            ->get();

        $bills=LocalSales::select('userId',DB::raw('Month(local_sales.created_at) as month'),DB::raw('sum(local_sales.total) as total'))
            ->groupBy(DB::raw('month(local_sales.created_at)'))
            ->groupBy('userId')
            ->get();

        return view('local-report.employeeReport',compact('bills','users'));

    }

    public function leadAssignReport(Request $r){

        $assigns=LocalLeadAssign::select('local_lead.*','local_lead_assign.assignDate','local_company.companyName','categories.categoryName','area.areaName','users.firstName as userName','u1.firstName as userAssignBy')
            ->leftJoin('local_lead','local_lead.local_leadId','local_lead_assign.local_leadId')
            ->leftJoin('users','users.id','local_lead_assign.userId')
            ->leftJoin('users as u1','u1.id','local_lead_assign.assignBy')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('area','area.areaId','local_company.areaId');

        if($r->startDate && $r->endDate){
            $assigns=$assigns->whereBetween(DB::raw('DATE(local_lead_assign.assignDate)'),array($r->startDate,$r->endDate));
        }
            $assigns=$assigns->get();

        return view('local-report.leadAssignReport',compact('assigns'));
    }

    public function getUserRevenueLog(Request $r){
        $bills=LocalSales::select('local_sales.total as paymentInserted','local_company.companyName','local_sales.created_at as paymentDate','local_lead.*','categories.categoryName','area.areaName')
            ->where('userId',$r->userId)
            ->where(DB::raw('MONTH(local_sales.created_at)'),$r->month)
            ->leftJoin('local_lead','local_lead.local_leadId','local_sales.local_leadId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId')
            ->leftJoin('categories','categories.categoryId','local_lead.categoryId')
            ->leftJoin('area','area.areaId','local_company.areaId')
            ->get();

        return  view('local-report.getUserRevenueLog',compact('bills'));
    }
}
