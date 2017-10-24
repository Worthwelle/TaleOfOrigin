<?php

namespace Tests\Unit\API;

use Tests\TestCase;
use TaleOfOrigin\Tree;
use TaleOfOrigin\User;

class TreeTest extends TestCase
{
    
    /**
     * Insert a tree item.
     *
     * @return void
     */
    public function testInsertTree()
    {
        $user1 = User::create([
            'name' => 'Test1 User',
            'email' => 'testuser@example.com',
            'password' => 'test'
        ]);
        
        $this->post('/api/v1/tree', ['user_id' => $user1->id, 'title' => 'King Family Tree'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'user_id' => $user1->id,
                 'title' => 'King Family Tree'
             ]);
        $this->assertDatabaseHas('trees', ['user_id' => $user1->id, 'title' => 'King Family Tree']);
    }
    
    /**
     * Retrieve a tree item.
     *
     * @depends testInsertTree
     * @return void
     */
    public function testShowTree()
    {
        $id = Tree::where('title','King Family Tree')->firstOrFail()->id;
        $this->get('/api/v1/tree/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'user_id' => User::where('name', '=', 'Test1 User')->firstOrFail()->id,
                 'title' => 'King Family Tree'
             ]);
    }
    
    /**
     * Update a tree item.
     *
     * @depends testInsertTree
     * @return void
     */
    public function testUpdateExistingTree()
    {
        $id = Tree::where('title','King Family Tree')->firstOrFail()->id;
        $this->put('/api/v1/tree/'.$id, ['title' => 'Gandhi Family Tree'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'user_id' => User::where('name', '=', 'Test1 User')->firstOrFail()->id,
                 'title' => 'Gandhi Family Tree',
             ]);
        $this->assertDatabaseHas('trees', ['user_id' => User::where('name', '=', 'Test1 User')->firstOrFail()->id, 'title' => 'Gandhi Family Tree']);
    }
    
    /**
     * Update a non-existent tree item.
     *
     * @return void
     */
    public function testUpdateNonExistantTree()
    {
        $this->put('/api/v1/tree/10000', ['title' => 'Mandela Family Tree'], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
             ->assertJson([
                 'error' => '404',
             ]);
        $this->assertDatabaseMissing('trees', ['id' => '1000']);
    }
    
    /**
     * Delete a tree item
     * 
     * @depends testUpdateExistingTree
     * @return void
     */
    public function testRemoveTree() {
        $id = Tree::where('title','Gandhi Family Tree')->firstOrFail()->id;
        $this->delete('/api/v1/tree/'.$id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $this->assertDatabaseMissing('trees', ['id' => $id]);
    }
}
