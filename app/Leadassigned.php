<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leadassigned extends Model
{
    public $timestamps = false;
    protected $table = 'leadassigneds';
    protected $primaryKey = 'assignId';


    public function userBy(){

        return $this->belongsTo(User::class,'assignBy','id')->select(['firstName']);
    }

    public function userTo(){

        return $this->belongsTo(User::class,'assignTo','id')->select(['firstName']);
    }

}
