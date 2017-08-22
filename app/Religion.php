<?php

namespace TaleOfOrigin;

use TaleOfOrigin\SlugModel;

use Illuminate\Database\Eloquent\Model;

class Religion extends SlugModel
{
    public function people() {
        return $this->hasMany('TaleOfOrigin\Person');
    }
}
