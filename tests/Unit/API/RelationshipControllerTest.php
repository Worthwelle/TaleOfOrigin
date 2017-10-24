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
        $this->post('/api/v1/relationship', ['title' => 'Parent/Child'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'parentchild',
                 'title' => 'Parent/Child'
             ]);
        $this->assertDatabaseHas('relationships', ['slug' => 'parentchild', 'title' => 'Parent/Child']);
    }
    
    /**
     * Insert a relationship item without a custom slug.
     *
     * @return void
     */
    public function testInsertRelationshipWithoutTitle()
    {
        $this->post('/api/v1/relationship', ['slug' => 'dating'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'title' => ['The title field is required.'],
             ]);
        $this->assertDatabaseMissing('relationships', ['slug' => 'dating']);
    }
    
    /**
     * Retrieve a relationship item.
     *
     * @depends testInsertRelationshipWithoutSlug
     * @return void
     */
    public function testShowRelationship()
    {
        $id = Relationship::where('slug','parentchild')->firstOrFail()->id;
        $this->get('/api/v1/relationship/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'parentchild',
                 'title' => 'Parent/Child'
             ]);
    }
    
    /**
     * Insert a relationship item with a custom slug.
     *
     * @return void
     */
    public function testInsertRelationshipWithCustomSlug()
    {
        $this->post('/api/v1/relationship/', ['slug' => 'godparent-godchild', 'title' => 'Godparent/Godchild'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'godparent-godchild',
                 'title' => 'Godparent/Godchild'
             ]);
        $this->assertDatabaseHas('relationships', ['slug' => 'godparent-godchild', 'title' => 'Godparent/Godchild']);
    }
    
    /**
     * Update a relationship item.
     *
     * @depends testInsertRelationshipWithCustomSlug
     * @return void
     */
    public function testUpdateExistingRelationship()
    {
        $id = Relationship::where('slug','godparent-godchild')->firstOrFail()->id;
        $this->put('/api/v1/relationship/'.$id, ['title' => 'Godparent & Godchild'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'godparent-godchild',
                 'title' => 'Godparent & Godchild',
             ]);
        $this->assertDatabaseHas('relationships', ['id' => $id, 'slug' => 'godparent-godchild', 'title' => 'Godparent & Godchild']);
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
        $id = Relationship::where('slug','godparent-godchild')->firstOrFail()->id;
        $this->delete('/api/v1/relationship/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('relationships', ['id' => $id]);
    }
}
