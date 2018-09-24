<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHorseCertificatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('horse_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('horse_id')->nullable();
            $table->unsignedBigInteger('certificate_front_id')->nullable();
            $table->unsignedBigInteger('certificate_back_id')->nullable();
            $table->date('expedition')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('horse_certificates');
    }

}
