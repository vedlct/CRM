<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Employees extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'employeeId';
    protected $table = 'employees';



    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId', 'countryId');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designationId', 'designationId');
    }

    public function leads(){
        return $this->belongsTo(Lead::class,'leadId','leadId');
    }

}
