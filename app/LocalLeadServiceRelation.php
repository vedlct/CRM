<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalLeadServiceRelation extends Model
{
    //
    public $timestamps = false;
    protected $table = 'local_lead_service_relation';
    protected $primaryKey = 'local_lead_service_relationId';
}
