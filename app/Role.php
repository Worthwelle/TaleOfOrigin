<?php

namespace TaleOfOrigin;

use TaleOfOrigin\SlugModel;

class Role extends SlugModel
{
    protected $fillable = ['title', 'slug'];
}
