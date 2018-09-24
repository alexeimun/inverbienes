<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCounterTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('counter', function (Blueprint $table) {
            $table->unsignedBigInteger('id_contenido');
            $table->unsignedInteger('id_usuario');
            $table->boolean('tipo');
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('counter');
    }

}
