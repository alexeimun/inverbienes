<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ceo', 60)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('nit', 20)->nullable();
            $table->smallInteger('notary')->nullable();
            $table->string('protocolist_name')->nullable();
            $table->string('protocolist_phone', 10)->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('company');
    }

}
