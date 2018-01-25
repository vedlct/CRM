<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Team;
use PhpParser\Node\Expr\AssignOp\Mod;


class User extends Model
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userType(){
        return $this->belongsTo(Usertype::class,'typeId','typeId');
    }


    public function teams(){
      return $this->belongsTo(Team::class,'teamId','teamId');

    }
}
