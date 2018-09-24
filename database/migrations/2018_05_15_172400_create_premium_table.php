<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePremiumTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('premium', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_dispositivo', 20)->unique();
            $table->string('nombre', 30)->default('cincha');
            $table->string('marca_dispositivo', 20);
            $table->unsignedTinyInteger('tipo');
            $table->boolean('distribuidor');
            $table->string('token_mqtt', 30)->unique();
            $table->date('fecha_inicio_suscripcion')->nullable();
            $table->boolean('tipo_suscripcion')->default(0);
            $table->boolean('estado');
            $table->boolean('suscritos')->default(0);
            $table->unsignedInteger('id_caballo_activo')->default(0);
            $table->unsignedInteger('id_propietario')->default(0);
            $table->integer('id_lugar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('premium');
    }

}
