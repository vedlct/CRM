<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalLead extends Model
{
    public $timestamps = false;
    protected $table = 'local_lead';
    protected $primaryKey = 'local_leadId';
}
