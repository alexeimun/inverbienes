<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImmovablesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('immovables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('debtor_id')->nullable();
            $table->unsignedSmallInteger('city_id')->nullable();
            $table->string('registration', 30)->nullable();
            $table->string('notary', 3)->nullable();
            $table->string('nearto')->nullable();
            $table->string('writting_number', 20)->nullable();
            $table->date('constitution')->nullable();
            $table->date('writting_delivery')->nullable();
            $table->enum('type', ['Apartamento', 'Oficina', 'Casa', 'Finca', 'Lote'])->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('immovables');
    }

}
