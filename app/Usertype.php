<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;
    protected $table = 'usertypes';
    protected $primaryKey = 'typeId';
}
