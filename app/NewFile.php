<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewFile extends Model
{
    public $timestamps = false;
    protected $table = 'new_file';
    protected $primaryKey = 'new_fileId';

    public function lead()
    {
        return $this->hasOne(Lead::class, 'leadId', 'leadId');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
