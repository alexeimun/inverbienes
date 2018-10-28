<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsecutivesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('consecutives', function (Blueprint $table) {
            $table->integer('invoice');
            $table->integer('solicitude');
            $table->integer('daily_block');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('consecutives');
    }

}
