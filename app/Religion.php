<?php

namespace TaleOfOrigin;

use TaleOfOrigin\SlugModel;

class Religion extends SlugModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug'];

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
