<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Religion;

class ReligionsTest extends TestCase
{
    
    /**
     * Insert a religion item without a custom slug.
     *
     * @return void
     */
    public function testInsertReligionWithoutSlug()
    {
        $this->post('/api/v1/religion', ['title' => 'Unknown'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'unknown',
                 'title' => 'Unknown'
             ]);
        $this->assertDatabaseHas('religions', ['slug' => 'unknown', 'title' => 'Unknown']);
    }
    
    /**
     * Insert a religion item without a custom slug.
     *
     * @return void
     */
    public function testInsertReligionWithoutTitle()
    {
        $this->post('/api/v1/religion', ['slug' => 'christian'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'title' => ['The title field is required.'],
             ]);
        $this->assertDatabaseMissing('religions', ['slug' => 'christian']);
    }
    
    /**
     * Retrieve a religion item.
     *
     * @depends testInsertReligionWithoutSlug
     * @return void
     */
    public function testShowReligion()
    {
        $id = Religion::where('slug','unknown')->firstOrFail()->id;
        $this->get('/api/v1/religion/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'unknown',
                 'title' => 'Unknown'
             ]);
    }
    
    /**
     * Insert a religion item with a custom slug.
     *
     * @return void
     */
    public function testInsertReligionWithCustomSlug()
    {
        $this->post('/api/v1/religion/', ['slug' => 'jahovahs-witness', 'title' => 'Jahovah\'s Witness'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'jahovahs-witness',
                 'title' => 'Jahovah\'s Witness'
             ]);
        $this->assertDatabaseHas('religions', ['slug' => 'jahovahs-witness', 'title' => 'Jahovah\'s Witness']);
    }
    
    /**
     * Update a religion item.
     *
     * @depends testInsertReligionWithCustomSlug
     * @return void
     */
    public function testUpdateExistingReligion()
    {
        $id = Religion::where('slug','jahovahs-witness')->firstOrFail()->id;
        $this->put('/api/v1/religion/'.$id, ['title' => 'Jahovas Witness'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'jahovahs-witness',
                 'title' => 'Jahovas Witness',
             ]);
        $this->assertDatabaseHas('religions', ['id' => $id, 'slug' => 'jahovahs-witness', 'title' => 'Jahovas Witness']);
    }
    
    /**
     * Update a non-existent religion item.
     *
     * @return void
     */
    public function testUpdateNonExistantReligion()
    {
        $this->put('/api/v1/religion/10000', ['title' => 'Hinduism'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('religions', ['id' => '1000']);
    }
    
    /**
     * Delete a religion item
     * 
     * @depends testShowReligion
     * @return void
     */
    public function testRemoveReligion() {
        $id = Religion::where('slug','jahovahs-witness')->firstOrFail()->id;
        $this->delete('/api/v1/religion/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('religions', ['id' => $id]);
    }
}
