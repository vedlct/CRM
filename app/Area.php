<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $timestamps = false;
    protected $table = 'area';
    protected $primaryKey = 'areaId';
}
