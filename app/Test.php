<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Lead;
class Test extends Model
{
    public function test(){

        $start = microtime(true);

//        $leads=Lead::with('category','country','status')
//                ->get();

        $leads=Lead::select('leads.*')
            ->leftJoin('categories','leads.categoryId','categories.categoryId')
            ->leftJoin('countries','leads.countryId','countries.countryId')
            ->leftJoin('leadstatus','leads.statusId','leadstatus.statusId')
            ->get();
        $time = microtime(true) - $start;

        return $time;

    }
}
