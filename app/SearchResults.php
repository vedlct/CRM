<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SearchResults extends Model
{
    
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'searchresults';

}
