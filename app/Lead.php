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

        $leads=Lead::with('mined','category','country')
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
