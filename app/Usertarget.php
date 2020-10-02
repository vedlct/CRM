<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usertarget extends Model
{
    protected $table = 'usertargets';
    public $timestamps = false;
    protected $primaryKey = 'userId';
}
