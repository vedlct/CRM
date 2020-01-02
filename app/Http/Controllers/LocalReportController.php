<?php

namespace App\Http\Controllers;

use App\LocalCompany;
use App\LocalFollowup;
use App\LocalLeadAssign;
use App\LocalMeeting;
use App\LocalOldSalesDetails;
use App\LocalSales;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class LocalReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

        $oldBills=LocalOldSalesDetails::select('local_company.local_companyId',DB::raw('Month(local_old_sale_details.date) as month'),DB::raw('sum(local_old_sale_details.total) as total'))
            ->leftJoin('local_old_sales','local_old_sales.local_old_salesId','local_old_sale_details.local_old_saleId')
            ->leftJoin('local_company','local_company.local_companyId','local_old_sales.local_companyId')
            ->groupBy(DB::raw('month(local_old_sale_details.date)'))
            ->groupBy('local_old_sales.local_companyId')
            ->whereBetween(DB::raw('date(local_old_sale_details.date)'),array([$start,$end]))
            ->get();


        return view('local-report.revenueClient',compact('bills','companies','oldBills'));
    }

    public function employeeReport(Request $r){

        $users=User::select('id','firstName','typeId')
            ->where('crmType','local');
             if(Auth::user()->typeId==8){
                 $users=$users->where('id',Auth::user()->id);
             }
        $users=$users->get();

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

    //User Report

    public function workReportUser(Request $r){
        $users=User::select('id','firstName','typeId')
            ->where('crmType','local');
             if(Auth::user()->typeId==8){
                 $users=$users->where('id',Auth::user()->id);
             }
          $users=$users->get();

        $sales=LocalSales::select('userId',DB::raw('sum(local_sales.total) as total'))
            ->groupBy('userId');
             if($r->startDate && $r->endDate){
                 $sales=$sales->whereBetween(DB::raw('DATE(created_at)'),array($r->startDate,$r->endDate));
             }
             else{
                 $sales=$sales->where(DB::raw('DATE(created_at)'),date('Y-m-d'));
             }

        $sales=$sales->get();

        $oldSales=LocalOldSalesDetails::select('local_old_sale_details.userId',DB::raw('sum(local_old_sale_details.total) as total'))
            ->leftJoin('local_old_sales','local_old_sales.local_old_salesId','local_old_sale_details.local_old_saleId')
            ->groupBy('local_old_sale_details.userId');
        if($r->startDate && $r->endDate){
            $oldSales=$oldSales->whereBetween(DB::raw('DATE(local_old_sale_details.date)'),array($r->startDate,$r->endDate));
        }
        else{
            $oldSales=$oldSales->where(DB::raw('DATE(local_old_sale_details.date)'),date('Y-m-d'));
        }
        $oldSales=$oldSales->get();


        $meeting=LocalMeeting::select('userId',DB::raw('count(meetingDate) as total'))->groupBy('userId');

        if($r->startDate && $r->endDate){
            $meeting=$meeting->whereBetween(DB::raw('DATE(meetingDate)'),array($r->startDate,$r->endDate));
        }
        else{
            $meeting=$meeting->where(DB::raw('DATE(meetingDate)'),date('Y-m-d'));
        }
        $meeting=$meeting->get();


        $followup=LocalFollowup::select('userId',DB::raw('count(userId) as total'))
            ->where('workStatus',1)->groupBy('userId');
        if($r->startDate && $r->endDate){
            $followup=$followup->whereBetween(DB::raw('DATE(date)'),array($r->startDate,$r->endDate));

            $startDate=$r->startDate;
            $endDate=$r->endDate;
            $followup=$followup->get();
            return view('local-report.workReportUser',compact('users','sales','meeting','followup','startDate','endDate','oldSales'));
        }
        else{
            $followup=$followup->where(DB::raw('DATE(date)'),date('Y-m-d'));
        }
        $followup=$followup->get();

        return view('local-report.workReportUser',compact('users','sales','meeting','followup','oldSales'));
    }

    public function getUserSales(Request $r){
        $sales=LocalSales::select('local_sales.created_at','local_sales.total','local_lead.leadName','companyName')
            ->where('userId',$r->userId)
            ->leftJoin('local_lead','local_lead.local_leadId','local_sales.local_leadId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId');
        if($r->startDate && $r->endDate){
            $sales=$sales->whereBetween(DB::raw('DATE(local_sales.created_at)'),array($r->startDate,$r->endDate));
        }
        else{
            $sales=$sales->where(DB::raw('DATE(local_sales.created_at)'),date('Y-m-d'));
        }

        $sales=$sales->get();

        return view('local-report.getUserSales',compact('sales'));
    }

    public function getUserOldSales(Request $r){
        $sales=LocalOldSalesDetails::select('local_old_sale_details.date as created_at','local_old_sale_details.total','local_old_sales.title as leadName','companyName')
            ->where('local_old_sale_details.userId',$r->userId)
            ->leftJoin('local_old_sales','local_old_sales.local_old_salesId','local_old_sale_details.local_old_saleId')
            ->leftJoin('local_company','local_company.local_companyId','local_old_sales.local_companyId');
        if($r->startDate && $r->endDate){
            $sales=$sales->whereBetween(DB::raw('DATE(local_old_sale_details.date)'),array($r->startDate,$r->endDate));
        }
        else{
            $sales=$sales->where(DB::raw('DATE(local_old_sale_details.date)'),date('Y-m-d'));
        }

        $sales=$sales->get();

        return view('local-report.getUserSales',compact('sales'));


    }

    public function getUserMeeting(Request $r){
        $meeting=LocalMeeting::select('local_meeting.meetingDate','local_meeting.meetingTime','local_lead.leadName','companyName')
            ->where('userId',$r->userId)
            ->leftJoin('local_lead','local_lead.local_leadId','local_meeting.local_leadId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId');
        if($r->startDate && $r->endDate){
            $meeting=$meeting->whereBetween(DB::raw('DATE(local_meeting.meetingDate)'),array($r->startDate,$r->endDate));
        }
        else{
            $meeting=$meeting->where(DB::raw('DATE(local_meeting.meetingDate)'),date('Y-m-d'));
        }
        $meeting=$meeting->get();

        return view('local-report.getUserMeeting',compact('meeting'));
    }

    public function getUserFollowup(Request $r){
        $followup=LocalFollowup::select('local_followup.date','local_lead.leadName','companyName')
            ->where('userId',$r->userId)
            ->where('workStatus',1)
            ->leftJoin('local_lead','local_lead.local_leadId','local_followup.local_leadId')
            ->leftJoin('local_company','local_company.local_companyId','local_lead.local_companyId');
        if($r->startDate && $r->endDate){
            $followup=$followup->whereBetween(DB::raw('DATE(local_followup.date)'),array($r->startDate,$r->endDate));
        }
        else{
            $followup=$followup->where(DB::raw('DATE(local_followup.date)'),date('Y-m-d'));
        }


        $followup=$followup->get();

        return view('local-report.getUserFollowup',compact('followup'));
    }
}
