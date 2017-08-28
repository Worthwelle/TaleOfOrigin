<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person1_id')->unsigned();
            $table->integer('person2_id')->unsigned();
            $table->integer('relationship_id')->unsigned();
            $table->integer('role1_id')->nullable()->unsigned();
            $table->integer('role2_id')->nullable()->unsigned();
            $table->timestamps();
            
            $table->unique(array('person1_id', 'person2_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_relationships');
    }
}
