<?php

namespace TaleOfOrigin;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','title'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
    
    public function people() {
        return $this->hasMany('TaleOfOrigin\Person');
    }
}
