<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    public $timestamps = false;
    protected $table = 'directmessage';
    protected $primaryKey = 'id';
}
