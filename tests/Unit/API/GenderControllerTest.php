<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Gender;

class GenderControllerTest extends TestCase
{
    
    /**
     * Insert a gender item without a custom slug.
     *
     * @return void
     */
    public function testInsertGenderWithoutSlug()
    {
        $this->post('/api/v1/gender', ['title' => 'newGender'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'newgender',
                 'title' => 'newGender'
             ]);
        $this->assertDatabaseHas('genders', ['slug' => 'newgender', 'title' => 'newGender']);
    }
    
    /**
     * Insert a gender item without a custom slug.
     *
     * @return void
     */
    public function testInsertGenderWithoutTitle()
    {
        $this->post('/api/v1/gender', ['slug' => 'secondGender'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'title' => ['The title field is required.'],
             ]);
        $this->assertDatabaseMissing('genders', ['slug' => 'secondGender']);
    }
    
    /**
     * Retrieve a gender item.
     *
     * @depends testInsertGenderWithoutSlug
     * @return void
     */
    public function testShowGender()
    {
        $id = Gender::where('slug','newgender')->firstOrFail()->id;
        $this->get('/api/v1/gender/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'newgender',
                 'title' => 'newGender'
             ]);
    }
    
    /**
     * Insert a gender item with a custom slug.
     *
     * @return void
     */
    public function testInsertGenderWithCustomSlug()
    {
        $this->post('/api/v1/gender/', ['slug' => 'ng', 'title' => 'newGender2'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'ng',
                 'title' => 'newGender2'
             ]);
        $this->assertDatabaseHas('genders', ['slug' => 'ng', 'title' => 'newGender2']);
    }
    
    /**
     * Update a gender item.
     *
     * @depends testInsertGenderWithCustomSlug
     * @return void
     */
    public function testUpdateExistingGender()
    {
        $id = Gender::where('slug','ng')->firstOrFail()->id;
        $this->put('/api/v1/gender/'.$id, ['title' => 'newGender3'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'ng',
                 'title' => 'newGender3',
             ]);
        $this->assertDatabaseHas('genders', ['id' => $id, 'slug' => 'ng', 'title' => 'newGender3']);
    }
    
    /**
     * Update a non-existent gender item.
     *
     * @return void
     */
    public function testUpdateNonExistantGender()
    {
        $this->put('/api/v1/gender/10000', ['title' => 'Non-Gender'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('genders', ['id' => '1000']);
    }
    
    /**
     * Delete a gender item
     * 
     * @depends testShowGender
     * @return void
     */
    public function testRemoveGender() {
        $id = Gender::where('slug','ng')->firstOrFail()->id;
        $this->delete('/api/v1/gender/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('genders', ['id' => $id]);
    }
}
