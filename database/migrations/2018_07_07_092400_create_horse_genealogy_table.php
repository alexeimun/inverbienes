<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHorseGenealogyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('horse_genealogy', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('horse_id')->nullable();
            $table->string('father')->nullable();
            $table->string('paternal_father')->nullable();
            $table->string('paternal_mother')->nullable();
            $table->string('mother')->nullable();
            $table->string('maternal_father')->nullable();
            $table->string('maternal_mother')->nullable();
            $table->string('maternal_mother_registry')->nullable();
            $table->string('maternal_father_registry')->nullable();
            $table->string('mother_registry')->nullable();
            $table->string('paternal_mother_registry')->nullable();
            $table->string('paternal_father_registry')->nullable();
            $table->string('father_registry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('horse_genealogy');
    }

}
