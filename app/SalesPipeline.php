<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


class SalesPipeline extends Model
{
    protected $table = 'salespipeline';
    public $timestamps = false;
    protected $primaryKey = 'pipelineId';

    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }

    public function leads(){
        return $this->belongsTo(Lead::class,'leadId','leadId');
    }
    
}
