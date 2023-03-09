<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Targetlog extends Model
{
    protected $table = 'targetlogs';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
