<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalOldSalesDetails extends Model
{
    public $timestamps = false;
    protected $table = 'local_old_sale_details';
    protected $primaryKey = 'local_old_sale_detailsId';
}
