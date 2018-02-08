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
            ->get();

        return $leads;
    }

    public function showNotAssignedLeads(){
       // $leads = DB::select
//        ( DB::raw("SELECT * FROM leads LEFT JOIN leadassigneds ON leadassigneds.leadId = leads.leadId WHERE
//        (leadassigneds.leadId is null OR leadassigneds.leadAssignStatus = '0')") );
//        $leads=Lead::with('mined','category')
//            ->where('leads.statusId','2')
//            ->orWhere('contactedUserId',0)
//            ->where('leadAssignStatus',0)
//            ->leftJoin('countries','leads.countryId', '=','countries.countryId')
//            ->select('leads.*', 'countries.countryName');
//
//        ->where(function($q){
//            $q->orWhere('contactedUserId',0)
//                ->orWhere('contactedUserId',null);
//        })

        $leads=Lead::with('mined','category','country')
            ->where('statusId',2)
            ->where('contactedUserId',0)
            ->orWhere('contactedUserId',null)
            ->where('leadAssignStatus',0)
            ->orWhere('leadAssignStatus',null)
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


    public function getTempLead($start,$limit,$search){
        if($search==null){
            $leads=Lead::with('category','country')
                ->where('statusId', 1)
                ->offset($start)
                ->limit($limit)
                ->orderBy('leadId','desc')
                ->get();
            }
            else{
                $leads=Lead::with('country')
                    ->where(function($q) use ($search){
                        $q->orWhere('companyName','like',"%{$search}%")
                            ->orWhere('website','like',"%{$search}%")
                        ->orWhereHas('category', function ($query) use ($search){
                            $query->where('categoryName', 'like', '%'.$search.'%');
                        });
                    })
//                    ->orWhereHas('category', function ($query) use ($search){
//                        $query->where('categoryName', 'like', '%'.$search.'%');
//                    })
                    ->where('statusId', 1)
                    ->offset($start)
                    ->limit($limit)
                    ->get();
            }


        return $leads;
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
