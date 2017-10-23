<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Gender;

class GendersTest extends TestCase
{
    
    /**
     * Insert a gender item without a custom slug.
     *
     * @return void
     */
    public function testInsertGenderWithoutSlug()
    {
        $this->post('/api/v1/gender', ['title' => 'Female'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'female',
                 'title' => 'Female'
             ]);
        $this->assertDatabaseHas('genders', ['slug' => 'female', 'title' => 'Female']);
    }
    
    /**
     * Insert a gender item without a custom slug.
     *
     * @return void
     */
    public function testInsertGenderWithoutTitle()
    {
        $this->post('/api/v1/gender', ['slug' => 'male'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'title' => ['The title field is required.'],
             ]);
        $this->assertDatabaseMissing('genders', ['slug' => 'male']);
    }
    
    /**
     * Retrieve a gender item.
     *
     * @depends testInsertGenderWithoutSlug
     * @return void
     */
    public function testShowGender()
    {
        $id = Gender::where('slug','female')->firstOrFail()->id;
        $this->get('/api/v1/gender/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'female',
                 'title' => 'Female'
             ]);
    }
    
    /**
     * Insert a gender item with a custom slug.
     *
     * @return void
     */
    public function testInsertGenderWithCustomSlug()
    {
        $this->post('/api/v1/gender/', ['slug' => 'ftm', 'title' => 'Female'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'ftm',
                 'title' => 'Female'
             ]);
        $this->assertDatabaseHas('genders', ['slug' => 'ftm', 'title' => 'Female']);
    }
    
    /**
     * Update a gender item.
     *
     * @depends testInsertGenderWithCustomSlug
     * @return void
     */
    public function testUpdateExistingGender()
    {
        $id = Gender::where('slug','ftm')->firstOrFail()->id;
        $this->put('/api/v1/gender/'.$id, ['title' => 'Female to Male'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'ftm',
                 'title' => 'Female to Male',
             ]);
        $this->assertDatabaseHas('genders', ['id' => $id, 'slug' => 'ftm', 'title' => 'Female to Male']);
    }
    
    /**
     * Update a non-existent gender item.
     *
     * @return void
     */
    public function testUpdateNonExistantGender()
    {
        $this->put('/api/v1/gender/10000', ['title' => 'Agender'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
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
        $id = Gender::where('slug','female')->firstOrFail()->id;
        $this->delete('/api/v1/gender/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('genders', ['id' => $id]);
    }
}
