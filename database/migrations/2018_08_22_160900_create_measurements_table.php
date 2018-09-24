<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeasurementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ride_id')->nullable();
            $table->json('values')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('measurements');
    }

}
