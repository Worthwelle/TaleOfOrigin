<?php

use Illuminate\Database\Seeder;
use TaleOfOrigin\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['title' => 'Father']);
        Role::create(['title' => 'Mother']);
        Role::create(['title' => 'Son']);
        Role::create(['title' => 'Daughter']);
        Role::create(['title' => 'Child']);
        Role::create(['title' => 'Parent']);
        Role::create(['title' => 'Spouse']);
        Role::create(['title' => 'Significant other']);
        Role::create(['title' => 'Adopted Parent']);
        Role::create(['title' => 'Adopted Child']);
        Role::create(['title' => 'Adopted Father']);
        Role::create(['title' => 'Adopted Mother']);
        Role::create(['title' => 'Adopted Son']);
        Role::create(['title' => 'Adopted Daughter']);
        Role::create(['title' => 'Godparent']);
        Role::create(['title' => 'Godchild']);
        Role::create(['title' => 'Godfather']);
        Role::create(['title' => 'Godmother']);
        Role::create(['title' => 'Godson']);
        Role::create(['title' => 'Goddaughter']);
        Role::create(['title' => 'Husband']);
        Role::create(['title' => 'Wife']);
        Role::create(['title' => 'Spouse']);
    }
}
