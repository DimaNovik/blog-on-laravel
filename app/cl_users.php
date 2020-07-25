<?php

namespace App;
use \Storage;
use Illuminate\Database\Eloquent\Model;
use \Auth;

class cl_users extends Model
{
    //
    protected $fillable = [
        'name', 'group_id', 'phone', 'login', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
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

}
