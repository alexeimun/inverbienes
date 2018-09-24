<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('events', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedInteger('id_anterior')->default(0);
            $table->unsignedInteger('id_caballo');
            $table->dateTime('fecha');
            $table->string('comentario', 100);
            $table->boolean('tipo');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('events');
    }

}
