<?php

namespace TaleOfOrigin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['salt', 'password', 'remember_token'];
    
    public function memories() {
        return $this->hasMany('TaleOfOrigin\Memory');
    }
}
