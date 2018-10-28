<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('movements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('mortgage_id')->nullable();
            $table->integer('consecutive');
            $table->unsignedTinyInteger('type')->nullable();
            $table->integer('value')->nullable();
            $table->unsignedSmallInteger('month')->nullable();
            $table->string('concept')->nullable();
            $table->date('period_extension')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('movements');
    }

}
