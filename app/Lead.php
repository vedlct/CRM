<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lead extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'leadId';
    protected $table = 'leads';

    public function category(){


        return $this->belongsTo(Category::class,'categoryId','categoryId');
    }

    public function showAssignedLeads(){
       // $leads = DB::select
//        ( DB::raw("SELECT * FROM leads LEFT JOIN leadassigneds ON leadassigneds.leadId = leads.leadId WHERE
//        (leadassigneds.leadId is null OR leadassigneds.leadAssignStatus = '0')") );
        $leads=Lead::select('leads.*')
            ->where('leads.statusId','2')
            ->leftJoin('leadassigneds','leadassigneds.leadId','=','leads.leadId')
            ->where('leadassigneds.leadId',null)
            ->orWhere('leadassigneds.leadAssignStatus','0')
            ->where('leadAssignStatus','0')
            ->orderBy('leads.leadId','asc')
            ->get();
        return $leads;
    }


    public function country(){


        return $this->belongsTo(Country::class,'countryId','countryId');
    }


    public function mined(){

        return $this->belongsTo(User::class,'minedBy','id');
    }


    public function getTempLead(){

        $lead=Lead::where('statusId', 1)
                    ->get();
        return $lead;
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
