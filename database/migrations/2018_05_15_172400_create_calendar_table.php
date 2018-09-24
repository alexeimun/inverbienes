<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCalendarTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('calendar', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('title', 100);
            $table->date('date');
            $table->time('start_hour')->nullable();
            $table->time('final_hour')->nullable();
            $table->string('location')->nullable();
            $table->boolean('type');
            $table->unsignedInteger('user_id');
            $table->boolean('state')->default(true);
            $table->timestamps();
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
