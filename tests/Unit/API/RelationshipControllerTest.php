<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Relationship;

class RelationshipControllerTest extends TestCase
{
    
    /**
     * Insert a relationship item without a custom slug.
     *
     * @return void
     */
    public function testInsertRelationshipWithoutSlug()
    {
        $this->post('/api/v1/relationship', ['title' => 'Friends'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'friends',
                 'title' => 'Friends'
             ]);
        $this->assertDatabaseHas('relationships', ['slug' => 'friends', 'title' => 'Friends']);
    }
    
    /**
     * Insert a relationship item without a custom slug.
     *
     * @return void
     */
    public function testInsertRelationshipWithoutTitle()
    {
        $this->post('/api/v1/relationship', ['slug' => 'buddies'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'title' => ['The title field is required.'],
             ]);
        $this->assertDatabaseMissing('relationships', ['slug' => 'buddies']);
    }
    
    /**
     * Retrieve a relationship item.
     *
     * @depends testInsertRelationshipWithoutSlug
     * @return void
     */
    public function testShowRelationship()
    {
        $id = Relationship::where('slug','friends')->firstOrFail()->id;
        $this->get('/api/v1/relationship/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'friends',
                 'title' => 'Friends'
             ]);
    }
    
    /**
     * Insert a relationship item with a custom slug.
     *
     * @return void
     */
    public function testInsertRelationshipWithCustomSlug()
    {
        $this->post('/api/v1/relationship/', ['slug' => 'cousins', 'title' => 'Cousins'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'cousins',
                 'title' => 'Cousins'
             ]);
        $this->assertDatabaseHas('relationships', ['slug' => 'cousins', 'title' => 'Cousins']);
    }
    
    /**
     * Update a relationship item.
     *
     * @depends testInsertRelationshipWithCustomSlug
     * @return void
     */
    public function testUpdateExistingRelationship()
    {
        $id = Relationship::where('slug','cousins')->firstOrFail()->id;
        $this->put('/api/v1/relationship/'.$id, ['title' => 'Cousin'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'cousins',
                 'title' => 'Cousin',
             ]);
        $this->assertDatabaseHas('relationships', ['id' => $id, 'slug' => 'cousins', 'title' => 'Cousin']);
    }
    
    /**
     * Update a non-existent relationship item.
     *
     * @return void
     */
    public function testUpdateNonExistantRelationship()
    {
        $this->put('/api/v1/relationship/10000', ['title' => 'Dating'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('relationships', ['id' => '1000']);
    }
    
    /**
     * Delete a relationship item
     * 
     * @depends testShowRelationship
     * @return void
     */
    public function testRemoveRelationship() {
        $id = Relationship::where('slug','cousins')->firstOrFail()->id;
        $this->delete('/api/v1/relationship/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('relationships', ['id' => $id]);
    }
}
