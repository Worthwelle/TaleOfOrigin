<?php

use Illuminate\Database\Seeder;

class ReligionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->insert(['religion' => 'Christianity']);
        DB::table('religions')->insert(['religion' => 'Jahovah\'s Witness']);
        DB::table('religions')->insert(['religion' => 'Islam']);
        DB::table('religions')->insert(['religion' => 'Secular']);
        DB::table('religions')->insert(['religion' => 'Nonreligious']);
        DB::table('religions')->insert(['religion' => 'Agnostic']);
        DB::table('religions')->insert(['religion' => 'Atheist']);
        DB::table('religions')->insert(['religion' => 'Hinduism']);
        DB::table('religions')->insert(['religion' => 'Chinese traditional religion']);
        DB::table('religions')->insert(['religion' => 'Buddhism']);
        DB::table('religions')->insert(['religion' => 'African traditional religion']);
        DB::table('religions')->insert(['religion' => 'Sikhism']);
        DB::table('religions')->insert(['religion' => 'Spiritism']);
        DB::table('religions')->insert(['religion' => 'Judaism']);
        DB::table('religions')->insert(['religion' => 'Bahá\'í']);
        DB::table('religions')->insert(['religion' => 'Jainism']);
        DB::table('religions')->insert(['religion' => 'Shinto']);
        DB::table('religions')->insert(['religion' => 'Cao Dai']);
        DB::table('religions')->insert(['religion' => 'Zoroastrianism']);
        DB::table('religions')->insert(['religion' => 'Tenrikyo']);
        DB::table('religions')->insert(['religion' => 'Neo-Paganism']);
        DB::table('religions')->insert(['religion' => 'Unitarian Universalism']);
        DB::table('religions')->insert(['religion' => 'Rastafarianism']);
    }
}
