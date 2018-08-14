<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalComment extends Model
{
    //local_comment
    public $timestamps = false;
    protected $table = 'local_comment';
    protected $primaryKey = 'local_commentId';
}
