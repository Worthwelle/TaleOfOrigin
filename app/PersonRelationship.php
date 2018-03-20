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
    protected $fillable = ['person1_id', 'person2_id', 'relationship_id', 'role1_id', 'role2_id', 'start', 'end', 'notes'];

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
    
    /**
     * Overload the save function to order the people involved in the
     * relationship.
     * 
     * @todo remove special characters from slugs
     * 
     * @param array $options
     */
    public function save(array $options = array()) {
        $this->checkOrder();
        parent::save($options);
    }
    
    private function checkOrder()
    {
        if( $this->person1_id <= $this->person2_id) {
            return;
        }
        
        $tempPerson = $this->person1_id;
        $tempRole = $this->role1_id;
        
        $this->person1_id = $this->person2_id;
        $this->role1_id = $this->role2_id;
        
        $this->person2_id = $tempPerson;
        $this->role2_id = $tempRole;
    }
    
    static public function findRelation($id1, $id2) {
        return PersonRelationship::where(function ($query) use($id1, $id2) {
            $query->where('person1_id',$id1)
                  ->where('person2_id',$id2);
        })->orWhere(function ($query) use($id1, $id2) {
            $query->where('person1_id',$id2)
                  ->where('person2_id',$id1);
        })->get();
    }
}
