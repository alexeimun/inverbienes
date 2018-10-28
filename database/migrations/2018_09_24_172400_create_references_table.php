<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReferencesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('references', function (Blueprint $table) {
            $table->unsignedInteger('debtor_id')->nullable();
            $table->string('name', 50)->nullable();
            $table->enum('type', ['Familiar', 'Personal'])->nullable();
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
        Schema::drop('references');
    }

}
