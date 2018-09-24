<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsCalendarP1 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('calendar', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedSmallInteger('state_id')->nullable();
            $table->unsignedSmallInteger('city_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('calendar');
    }

}
