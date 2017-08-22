<?php

use Illuminate\Database\Seeder;
use TaleOfOrigin\Religion;

class ReligionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Religion::create(['title' => 'Christianity']);
        Religion::create(['title' => 'Jahovah\'s Witness']);
        Religion::create(['title' => 'Islam']);
        Religion::create(['title' => 'Secular']);
        Religion::create(['title' => 'Nonreligious']);
        Religion::create(['title' => 'Agnostic']);
        Religion::create(['title' => 'Atheist']);
        Religion::create(['title' => 'Hinduism']);
        Religion::create(['title' => 'Chinese traditional religion']);
        Religion::create(['title' => 'Buddhism']);
        Religion::create(['title' => 'African traditional religion']);
        Religion::create(['title' => 'Sikhism']);
        Religion::create(['title' => 'Spiritism']);
        Religion::create(['title' => 'Judaism']);
        Religion::create(['title' => 'Bahá\'í']);
        Religion::create(['title' => 'Jainism']);
        Religion::create(['title' => 'Shinto']);
        Religion::create(['title' => 'Cao Dai']);
        Religion::create(['title' => 'Zoroastrianism']);
        Religion::create(['title' => 'Tenrikyo']);
        Religion::create(['title' => 'Neo-Paganism']);
        Religion::create(['title' => 'Unitarian Universalism']);
        Religion::create(['title' => 'Rastafarianism']);
    }
}
