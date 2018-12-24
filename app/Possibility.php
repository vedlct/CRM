<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Possibility extends Model
{
    public $timestamps = false;
    protected $table = 'possibilities';
    protected $primaryKey = 'possibilityId';
}
