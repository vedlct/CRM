<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalLeadAssign extends Model
{
    //
    public $timestamps = false;
    protected $table = 'local_lead_assign';
    protected $primaryKey = 'local_lead_assignId';
}
