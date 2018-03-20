<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GendersSeeder::class);
        $this->call(RelationshipsSeeder::class);
        $this->call(RolesSeeder::class);
    }
}
