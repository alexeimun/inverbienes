<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFamilyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('family', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_caballo');
            $table->unsignedInteger('id_caballo_familia');
            $table->boolean('parentesco');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('family');
    }

}
