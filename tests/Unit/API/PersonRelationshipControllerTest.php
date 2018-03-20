<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\PersonRelationship;
use TaleOfOrigin\User;
use TaleOfOrigin\Tree;
use TaleOfOrigin\Gender;
use TaleOfOrigin\Person;
use TaleOfOrigin\Role;
use TaleOfOrigin\Relationship;

class PersonRelationshipsTest extends TestCase
{
    
    /**
     * Insert a person_relationship item without a custom slug.
     *
     * @return void
     */
    public function testInsertPersonRelationship()
    {
        $user1 = User::firstOrCreate([
            'name' => 'Martin Luther King III',
            'email' => 'martin@example.com',
            'password' => 'test'
        ]);
        $tree1 = Tree::firstOrCreate([
            'user_id' => $user1->id,
            'title' => 'Martin Luther King Jr Family Tree',
        ]);
        $role1 = Role::firstOrCreate(['title' => 'Husband'])->id;
        $role2 = Role::firstOrCreate(['title' => 'Wife'])->id;
        $relationship = Relationship::firstOrCreate(['title' => 'Married'])->id;
        $person1 = Person::firstOrCreate(['tree_id' => $tree1->id, 'name' => 'Martin Luther King Jr.'])->id;
        $person2 = Person::firstOrCreate(['tree_id' => $tree1->id, 'name' => 'Coretta Scott King'])->id;
        
        $this->post('/api/v1/person_relationship', [
            'person1_id' => $person1,
            'person2_id' => $person2,
            'relationship_id' => $relationship,
            'role1_id' => $role1,
            'role2_id' => $role2
        ], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
            'person1_id' => $person1,
            'person2_id' => $person2,
            'relationship_id' => $relationship,
            'role1_id' => $role1,
            'role2_id' => $role2
             ]);
        $this->assertDatabaseHas('person_relationships', [
            'person1_id' => $person1,
            'person2_id' => $person2,
            'relationship_id' => $relationship,
            'role1_id' => $role1,
            'role2_id' => $role2
             ]);
    }
    
    /**
     * Find a person_relationship item
     * 
     * @depends testInsertPersonRelationship
     * @return void
     */
    public function testFindPersonRelationship() {
        $person1 = Person::where('name', 'Martin Luther King Jr.')->firstOrFail()->id;
        $person2 = Person::where('name', 'Coretta Scott King')->firstOrFail()->id;
        $person_relationship = PersonRelationship::where([
            'person1_id' => $person1,
            'person2_id' => $person2,
        ])->firstOrFail();
        $foundRelation = PersonRelationship::findRelation($person1, $person2)->first();
        $this->assertEquals($person_relationship->id, $foundRelation->id);
    }
    
    /**
     * Retrieve a person_relationship item.
     *
     * @depends testInsertPersonRelationship
     * @return void
     */
    public function testShowPersonRelationship()
    {
        $person = Person::where('name', '=', 'Martin Luther King Jr.')->firstOrFail();
        $id = PersonRelationship::where('person1_id',$person->id)->firstOrFail()->id;
        $this->get('/api/v1/person_relationship/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'person1_id' => $person->id
             ]);
    }
    
    /**
     * Update a person_relationship item.
     *
     * @depends testInsertPersonRelationship
     * @return void
     */
    public function testUpdateExistingPersonRelationship()
    {
        $person = Person::where('name', '=', 'Martin Luther King Jr.')->firstOrFail();
        $id = PersonRelationship::where('person1_id',$person->id)->firstOrFail()->id;
        $relationship = Relationship::firstOrCreate(['title' => 'Husband/Wife']);
        $this->put('/api/v1/person_relationship/'.$id, ['relationship_id' => $relationship->id], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'person1_id' => $person->id,
                 'relationship_id' => $relationship->id
             ]);
        $this->assertDatabaseHas('person_relationships', ['person1_id' => $person->id, 'relationship_id' => $relationship->id]);
    }
    
    /**
     * Update a non-existent person_relationship item.
     *
     * @return void
     */
    public function testUpdateNonExistantPersonRelationship()
    {
        $this->put('/api/v1/person_relationship/10000', ['relationship' => 5], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('person_relationships', ['id' => '1000']);
    }
    
    /**
     * Delete a person_relationship item
     * 
     * @depends testShowPersonRelationship
     * @return void
     */
    public function testRemovePersonRelationship() {
        $person = Person::where('name', '=', 'Martin Luther King Jr.')->firstOrFail();
        $id = PersonRelationship::where('person1_id',$person->id)->firstOrFail()->id;
        $this->delete('/api/v1/person_relationship/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('person_relationships', ['id' => $id]);
    }
    
    /**
     * Update a person_relationship item using the updateFather function
     * 
     * @depends testFindPersonRelationship
     * @return void
     */
    public function testAddFatherMethod() {
        $user = User::where('email', 'martin@example.com')->firstOrFail();
        $gender_id = Gender::where('slug', 'male')->firstOrFail()->id;
        $tree1 = Tree::firstOrCreate(['user_id' => $user->id, 'title' => 'Nelson Mandela Family Tree']);
        $person1 = Person::firstOrCreate(['tree_id' => $tree1->id, 'name' => 'Nelson Mandela', 'gender_id' => $gender_id]);
        $person2 = Person::firstOrCreate(['tree_id' => $tree1->id, 'name' => 'Gadla Henry Mphakanyiswa Mandela']);
        $person1->updateParent("Father", $person2->id);
        if( $person1->id <= $person2->id ) {
            $this->assertDatabaseHas('person_relationships', ['person1_id' => $person1->id, 'person2_id' => $person2->id]);
        }
        else {
            $this->assertDatabaseHas('person_relationships', ['person1_id' => $person2->id, 'person2_id' => $person1->id]);
        }
    }
    
    /**
     * Update a person_relationship item using the updateMother function
     * 
     * @depends testAddFatherMethod
     * @return void
     */
    public function testUpdateFatherMethod() {
        $user = User::where('email', 'martin@example.com')->firstOrFail();
        $gender_id = Gender::where('slug', 'male')->firstOrFail()->id;
        $tree1 = Tree::firstOrCreate(['user_id' => $user->id, 'title' => 'Nelson Mandela Family Tree']);
        $person1 = Person::where('name', 'Nelson Mandela')->firstOrFail();
        $person2 = Person::firstOrCreate(['tree_id' => $tree1->id, 'name' => 'Gadla Mphakanyiswa Mandela']);
        $person1->updateParent("Father", $person2->id);
        if( $person1->id <= $person2->id ) {
            $this->assertDatabaseHas('person_relationships', ['person1_id' => $person1->id, 'person2_id' => $person2->id]);
        }
        else {
            $this->assertDatabaseHas('person_relationships', ['person1_id' => $person2->id, 'person2_id' => $person1->id]);
        }
    }
    
    /**
     * Delete a person_relationship item using the updateMother function
     * 
     * @depends testUpdateFatherMethod
     * @return void
     */
    public function testDeleteFatherMethod() {
        $person1 = Person::where('name', 'Nelson Mandela')->firstOrFail();
        $father_id = $person1->father_id;
        $person1->updateParent("Father");
        if( $person1->id <= $father_id ) {
            $this->assertDatabaseMissing('person_relationships', ['person1_id' => $person1->id, 'person2_id' => $father_id]);
        }
        else {
            $this->assertDatabaseMissing('person_relationships', ['person1_id' => $father_id, 'person2_id' => $person1->id]);
        }
    }
}
