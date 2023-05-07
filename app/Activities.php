<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class Activities extends Model
{
    protected $table = 'activities';
    public $timestamps = false;
    protected $primaryKey = 'activityId';

    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }





}
