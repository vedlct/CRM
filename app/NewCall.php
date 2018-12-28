<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewCall extends Model
{
    public $timestamps = false;
    protected $table = 'new_call';
    protected $primaryKey = 'new_callId';
}
