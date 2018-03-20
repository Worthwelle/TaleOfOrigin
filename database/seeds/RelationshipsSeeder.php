<?php

use Illuminate\Database\Seeder;
use TaleOfOrigin\Relationship;

class RelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Relationship::create(['title' => 'Parent/Child']);
        Relationship::create(['title' => 'Married']);
        Relationship::create(['title' => 'Dating']);
        Relationship::create(['title' => 'Adopted Parent/Child']);
        Relationship::create(['title' => 'Godparent/Godchild']);
        Relationship::create(['title' => 'Spouse']);
    }
}
