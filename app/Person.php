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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tree_id','name','birth','death','gender_id','religion','cause_of_death','notes'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at','updated_at'];
    protected $with = ['gender'];

    /**
     * Get the tree the person belongs to.
     */
    public function tree() {
        return $this->belongsTo('TaleOfOrigin\Tree');
    }

    /**
     * Get the person's gender.
     */
    public function gender() {
        return $this->belongsTo('TaleOfOrigin\Gender');
    }

    /**
     * Get the person's religion.
     */
    public function religion() {
        return $this->belongsTo('TaleOfOrigin\Religion');
    }

    /**
     * Get the person's mother.
     * 
     * Check for a mother relationship on the left and the right and
     * return the correct one.
     */
    public function getMotherAttribute() {
        $first = $this->relationships1()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id)->first();
        if( $first !== null ) {
            return $first;
        }
        return $this->relationships2()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id)->first();
    }

    /**
     * Get the person's father.
     * 
     * Check for a mother relationship on the left and the right and
     * return the correct one.
     */
    public function getFatherAttribute() {
        $first = $this->relationships1()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->first();
        if( $first !== null ) {
            return $first;
        }
        return $this->relationships2()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->first();
    }

    /**
     * Get the person's children for JSON.
     * 
     * JSON doesn't receive the children relationship attribute, so it
     * must be manually specified.
     */
    public function getChildrenAttribute() {
        return $this->children();
    }

    /**
     * Get the person's siblings for JSON.
     * 
     * JSON doesn't receive the siblings relationship attribute, so it
     * must be manually specified.
     */
    public function getSiblingsAttribute() {
        return $this->siblings();
    }

    /**
     * Get the person's children.
     * 
     * Check for children based on mother and father relationships on
     * the left and the right.
     */
    public function children($exclude = null) {
        return $this->relationships1()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->get()
               ->merge($this->relationships1()->wherePivot('role1_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id)->get()
               ->merge($this->relationships2()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Father')->first()->id)->get()
               ->merge($this->relationships2()->wherePivot('role2_id','=',\TaleOfOrigin\Role::where('title','=','Mother')->first()->id))))->except($exclude);
    }

    /**
     * Get the person's siblings.
     * 
     * Check for siblings based on mother and father relationships.
     */
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

    /**
     * Get the person's relationships on the left side.
     * 
     * A person may be listed on either the left or right side of a
     * relationship definition in the table.
     */
    public function relationships1() {
        return $this->belongsToMany('TaleOfOrigin\Person', 'person_relationships', 'person1_id', 'person2_id')
                    ->withPivot('relationship_id', 'role1_id', 'role2_id');
    }

    /**
     * Get the person's relationships on the right side.
     * 
     * A person may be listed on either the left or right side of a
     * relationship definition in the table.
     */
    public function relationships2() {
        return $this->belongsToMany('TaleOfOrigin\Person', 'person_relationships', 'person2_id', 'person1_id')
                    ->withPivot('relationship_id', 'role1_id', 'role2_id');
    }

    /**
     * Format a link to the person's information.
     */
    public function link() {
        return "<a href=\"". config('app.url') ."/person/". $this->id ."\">". $this->name ."</a>";
    }
    
    /**
     * Update the person's parent.
     */
    public function updateParent($role, $parent_id = null) {
        if( $role == "Father" ) {
            $parent = $this->father;
        }
        else {
            $parent = $this->mother;
        }
        if( $parent === null && $parent_id === null) {
            return;
        }
        elseif( $parent === null ) {
            PersonRelationship::create([
                'person1_id' => $parent_id,
                'role1_id' => Role::where('title', '=', $role)->first()->id,

                'person2_id' => $this->id,
                'role2_id' => $this->getChildRole(),

                'relationship_id' => Relationship::where('title', '=', 'Parent/Child')->first()->id
            ]);
        }
        else {
            if( $parent->id == $parent_id ) {
                return;
            }
            $relations = PersonRelationship::findRelation($this->id, $parent->id);
            foreach($relations->all() as $relate) {
                $relate->delete();
            }
            if( $parent_id === null ) {
                return;
            }
            PersonRelationship::create([
                'person1_id' => $parent_id,
                'role1_id' => Role::where('title', '=', $role)->first()->id,

                'person2_id' => $this->id,
                'role2_id' => $this->getChildRole(),

                'relationship_id' => Relationship::where('title', '=', 'Parent/Child')->first()->id
            ]);
        }
    }
    
    /**
     * Get the person's child role.
     */
    public function getChildRole() {
        if( !isset($this->gender_id) ) {
            return Role::where('title', '=', 'Child')->first()->id;
        }
        elseif( $this->gender_id == Gender::where('title', '=', 'Female')->first()->id ) {
            return Role::where('title', '=', 'Daughter')->first()->id;
        }
        elseif( $this->gender_id == Gender::where('title', '=', 'Female')->first()->id ) {
            return Role::where('title', '=', 'Son')->first()->id;
        }
        else {
            return Role::where('title', '=', 'Child')->first()->id;
        }
    }
}
