<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tree_id')->unsigned();
            $table->string('name');
            $table->datetime('birth')->nullable();
            $table->datetime('death')->nullable();
            $table->integer('gender_id')->unsigned()->nullable();
            $table->integer('religion')->unsigned()->nullable();
            $table->string('cause_of_death')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('people');
    }
}
