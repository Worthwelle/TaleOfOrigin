<?php

namespace TaleOfOrigin;

use TaleOfOrigin\SlugModel;

class Person extends SlugModel
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'people';
    protected $fillable = ['title', 'slug'];
    
    public function tree() {
        return $this->belongsTo('TaleOfOrigin\Tree');
    }
    
    public function gender() {
        return $this->belongsTo('TaleOfOrigin\Gender');
    }
    
    public function religion() {
        return $this->belongsTo('TaleOfOrigin\Religion');
    }
    
    public function mother() {
        return $this->hasOne('TaleOfOrigin\Person', 'id', 'mother_id');
    }
    
    public function father() {
        return $this->hasOne('TaleOfOrigin\Person', 'id', 'father_id');
    }
    
    public function motherChildren() {
        return $this->hasMany('TaleOfOrigin\Person', 'mother_id');
    }
    
    public function fatherChildren() {
        return $this->hasMany('TaleOfOrigin\Person', 'father_id');
    }
    
    public function children($exclude = null) {
        return $this->motherChildren->merge($this->fatherChildren)->except($exclude);
    }
    
    public function siblings() {
        if( isset($this->father) && isset($this->mother) )
        {
            return $this->father->children($this->id)->merge($this->mother->children($this->id));
        }
        if( isset($this->father) )
        {
            return $this->father->children($this->id);
        }
        if( isset($this->mother) )
        {
            return $this->mother->children($this->id);
        }
        return collect();
    }
    
    public function link() {
        return "<a href=\"". config('app.url') ."/person/". $this->id ."\">". $this->name ."</a>";
    }
}
