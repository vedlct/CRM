<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    public $timestamps = false;
    protected $table = 'followup';
    protected $primaryKey = 'followId';
}
