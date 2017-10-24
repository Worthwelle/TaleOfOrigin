<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\User;

class UserControllerTest extends TestCase
{
    
    /**
     * Insert a user item without a custom slug.
     *
     * @return void
     */
    public function testInsertUser()
    {
        $this->post('/api/v1/user', [
            'name' => "A Test User",
            'email' => 'testing@example.com',
            'password' => bcrypt('testpass')
        ], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
            'name' => "A Test User",
            'email' => 'testing@example.com'
             ]);
        $this->assertDatabaseHas('users', [
            'name' => "A Test User",
            'email' => 'testing@example.com'
        ]);
    }
    
    /**
     * Retrieve a user item.
     *
     * @depends testInsertUser
     * @return void
     */
    public function testShowUser()
    {
        $id = User::where('name','A Test User')->firstOrFail()->id;
        $this->get('/api/v1/user/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                'name' => "A Test User",
                'email' => 'testing@example.com'
             ]);
    }
    
    /**
     * Update a user item.
     *
     * @depends testInsertUser
     * @return void
     */
    public function testUpdateExistingUser()
    {
        $id = User::where('name','A Test User')->firstOrFail()->id;
        $this->put('/api/v1/user/'.$id, ['name' => "Testing User", 'email' => 'testing@example.com'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                'name' => "Testing User",
                'email' => 'testing@example.com'
             ]);
        $this->assertDatabaseHas('users', ['name' => "Testing User", 'email' => 'testing@example.com']);
    }
    
    /**
     * Update a non-existent user item.
     *
     * @return void
     */
    public function testUpdateNonExistantUser()
    {
        $this->put('/api/v1/user/10000', ['name' => "Running User", 'email' => 'running.com'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('users', ['id' => '1000']);
    }
    
    /**
     * Delete a religion item
     * 
     * @depends testShowUser
     * @return void
     */
    public function testRemoveUser() {
        $id = User::where('name','Testing User')->firstOrFail()->id;
        $this->delete('/api/v1/user/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('users', ['id' => $id]);
    }
}
