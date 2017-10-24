<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Person;
use TaleOfOrigin\User;
use TaleOfOrigin\Tree;
use TaleOfOrigin\Gender;
use TaleOfOrigin\Religion;
use TaleOfOrigin\Role;

class PersonControllerTest extends TestCase
{
    
    /**
     * Insert a person item without a custom slug.
     *
     * @return void
     */
    public function testInsertPerson()
    {
        $user1 = User::firstOrCreate([
            'name' => 'George Washington, Jr.',
            'email' => 'george@example.com',
            'password' => 'test'
        ]);
        $tree1 = Tree::firstOrCreate([
            'user_id' => $user1->id,
            'title' => 'Washington Family Tree',
        ]);
        $gender1 = Gender::firstOrCreate(['title' => 'Person Gender'])->id;
        $religion1 = Religion::firstOrCreate(['title' => 'Person Religion'])->id;
        Role::firstOrCreate(['title' => 'Father']);
        Role::firstOrCreate(['title' => 'Mother']);
        
        $this->post('/api/v1/person', [
            'tree_id' => $tree1->id,
            'name' => 'George Washington',
            'birth' => '1732-02-22',
            'death' => '1799-12-14',
            'gender_id' => $gender1,
            'religion' => $religion1,
            'cause_of_death' => null,
            'notes' => null], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                'tree_id' => $tree1->id,
                'name' => 'George Washington',
                'gender_id' => $gender1,
                'religion' => $religion1,
                'cause_of_death' => null,
                'notes' => null
             ]);
        $this->assertDatabaseHas('people', [
            'tree_id' => $tree1->id,
            'name' => 'George Washington',
            'gender_id' => $gender1,
            'religion' => $religion1,
            'cause_of_death' => null,
            'notes' => null
        ]);
    }
    
    /**
     * Retrieve a person item.
     *
     * @depends testInsertPerson
     * @return void
     */
    public function testShowPerson()
    {
        $id = Person::where('name','George Washington')->firstOrFail()->id;
        $this->get('/api/v1/person/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                'tree_id' => Tree::where('title', '=', 'Washington Family Tree')->firstOrFail()->id,
                'name' => 'George Washington',
                'gender_id' => Gender::where('title', '=', 'Person Gender')->firstOrFail()->id,
                'religion' => Religion::where('title', '=', 'Person Religion')->firstOrFail()->id,
                'cause_of_death' => null,
                'notes' => null
             ]);
    }
    
    /**
     * Update a person item.
     *
     * @depends testInsertPerson
     * @return void
     */
    public function testUpdateExistingPerson()
    {
        $id = Person::where('name','George Washington')->firstOrFail()->id;
        $gender = Gender::where('title', '=', 'Person Gender')->firstOrFail()->id;
        $religion = Religion::where('title', '=', 'Person Religion')->firstOrFail()->id;
               
        $this->put('/api/v1/person/'.$id, [
                'tree_id' => Tree::where('title', '=', 'Washington Family Tree')->firstOrFail()->id,
                'name' => 'George Washington, Sr.'
            ], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                'id' => $id,
                'tree_id' => Tree::where('title', '=', 'Washington Family Tree')->firstOrFail()->id,
                'name' => 'George Washington, Sr.',
                'gender_id' => $gender,
                'religion' => $religion,
                'cause_of_death' => null,
                'notes' => null
             ]);
        $this->assertDatabaseHas('people', ['id' => $id,
            'tree_id' => Tree::where('title', '=', 'Washington Family Tree')->firstOrFail()->id,
            'name' => 'George Washington, Sr.',
            'gender_id' => $gender,
            'religion' => $religion,
            'cause_of_death' => null,
            'notes' => null
        ]);
    }
    
    /**
     * Update a non-existent person item.
     *
     * @return void
     */
    public function testUpdateNonExistantPerson()
    {
        $this->put('/api/v1/person/10000', ['tree_id' => Tree::where('title', '=', 'Washington Family Tree')->firstOrFail()->id, 'name' => 'George Washington Carver'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('people', ['id' => '1000']);
    }
    
    /**
     * Delete a religion item
     * 
     * @depends testShowPerson
     * @return void
     */
    public function testRemovePerson() {
        $id = Person::where('name','George Washington, Sr.')->firstOrFail()->id;
        $this->delete('/api/v1/person/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('people', ['id' => $id]);
    }
}
