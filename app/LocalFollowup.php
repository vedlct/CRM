<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalFollowup extends Model
{
    //
    public $timestamps = false;
    protected $table = 'local_followup';
    protected $primaryKey = 'local_followupId';
}
