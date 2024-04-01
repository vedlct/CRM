<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Lead;


class TrialInfo extends Model
{

    public $timestamps = false;
    protected $primaryKey = 'trialId';
    protected $table = 'trialinfo';



}