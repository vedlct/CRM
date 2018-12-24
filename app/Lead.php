<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class Lead extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'leadId';
    protected $table = 'leads';

    public function category(){
        return $this->belongsTo(Category::class,'categoryId','categoryId');
    }


    public function myLeads(){

        $leads=Lead::select('leads.*')
            ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
            ->where('leadassigneds.assignTo',Auth::user()->id)
            ->where('leadassigneds.leaveDate',null)
            ->where('leadassigneds.workStatus',0)
            ->get();

        return $leads;
    }

    public function showNotAssignedLeads(){

        $leads=Lead::with('mined','category','country','possibility')
            ->where('statusId',2)
            ->where(function($q){
                $q->orWhere('contactedUserId',0)
                    ->orWhere('contactedUserId',null);
                })
            ->where('leadAssignStatus',0)
            ->select('leads.*');


        return $leads;
    }




    public function possibility(){
        return $this->belongsTo(Possibility::class,'possibilityId','possibilityId');
    }

    public function country(){
        return $this->belongsTo(Country::class,'countryId','countryId');
    }


    public function mined(){
        return $this->belongsTo(User::class,'minedBy','id');
    }

    public function contact(){

        return $this->belongsTo(User::class,'contactedUserId','id');
    }


    public function getTempLead(){

        $leads=Lead::with('mined','category','country','possibility')
            ->where('statusId',1)
            ->orderBy('leadId','desc')
            ->select('leads.*');
        return $leads;

        }


    public function status(){

        return $this->belongsTo(Leadstatus::class,'statusId','statusId');
    }


    public function getFilteredLead(){
        $lead=Lead::where('statusId', 2)
            ->get();
        return $lead;
    }


    public function assigned(){
        return $this->hasOne(Leadassigned::class,'leadId','leadId');
    }


}
