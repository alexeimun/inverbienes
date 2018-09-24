<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProofTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('proof', function (Blueprint $table) {
            $table->increments('id');
            $table->string('registro', 20);
            $table->string('nombre', 50);
            $table->date('fecha');
            $table->time('hora_inicial');
            $table->time('hora_final');
            $table->text('intervalos');
            $table->text('grafica');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('proof');
    }

}
