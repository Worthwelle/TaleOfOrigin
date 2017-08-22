<?php

use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert(['gender' => 'Agender']);
        DB::table('genders')->insert(['gender' => 'Androgyne']);
        DB::table('genders')->insert(['gender' => 'Androgynous']);
        DB::table('genders')->insert(['gender' => 'Bigender']);
        DB::table('genders')->insert(['gender' => 'Cis']);
        DB::table('genders')->insert(['gender' => 'Cisgender']);
        DB::table('genders')->insert(['gender' => 'Cis Female']);
        DB::table('genders')->insert(['gender' => 'Cis Male']);
        DB::table('genders')->insert(['gender' => 'Cis Man']);
        DB::table('genders')->insert(['gender' => 'Cis Woman']);
        DB::table('genders')->insert(['gender' => 'Cisgender Female']);
        DB::table('genders')->insert(['gender' => 'Cisgender Male']);
        DB::table('genders')->insert(['gender' => 'Cisgender Man']);
        DB::table('genders')->insert(['gender' => 'Cisgender Woman']);
        DB::table('genders')->insert(['gender' => 'Female']);
        DB::table('genders')->insert(['gender' => 'Female to Male']);
        DB::table('genders')->insert(['gender' => 'Gender Fluid']);
        DB::table('genders')->insert(['gender' => 'Gender Nonconforming']);
        DB::table('genders')->insert(['gender' => 'Gender Questioning']);
        DB::table('genders')->insert(['gender' => 'Gender Variant']);
        DB::table('genders')->insert(['gender' => 'Genderqueer']);
        DB::table('genders')->insert(['gender' => 'Intersex']);
        DB::table('genders')->insert(['gender' => 'Male']);
        DB::table('genders')->insert(['gender' => 'Male to Female']);
        DB::table('genders')->insert(['gender' => 'Neither']);
        DB::table('genders')->insert(['gender' => 'Neutrois']);
        DB::table('genders')->insert(['gender' => 'Non-binary']);
        DB::table('genders')->insert(['gender' => 'Other']);
        DB::table('genders')->insert(['gender' => 'Pangender']);
        DB::table('genders')->insert(['gender' => 'Trans']);
        DB::table('genders')->insert(['gender' => 'Trans*']);
        DB::table('genders')->insert(['gender' => 'Trans Female']);
        DB::table('genders')->insert(['gender' => 'Trans* Female']);
        DB::table('genders')->insert(['gender' => 'Trans Male']);
        DB::table('genders')->insert(['gender' => 'Trans* Male']);
        DB::table('genders')->insert(['gender' => 'Trans Man']);
        DB::table('genders')->insert(['gender' => 'Trans* Man']);
        DB::table('genders')->insert(['gender' => 'Trans Person']);
        DB::table('genders')->insert(['gender' => 'Trans* Person']);
        DB::table('genders')->insert(['gender' => 'Trans Woman']);
        DB::table('genders')->insert(['gender' => 'Trans* Woman']);
        DB::table('genders')->insert(['gender' => 'Transfeminine']);
        DB::table('genders')->insert(['gender' => 'Transgender']);
        DB::table('genders')->insert(['gender' => 'Transgender Female']);
        DB::table('genders')->insert(['gender' => 'Transgender Male']);
        DB::table('genders')->insert(['gender' => 'Transgender Man']);
        DB::table('genders')->insert(['gender' => 'Transgender Person']);
        DB::table('genders')->insert(['gender' => 'Transgender Woman']);
        DB::table('genders')->insert(['gender' => 'Transmasculine']);
        DB::table('genders')->insert(['gender' => 'Transsexual']);
        DB::table('genders')->insert(['gender' => 'Transsexual Female']);
        DB::table('genders')->insert(['gender' => 'Transsexual Male']);
        DB::table('genders')->insert(['gender' => 'Transsexual Man']);
        DB::table('genders')->insert(['gender' => 'Transsexual Person']);
        DB::table('genders')->insert(['gender' => 'Transsexual Woman']);
        DB::table('genders')->insert(['gender' => 'Two-Spirit']);
    }
}
