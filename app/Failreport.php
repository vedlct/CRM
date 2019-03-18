<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Failreport extends Model
{
    public $timestamps = false;
    protected $table = 'failreport';
    protected $primaryKey = 'id';
}
