<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
   protected $primaryKey = 'teamId';


    public function user()
    {
        //you missed the return
        return $this->belongsTo('App\User','teamId','teamId');
    }
}
