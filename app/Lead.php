<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;


class Lead extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'leadId';
    protected $table = 'leads';

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }


    public function myLeads()
    {

        $leads = Lead::select('leads.*')
        ->leftJoin('leadassigneds', 'leadassigneds.leadId', '=', 'leads.leadId')
            ->where('leadassigneds.assignTo', Auth::user()->id)
            ->where('leadassigneds.leaveDate', null)
            ->where('leadassigneds.workStatus', 0)
            ->get();

        return $leads;
    }

    public function myLeads2()
    {

        $leads = Lead::Join('leadassigneds', 'leadassigneds.leadId', '=', 'leads.leadId')
            ->join('users', 'leadassigneds.assignBy', 'users.id')
            ->where('leadassigneds.assignTo', Auth::user()->id)
            ->where('leadassigneds.leaveDate', null)
            ->where('leadassigneds.workStatus', 0)
            ->select('leads.*','leadassigneds.assignId as iid', 'leadassigneds.assignBy','users.userId as username')
            ->get();

        return $leads;
    }

    // public function showNotAssignedLeads()
    // {

    //     $leads = Lead::with('mined', 'category', 'country', 'possibility', 'probability','workprogress')
    //         ->where('statusId', 2)
    //         ->where(function ($q) {
    //             $q->orWhere('contactedUserId', 0)
    //                 ->orWhere('contactedUserId', null);
    //         })
    //         ->where('leadAssignStatus', 0)
    //         ->select('leads.*');


    //     return $leads;
    // }


    // public function showNotAssignedLeads()
    // {
    //     $currentUserId = Auth::user()->id;
    
    //     $leads = Lead::with('mined', 'category', 'country', 'possibility', 'probability', 'workprogress')
    //         ->where('statusId', 2)
    //         ->where(function ($q) use ($currentUserId) {
    //             $q->orWhere('contactedUserId', 0)
    //                 ->orWhereNull('contactedUserId');
    //         })
    //         ->where('leadAssignStatus', 0)
    //         ->whereNotExists(function ($query) use ($currentUserId) {
    //             $query->select('workprogress.userId')
    //                 ->from('workprogress')
    //                 ->whereRaw('leads.leadId = workprogress.leadId')
    //                 ->where('workprogress.userId', $currentUserId);
    //         })
    //         ->select('leads.*');
    
    //     return $leads;
    // }


    public function showNotAssignedLeads()
    {
        $currentUserId = Auth::user()->id;
    
        $leads = Lead::with('mined', 'category', 'country', 'possibility', 'probability', 'workprogress')
            ->where('statusId', 2)
            ->where(function ($q) {
                $q->orWhere('contactedUserId', 0)
                    ->orWhereNull('contactedUserId');
            })
            ->where('leadAssignStatus', 0)
            ->leftJoin('workprogress', function ($join) use ($currentUserId) {
                $join->on('leads.leadId', '=', 'workprogress.leadId')
                    ->where('workprogress.userId', '=', $currentUserId);
            })
            ->whereNull('workprogress.userId')
            ->select('leads.*');
    
        return $leads;
    }
    
    


    public function showNotAssignedAllLeads()
    {

        $leads = Lead::with('mined', 'category', 'country', 'possibility', 'probability')
        ->where(function ($q) {
            $q->orWhere('contactedUserId', 0)
                ->orWhere('contactedUserId', null);
        })
        ->where('leadAssignStatus', 0)
        ->select('leads.*');


        return $leads;
    }



    public function possibility()
    {
        return $this->belongsTo(Possibility::class, 'possibilityId', 'possibilityId');
    }

    public function probability()
    {
        return $this->belongsTo(Probability::class, 'probabilityId', 'probabilityId');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId', 'countryId');
    }


    public function mined()
    {
        return $this->belongsTo(User::class, 'minedBy', 'id');
    }

    public function release()
    {
        return $this->belongsTo(User::class, 'releaselead', 'id');
    }

    public function contact()
    {

        return $this->belongsTo(User::class, 'contactedUserId', 'id');
    }


    public function getTempLead()
    {

        $leads = Lead::with('mined', 'category', 'country', 'possibility', 'probability')
            ->where('statusId', 1)
            ->orderBy('leadId', 'desc')
            ->select('leads.*');
        return $leads;

    }


    public function status()
    {
        return $this->belongsTo(Leadstatus::class, 'statusId', 'statusId');
    }


    public function getFilteredLead()
    {
        $lead = Lead::where('statusId', 2)
            ->get();
        return $lead;
    }


    public function assigned()
    {
        return $this->hasOne(Leadassigned::class, 'leadId', 'leadId');
    }


    public function workprogress()
    {
        return $this->hasMany(Workprogress::class, 'leadId', 'leadId');
    }

    public function activities()
    {
        return $this->hasMany(Activities::class, 'leadId', 'leadId');
    }

    public function lastCallingReport()
    {

        // return $this->hasMany('App\Workprogress', 'leadId', 'leadId')
        //     ->leftJoin('callingreports', 'callingreports.callingReportId', '=', 'workprogress.callingReport')
        //     ->select('callingreports.report as callingReport')
        //     ->orderBy('workprogress.created_at', 'DESC')
        //     ->latest('workprogress.created_at')
        //     ->first();

            

        return $this->hasMany('App\Workprogress', 'leadId', 'leadId')
            ->leftjoin('callingreports', 'callingreports.callingReportId', '=', 'workprogress.callingReport')
            ->select('callingreports.report as callingReport')
            ->orderBy('workprogress.created_at', 'DESC')
            ->limit(1);

    }
}
