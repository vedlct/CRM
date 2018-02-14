<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Test extends Model
{
    public function test(){

        $start = microtime(true);
        //$leads = Lead::get();
         // $leads = DB::select('select * from leads');
                $leads=Lead::where('statusId',2)
            ->where(function($q){
                $q->orWhere('contactedUserId',0)
                    ->orWhere('contactedUserId',null);
            })
            ->where('leadAssignStatus',0)
            ->select('leads.*')
                    ->limit(20)
                    ->get();
        $time = microtime(true) - $start;

        return $time;

    }
}
