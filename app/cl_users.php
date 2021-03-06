<?php

namespace App;
use \Storage;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class cl_users extends Authenticatable implements JWTSubject
{
    //
    use Notifiable;

    protected $fillable = [
        'name', 'group_id', 'role', 'login', 'password'
    ];

    protected $hidden = [
     'remember_token',
    ];

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();

        return $user;
    }

    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function edit($fields)
    {
        if(isset($fields['old']) && $fields['old'] !== 'undefined') {
            $this->fill($fields);
            $this->password = $fields['old'];
            $this->save();
        } else {
            $this->fill($fields);
            $this->password = bcrypt($fields['password']);
            $this->save();
        }
       
    }

}
