<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalUserTarget extends Model
{
    public $timestamps = false;
    protected $table = 'local_user_target';
    protected $primaryKey = 'local_user_targetId';
}
