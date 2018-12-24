<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalMeeting extends Model
{
    public $timestamps = false;
    protected $table = 'local_meeting';
    protected $primaryKey = 'local_meetingId';
}
