<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePublicityTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('publicity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imagen', 500);
            $table->string('texto', 500);
            $table->string('empresa', 100);
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('abierta')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('publicity');
    }

}
