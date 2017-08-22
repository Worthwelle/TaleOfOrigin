<?php

use Illuminate\Database\Seeder;
use TaleOfOrigin\Gender;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Gender::create(['title' => 'Agender']);
         Gender::create(['title' => 'Androgyne']);
         Gender::create(['title' => 'Androgynous']);
         Gender::create(['title' => 'Bigender']);
         Gender::create(['title' => 'Cis']);
         Gender::create(['title' => 'Cisgender']);
         Gender::create(['title' => 'Cis Female']);
         Gender::create(['title' => 'Cis Male']);
         Gender::create(['title' => 'Cis Man']);
         Gender::create(['title' => 'Cis Woman']);
         Gender::create(['title' => 'Cisgender Female']);
         Gender::create(['title' => 'Cisgender Male']);
         Gender::create(['title' => 'Cisgender Man']);
         Gender::create(['title' => 'Cisgender Woman']);
         Gender::create(['title' => 'Female']);
         Gender::create(['title' => 'Female to Male']);
         Gender::create(['title' => 'Gender Fluid']);
         Gender::create(['title' => 'Gender Nonconforming']);
         Gender::create(['title' => 'Gender Questioning']);
         Gender::create(['title' => 'Gender Variant']);
         Gender::create(['title' => 'Genderqueer']);
         Gender::create(['title' => 'Intersex']);
         Gender::create(['title' => 'Male']);
         Gender::create(['title' => 'Male to Female']);
         Gender::create(['title' => 'Neither']);
         Gender::create(['title' => 'Neutrois']);
         Gender::create(['title' => 'Non-binary']);
         Gender::create(['title' => 'Other']);
         Gender::create(['title' => 'Pangender']);
         Gender::create(['title' => 'Trans']);
         Gender::create(['title' => 'Trans*', 'slug' => 'trans-star']);
         Gender::create(['title' => 'Trans Female']);
         Gender::create(['title' => 'Trans* Female', 'slug' => 'trans-star-female']);
         Gender::create(['title' => 'Trans Male']);
         Gender::create(['title' => 'Trans* Male', 'slug' => 'trans-star-male']);
         Gender::create(['title' => 'Trans Man']);
         Gender::create(['title' => 'Trans* Man', 'slug' => 'trans-star-man']);
         Gender::create(['title' => 'Trans Person']);
         Gender::create(['title' => 'Trans* Person', 'slug' => 'trans-star-person']);
         Gender::create(['title' => 'Trans Woman']);
         Gender::create(['title' => 'Trans* Woman', 'slug' => 'trans-star-woman']);
         Gender::create(['title' => 'Transfeminine']);
         Gender::create(['title' => 'Transgender']);
         Gender::create(['title' => 'Transgender Female']);
         Gender::create(['title' => 'Transgender Male']);
         Gender::create(['title' => 'Transgender Man']);
         Gender::create(['title' => 'Transgender Person']);
         Gender::create(['title' => 'Transgender Woman']);
         Gender::create(['title' => 'Transmasculine']);
         Gender::create(['title' => 'Transsexual']);
         Gender::create(['title' => 'Transsexual Female']);
         Gender::create(['title' => 'Transsexual Male']);
         Gender::create(['title' => 'Transsexual Man']);
         Gender::create(['title' => 'Transsexual Person']);
         Gender::create(['title' => 'Transsexual Woman']);
         Gender::create(['title' => 'Two-Spirit']);
    }
}
