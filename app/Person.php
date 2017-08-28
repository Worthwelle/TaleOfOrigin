<?php

namespace TaleOfOrigin;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'people';
    protected $fillable = ['tree_id','name','birth','death','gender_id','religion','cause_of_death','notes'];
    
    public function tree() {
        return $this->belongsTo('TaleOfOrigin\Tree');
    }
    
    public function gender() {
        return $this->belongsTo('TaleOfOrigin\Gender');
    }
    
    public function religion() {
        return $this->belongsTo('TaleOfOrigin\Religion');
    }
    
    public function getMotherAttribute() {
        $first = $this->relationships1()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id)->first();
        if( $first !== null ) {
            return $first;
        }
        return $this->relationships2()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id)->first();
    }
    
    public function getFatherAttribute() {
        $first = $this->relationships1()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->first();
        if( $first !== null ) {
            return $first;
        }
        return $this->relationships2()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->first();
    }
    
    public function children($exclude = null) {
        return $this->relationships1()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->get()
               ->merge($this->relationships1()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id)->get()
               ->merge($this->relationships2()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->get()
               ->merge($this->relationships2()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id))))->except($exclude);
    }
    
    public function relationships1() {
        return $this->belongsToMany('TaleOfOrigin\Person', 'person_relationships', 'person1_id', 'person2_id')
                    ->withPivot('relationship_id', 'role1_id', 'role2_id');
    }
    
    public function relationships2() {
        return $this->belongsToMany('TaleOfOrigin\Person', 'person_relationships', 'person2_id', 'person1_id')
                    ->withPivot('relationship_id', 'role1_id', 'role2_id');
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
