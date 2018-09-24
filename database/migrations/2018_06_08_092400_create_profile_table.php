<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfileTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->unsignedInteger('user_id');
            $table->unsignedSmallInteger('country_id')->nullable();
            $table->unsignedSmallInteger('state_id')->nullable();
            $table->unsignedSmallInteger('city_id')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('genre')->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('interests', 20)->nullable();
            $table->string('location')->nullable();
            $table->text('bio')->nullable();
            $table->enum('role', ['Usuario', 'Amante de los caballos',
                'Amazona', 'Montador', 'Criadero', 'Pesebrera'])->default('Usuario');
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
        Schema::drop('profile');
    }

}
