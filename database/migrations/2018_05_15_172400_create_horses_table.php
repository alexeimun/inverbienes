<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHorsesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('horses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('registry', 20);
            $table->unsignedBigInteger('media_id');
            $table->date('birthdate')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->boolean('body_condition')->nullable();
            $table->boolean('race')->nullable();
            $table->string('location')->nullable();
            $table->unsignedTinyInteger('pass')->nullable();
            $table->boolean('genre')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedSmallInteger('state_id')->nullable();
            $table->unsignedSmallInteger('city_id')->nullable();
            $table->unsignedTinyInteger('type');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('colour')->nullable();
            $table->boolean('has_pregnancy')->nullable()->default(0);
            $table->date('pregnancy_date')->nullable();
            $table->string('bio', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('horses');
    }

}
