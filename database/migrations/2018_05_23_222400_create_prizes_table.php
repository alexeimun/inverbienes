<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrizesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->unsignedTinyInteger('position');
            $table->unsignedTinyInteger('category');
            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->unsignedTinyInteger('pass')->nullable();
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('horse_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('prizes');
    }

}
