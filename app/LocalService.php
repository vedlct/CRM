<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalService extends Model
{
    public $timestamps = false;
    protected $table = 'local_service';
    protected $primaryKey = 'local_serviceId';
}
