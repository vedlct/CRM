<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalStatus extends Model
{
    public $timestamps = false;
    protected $table = 'local_status';
    protected $primaryKey = 'local_statusId';
}
