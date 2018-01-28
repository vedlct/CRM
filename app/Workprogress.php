<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workprogress extends Model
{
    protected $table = 'workprogress';
    public $timestamps = false;


    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }
}
