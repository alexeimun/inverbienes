<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('home', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('tipo')->nullable();
            $table->string('nombre', 50);
            $table->string('direccion', 200);
            $table->boolean('pais');
            $table->unsignedSmallInteger('departamento');
            $table->unsignedSmallInteger('ciudad');
            $table->string('contacto', 100);
            $table->unsignedBigInteger('telefono_contacto')->nullable();
            $table->unsignedBigInteger('celular_contacto')->nullable();
            $table->string('correo_contacto', 100)->nullable();
            $table->string('foto', 500)->nullable();
            $table->unsignedInteger('propietario');
            $table->string('estado', 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('home');
    }

}
