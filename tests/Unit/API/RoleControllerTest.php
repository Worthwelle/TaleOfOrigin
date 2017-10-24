<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Role;

class RoleControllerTest extends TestCase
{
    
    /**
     * Insert a role item without a custom slug.
     *
     * @return void
     */
    public function testInsertRoleWithoutSlug()
    {
        $this->post('/api/v1/role', ['title' => 'Father'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'father',
                 'title' => 'Father'
             ]);
        $this->assertDatabaseHas('roles', ['slug' => 'father', 'title' => 'Father']);
    }
    
    /**
     * Insert a role item without a custom slug.
     *
     * @return void
     */
    public function testInsertRoleWithoutTitle()
    {
        $this->post('/api/v1/role', ['slug' => 'grandfather'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'title' => ['The title field is required.'],
             ]);
        $this->assertDatabaseMissing('roles', ['slug' => 'grandfather']);
    }
    
    /**
     * Retrieve a role item.
     *
     * @depends testInsertRoleWithoutSlug
     * @return void
     */
    public function testShowRole()
    {
        $id = Role::where('slug','father')->firstOrFail()->id;
        $this->get('/api/v1/role/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'father',
                 'title' => 'Father'
             ]);
    }
    
    /**
     * Insert a role item with a custom slug.
     *
     * @return void
     */
    public function testInsertRoleWithCustomSlug()
    {
        $this->post('/api/v1/role/', ['slug' => 'mom', 'title' => 'Mother'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'mom',
                 'title' => 'Mother'
             ]);
        $this->assertDatabaseHas('roles', ['slug' => 'mom', 'title' => 'Mother']);
    }
    
    /**
     * Update a role item.
     *
     * @depends testInsertRoleWithCustomSlug
     * @return void
     */
    public function testUpdateExistingRole()
    {
        $id = Role::where('slug','mom')->firstOrFail()->id;
        $this->put('/api/v1/role/'.$id, ['slug' => 'mother'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'slug' => 'mother',
                 'title' => 'Mother',
             ]);
        $this->assertDatabaseHas('roles', ['id' => $id, 'slug' => 'mother', 'title' => 'Mother']);
    }
    
    /**
     * Update a non-existent role item.
     *
     * @return void
     */
    public function testUpdateNonExistantRole()
    {
        $this->put('/api/v1/role/10000', ['title' => 'Grandfather'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('roles', ['id' => '1000']);
    }
    
    /**
     * Delete a role item
     * 
     * @depends testShowRole
     * @return void
     */
    public function testRemoveRole() {
        $id = Role::where('slug','mother')->firstOrFail()->id;
        $this->delete('/api/v1/role/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('roles', ['id' => $id]);
    }
}
