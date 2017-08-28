<?php

namespace TaleOfOrigin;

use TaleOfOrigin\SlugModel;

class Religion extends SlugModel
{
    public function people() {
        return $this->hasMany('TaleOfOrigin\Person');
    }
}
