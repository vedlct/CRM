<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalCompany extends Model
{
    public $timestamps = false;
    protected $table = 'local_company';
    protected $primaryKey = 'local_companyId';
}
