<?php

namespace TaleOfOrigin;

use TaleOfOrigin\SlugModel;

class Gender extends SlugModel
{
    protected $fillable = ['title', 'slug'];
    
    public function people() {
        return $this->hasMany('TaleOfOrigin\Person');
    }
}
