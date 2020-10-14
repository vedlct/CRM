<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Probability extends Model
{
    public $timestamps = false;
    protected $table = 'probabilities';
    protected $primaryKey = 'probabilityId';
}
