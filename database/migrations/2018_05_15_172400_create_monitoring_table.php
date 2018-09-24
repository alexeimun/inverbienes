<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMonitoringTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('monitoring', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('tipo');
            $table->unsignedInteger('id_caballo');
            $table->dateTime('fecha_inicial');
            $table->dateTime('fecha_final');
            $table->text('dato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('monitoring');
    }

}
