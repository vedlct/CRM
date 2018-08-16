<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalSales extends Model
{

    public $timestamps = false;
    protected $table = 'local_sales';
    protected $primaryKey = 'local_salesId';
}
