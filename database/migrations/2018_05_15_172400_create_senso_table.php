<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSensoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('senso', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_caballo');
            $table->unsignedInteger('id_dispositivo');
            $table->date('fecha');
            $table->time('hora_inicial');
            $table->time('hora_final');
            $table->text('intervalos');
            $table->text('grafica');
            $table->boolean('estado')->default(true);
            $table->unique(['id_dispositivo', 'fecha', 'hora_inicial', 'hora_final'], 'combinacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('senso');
    }

}
