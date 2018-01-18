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
