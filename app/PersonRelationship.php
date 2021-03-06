<?php

namespace TaleOfOrigin;

use Illuminate\Database\Eloquent\Model;

class PersonRelationship extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['person1_id', 'person2_id', 'relationship_id', 'role1_id', 'role2_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
    
    public function person1() {
        return $this->hasOne('TaleOfOrigin\Person', 'id', 'person1_id');
    }
    
    public function person2() {
        return $this->hasOne('TaleOfOrigin\Person', 'id', 'person2_id');
    }
    
    public function relationship() {
        return $this->hasOne('TaleOfOrigin\Relationship', 'id', 'relationship_id');
    }
}
