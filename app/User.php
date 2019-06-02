<?php

namespace App;

use \Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const IS_ADMIN = 1;
    const IS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'login', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function remove()
    {
        $this->delete();
    }

    public function makeAdmin($value) {

        if($value === null) {
            $this->is_admin = 0;
            $this->save();
        } else {
            $this->is_admin = USER::IS_ADMIN;
            $this->save();
        }

    }

    public function makeNormal($value)
    {
        if($value === null) {
            $this->is_active = 0;
            $this->save();
        } else {
            $this->is_active = USER::IS_ACTIVE;
            $this->save();
        }
    }

    public function getUserName() {
        return $this->name;
    }

}
