<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keyword extends Model
{
    public $timestamps = false;
    protected $table = 'keywords';
    protected $primaryKey = 'keywordId';
}
