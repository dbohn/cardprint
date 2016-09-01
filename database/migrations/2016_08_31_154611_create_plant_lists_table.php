<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kew_id');
            $table->string('major_group');
            $table->string('family');
            $table->string('genus_hybrid', 1)->nullable()->default(null);
            $table->string('genus', 100);
            $table->string('species_hybrid', 1)->nullable()->default(null);
            $table->string('species', 100);
            $table->string('authorship');
            $table->string('taxonomic_state');
            $table->string('source');
            $table->string('publication');
            $table->string('collation');
            $table->string('page');
            $table->string('date');

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
        Schema::drop('plant_lists');
    }
}
