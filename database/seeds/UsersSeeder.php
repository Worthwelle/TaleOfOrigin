<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('secret')
        ]);
        DB::table('users')->insert([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('secret')
        ]);
    }
}
