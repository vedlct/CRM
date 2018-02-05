<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Team;
use PhpParser\Node\Expr\AssignOp\Mod;


class User extends Authenticatable
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
       // 'userId', 'typeId', 'rfID', 'userEmail', 'password', 'firstName', 'lastName', 'phoneNumber', 'dob', 'gender', 'active'
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


    public function work(){

        return $this->hasMany(Workprogress::class,'userId','id');
    }


    public function teams(){
      return $this->belongsTo(Team::class,'teamId','teamId');

    }
    public function getUserType($typeId){
        $userType = DB::table('usertypes')->select('typeId')->where('typeId', $typeId)->get();

        return $userType;

    }
}
