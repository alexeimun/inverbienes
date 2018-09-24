<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRidesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bpm', 3)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('horse_id')->nullable();
            $table->json('time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('rides');
    }

}
