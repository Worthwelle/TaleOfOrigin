<?php

namespace TaleOfOrigin;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    public function people() {
        return $this->hasMany('TaleOfOrigin\Person');
    }
}
