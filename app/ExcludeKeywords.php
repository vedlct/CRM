<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ExcludeKeywords extends Model
{
    public $timestamps = false;
    protected $table = 'excludeKeywords';
    protected $primaryKey = 'id';
}
