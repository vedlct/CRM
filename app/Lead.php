<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lead extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'leadId';

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


}
