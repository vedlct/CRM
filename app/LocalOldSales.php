<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalOldSales extends Model
{
    public $timestamps = false;
    protected $table = 'local_old_sales';
    protected $primaryKey = 'local_old_salesId';
}
