<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsertargetByMonth extends Model
{
    protected $table = 'usertargetsbymonth';
    public $timestamps = false;
    protected $primaryKey = 'userId';
}
